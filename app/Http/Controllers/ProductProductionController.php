<?php

namespace App\Http\Controllers;

use App\Due;
use App\Party;
use App\Product;
use App\ProductBrand;
use App\ProductCategory;
use App\ProductPurchase;
use App\ProductPurchaseDetail;
use App\ProductProduction;
use App\ProductProductionDetail;
use App\ProductSubCategory;
use App\ProductUnit;
use App\Stock;
use App\StockMinusLog;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Store;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductProductionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:product-production-list|product-production-create|product-production-edit|product-production-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-production-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-production-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-production-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        // just check where goes stock minus
        if(check_stock_minus_logs_exists() > 0){
            Toastr::warning('Stock went to minus, Please contact with administrator!', 'warning');
            return redirect()->route('home');
        }

        $auth_user_id = Auth::user()->id;
        $auth_user = Auth::user()->roles[0]->name;
        if($auth_user == "Admin"){
            $productProductions = ProductProduction::latest()->get();
        }else{
            $productProductions = ProductProduction::where('user_id',$auth_user_id)->latest()->get();
        }

        return view('backend.productProduction.index',compact('productProductions'));
    }


    public function create()
    {
        $auth_user_id = Auth::user()->id;
        $auth_user = Auth::user()->roles[0]->name;
        if($auth_user == "Admin"){
            $stores = Store::all();
        }else{
            $stores = Store::where('user_id',$auth_user_id)->get();
        }
        $productCategories = ProductCategory::all();
        $productSubCategories = ProductSubCategory::all();
        $productBrands = ProductBrand::all();
        $productUnits = ProductUnit::all();
        $products = Product::where('product_type','Raw Materials')->get();
        $finishGoodProducts = Product::where('product_type','Finish Goods')->get();
        return view('backend.productProduction.create',compact('stores','products','productCategories','productSubCategories','productBrands','productUnits','finishGoodProducts'));
    }


    public function store(Request $request)
    {
        //dd($request->all());

        $own_party_id = Party::where('type','own')->pluck('id')->first();
        if($own_party_id == null){
            Toastr::warning('First Created A Own Type Party', 'Warning');
            return redirect()->route('productProductions.index');
        }

        if($request->products == 2){
            $this->validate($request, [
                'store_id'=> 'required',
                'product_id'=> 'required',
                'qty'=> 'required',
                'existing_product_id'=> 'required',
                'existing_qty'=> 'required',
                'existing_price'=> 'required',
                'existing_mrp_price'=> 'required',
            ]);

            $row_count = count($request->product_id);
            $total_amount = 0;
            for($i=0; $i<$row_count;$i++)
            {
                $total_amount += $request->sub_total[$i];
            }

            // product Production
            $productProduction = new ProductProduction();
            $productProduction->user_id = Auth::id();
            $productProduction->store_id = $request->store_id;
            $productProduction->total_amount = $total_amount;
            $productProduction->paid_amount = 0;
            $productProduction->due_amount = $total_amount;
            $productProduction->date = $request->date;
            $productProduction->save();
            $insert_id = $productProduction->id;
            if($insert_id)
            {
                for($i=0; $i<$row_count;$i++)
                {
                    // product production detail
                    $purchase_production_detail = new ProductProductionDetail();
                    $purchase_production_detail->product_production_id = $insert_id;
                    $purchase_production_detail->product_category_id = $request->product_category_id[$i];
                    $purchase_production_detail->product_sub_category_id = $request->product_sub_category_id[$i] ? $request->product_sub_category_id[$i] : NULL;
                    $purchase_production_detail->product_brand_id = $request->product_brand_id[$i];
                    $purchase_production_detail->product_id = $request->product_id[$i];
                    $purchase_production_detail->qty = $request->qty[$i];
                    $purchase_production_detail->production = $request->production[$i];
                    $purchase_production_detail->price = $request->price[$i];
                    $purchase_production_detail->sub_total = $request->qty[$i]*$request->price[$i];
                    $purchase_production_detail->save();

                    $product_id = $request->product_id[$i];
                    $check_previous_stock = Stock::where('product_id',$product_id)->latest()->pluck('current_stock')->first();
                    if(!empty($check_previous_stock)){
                        $previous_stock = $check_previous_stock;
                    }else{
                        $previous_stock = 0;
                    }
                    // product stock
                    $stock = new Stock();
                    $stock->user_id = Auth::id();
                    $stock->ref_id = $insert_id;
                    $stock->store_id = $request->store_id;
                    $stock->date = $request->date;
                    $stock->product_id = $request->product_id[$i];
                    $stock->stock_product_type = 'Raw Materials';
                    $stock->stock_type = 'production';
                    $stock->previous_stock = $previous_stock;
                    $stock->stock_in = 0;
                    $stock->stock_out = $request->qty[$i];
                    $stock->current_stock = $previous_stock - $request->qty[$i];
                    $stock->save();

                    // stock minus log
                    if($stock->current_stock < 0){
                        $stock_minus_log = new StockMinusLog();
                        $stock_minus_log->user_id=Auth::user()->id;
                        $stock_minus_log->action_module='Product Production';
                        $stock_minus_log->action_done='Store';
                        $stock_minus_log->action_remarks='Product Production ID: '.$insert_id;
                        $stock_minus_log->action_date=date('Y-m-d');
                        $stock_minus_log->save();
                    }
                }

                // transaction
                $transaction = new Transaction();
                $transaction->invoice_no = NULL;
                $transaction->user_id = Auth::id();
                $transaction->store_id = $request->store_id;
                $transaction->party_id = $own_party_id;
                $transaction->date = $request->date;
                $transaction->ref_id = $insert_id;
                $transaction->transaction_product_type = 'Raw Materials';
                $transaction->transaction_type = 'production';
                $transaction->payment_type = $request->payment_type;
                $transaction->check_number = $request->check_number ? $request->check_number : '';
                $transaction->amount = $total_amount;
                $transaction->save();






                // for stock in

                // product purchase
                $productPurchase = new ProductPurchase();
                $productPurchase ->party_id = $own_party_id;
                $productPurchase ->store_id = $request->store_id;
                $productPurchase ->user_id = Auth::id();
                $productPurchase ->date = $request->date;
                $productPurchase ->total_amount = $total_amount;
                $productPurchase ->purchase_product_type = 'Finish Goods';
                $productPurchase->ref_id = $insert_id;
                $productPurchase->save();
                $purchase_insert_id = $productPurchase->id;
                if($purchase_insert_id)
                {
                    $product_info = Product::where('id',$request->existing_product_id)->first();

                    // product purchase detail
                    $purchase_purchase_detail = new ProductPurchaseDetail();
                    $purchase_purchase_detail->product_purchase_id = $purchase_insert_id;
                    $purchase_purchase_detail->product_category_id = $product_info->product_category_id;
                    $purchase_purchase_detail->product_sub_category_id = $product_info->product_sub_category_id ? $product_info->product_sub_category_id : NULL;
                    $purchase_purchase_detail->product_brand_id = $product_info->product_brand_id;
                    $purchase_purchase_detail->product_id = $product_info->id;
                    $purchase_purchase_detail->qty = $request->existing_qty;
                    $purchase_purchase_detail->price = $request->existing_price;
                    $purchase_purchase_detail->mrp_price = $request->existing_mrp_price;
                    $purchase_purchase_detail->sub_total = $request->existing_qty*$request->existing_price;
                    $purchase_purchase_detail->barcode = $product_info->barcode;
                    $purchase_purchase_detail->ref_id = $insert_id;
                    $purchase_purchase_detail->save();

                    $check_previous_stock = Stock::where('product_id',$product_info->id)->latest()->pluck('current_stock')->first();
                    if(!empty($check_previous_stock)){
                        $previous_stock = $check_previous_stock;
                    }else{
                        $previous_stock = 0;
                    }
                    // product stock
                    $stock = new Stock();
                    $stock->user_id = Auth::id();
                    $stock->ref_id = $insert_id;
                    $stock->store_id = $request->store_id;
                    $stock->date = $request->date;
                    $stock->product_id = $product_info->id;
                    $stock->stock_product_type = 'Finish Goods';
                    $stock->stock_type = 'production';
                    $stock->previous_stock = $previous_stock;
                    $stock->stock_in = $request->existing_qty;
                    $stock->stock_out = 0;
                    $stock->current_stock = $previous_stock + $request->existing_qty;
                    $stock->save();

                    // stock minus log
                    if($stock->current_stock < 0){
                        $stock_minus_log = new StockMinusLog();
                        $stock_minus_log->user_id=Auth::user()->id;
                        $stock_minus_log->action_module='Product Production';
                        $stock_minus_log->action_done='Store';
                        $stock_minus_log->action_remarks='Product Production ID: '.$insert_id;
                        $stock_minus_log->action_date=date('Y-m-d');
                        $stock_minus_log->save();
                    }


                    // transaction
                    $transaction = new Transaction();
                    $transaction->invoice_no = NULL;
                    $transaction->user_id = Auth::id();
                    $transaction->store_id = $request->store_id;
                    $transaction->party_id = $own_party_id;
                    $transaction->date = $request->date;
                    $transaction->ref_id = $insert_id;
                    $transaction->transaction_product_type = 'Finish Goods';
                    $transaction->transaction_type = 'production';
                    $transaction->payment_type = $request->payment_type;
                    $transaction->check_number = $request->check_number ? $request->check_number : '';
                    $transaction->amount = $request->existing_price;
                    $transaction->save();
                }
            }

            Toastr::success('Product Production Created Successfully', 'Success');
            return redirect()->route('productProductions.index');
        }elseif($request->products == 3){
            $this->validate($request, [
                'store_id'=> 'required',
                'model' => 'required',
                'name' => 'required',
                'barcode' => 'required',
                'new_qty' => 'required',
                'new_price' => 'required',
                'new_mrp_price' => 'required',
                'new_product_category_id' => 'required',
                //'product_sub_category_id' => 'required',
                'new_product_brand_id' => 'required',
                'new_product_unit_id' => 'required',
            ]);

            $row_count = count($request->product_id);
            $total_amount = 0;
            for($i=0; $i<$row_count;$i++)
            {
                $total_amount += $request->sub_total[$i];
            }

            // product Production
            $productProduction = new ProductProduction();
            $productProduction->user_id = Auth::id();
            $productProduction->store_id = $request->store_id;
            $productProduction->total_amount = $total_amount;
            $productProduction->paid_amount = 0;
            $productProduction->due_amount = $total_amount;
            $productProduction->date = $request->date;
            $productProduction->save();
            $insert_id = $productProduction->id;
            if($insert_id)
            {
                for($i=0; $i<$row_count;$i++)
                {
                    // product production detail
                    $purchase_production_detail = new ProductProductionDetail();
                    $purchase_production_detail->product_production_id = $insert_id;
                    $purchase_production_detail->product_category_id = $request->product_category_id[$i];
                    $purchase_production_detail->product_sub_category_id = $request->product_sub_category_id[$i] ? $request->product_sub_category_id[$i] : NULL;
                    $purchase_production_detail->product_brand_id = $request->product_brand_id[$i];
                    $purchase_production_detail->product_id = $request->product_id[$i];
                    $purchase_production_detail->qty = $request->qty[$i];
                    $purchase_production_detail->production = $request->production[$i];
                    $purchase_production_detail->price = $request->price[$i];
                    $purchase_production_detail->sub_total = $request->qty[$i]*$request->price[$i];
                    $purchase_production_detail->save();

                    $product_id = $request->product_id[$i];
                    $check_previous_stock = Stock::where('product_id',$product_id)->latest()->pluck('current_stock')->first();
                    if(!empty($check_previous_stock)){
                        $previous_stock = $check_previous_stock;
                    }else{
                        $previous_stock = 0;
                    }
                    // product stock
                    $stock = new Stock();
                    $stock->user_id = Auth::id();
                    $stock->ref_id = $insert_id;
                    $stock->store_id = $request->store_id;
                    $stock->date = $request->date;
                    $stock->product_id = $request->product_id[$i];
                    $stock->stock_product_type = 'Raw Materials';
                    $stock->stock_type = 'production';
                    $stock->previous_stock = $previous_stock;
                    $stock->stock_in = 0;
                    $stock->stock_out = $request->qty[$i];
                    $stock->current_stock = $previous_stock - $request->qty[$i];
                    $stock->save();

                    // stock minus log
                    if($stock->current_stock < 0){
                        $stock_minus_log = new StockMinusLog();
                        $stock_minus_log->user_id=Auth::user()->id;
                        $stock_minus_log->action_module='Product Production';
                        $stock_minus_log->action_done='Store';
                        $stock_minus_log->action_remarks='Product Production ID: '.$insert_id;
                        $stock_minus_log->action_date=date('Y-m-d');
                        $stock_minus_log->save();
                    }
                }

                // transaction
                $transaction = new Transaction();
                $transaction->invoice_no = NULL;
                $transaction->user_id = Auth::id();
                $transaction->store_id = $request->store_id;
                $transaction->party_id = $own_party_id;
                $transaction->date = $request->date;
                $transaction->ref_id = $insert_id;
                $transaction->transaction_product_type = 'Raw Materials';
                $transaction->transaction_type = 'production';
                $transaction->payment_type = $request->payment_type;
                $transaction->check_number = $request->check_number ? $request->check_number : '';
                $transaction->amount = $total_amount;
                $transaction->save();






                // new product create
                $product_name = $request->name . '.' . $request->model;
                $product = new Product;
                $product->product_type = $request->product_type;
                $product->barcode = $request->barcode;
                //$product->name = $request->name;
                $product->name = $product_name;
                //$product->slug = Str::slug($request->name);
                $product->slug = Str::slug($product_name);
                $product->product_category_id = $request->new_product_category_id;
                $product->product_sub_category_id = Null;
                $product->product_brand_id = $request->new_product_brand_id;
                $product->product_unit_id = $request->new_product_unit_id;
                $product->description = $request->description;
                $product->model = $request->model;
                $product->status = $request->status;
                $image = $request->file('image');
                if (isset($image)) {
                    //make unique name for image
                    $currentDate = Carbon::now()->toDateString();
                    $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
//            resize image for hospital and upload
                    $proImage =Image::make($image)->resize(300, 300)->save($image->getClientOriginalExtension());
                    Storage::disk('public')->put('uploads/product/'.$imagename, $proImage);


                }else {
                    $imagename = "default.png";
                }

                $product->image = $imagename;
                $product->save();
                $new_product_insert_id = $product->id;

                if($new_product_insert_id){
                    // for stock in
                    // product purchase
                    $productPurchase = new ProductPurchase();
                    $productPurchase ->party_id = $own_party_id;
                    $productPurchase ->store_id = $request->store_id;
                    $productPurchase ->user_id = Auth::id();
                    $productPurchase ->date = $request->date;
                    $productPurchase ->total_amount = $request->new_price;
                    $productPurchase ->purchase_product_type = 'Finish Goods';
                    $productPurchase->save();
                    $purchase_insert_id = $productPurchase->id;
                    if($purchase_insert_id)
                    {
                        $product_info = Product::where('id',$new_product_insert_id)->latest()->first();

                        // product purchase detail
                        $purchase_purchase_detail = new ProductPurchaseDetail();
                        $purchase_purchase_detail->product_purchase_id = $purchase_insert_id;
                        $purchase_purchase_detail->product_category_id = $product_info->product_category_id;
                        $purchase_purchase_detail->product_sub_category_id = $product_info->product_sub_category_id ? $product_info->product_sub_category_id : NULL;
                        $purchase_purchase_detail->product_brand_id = $product_info->product_brand_id;
                        $purchase_purchase_detail->product_id = $new_product_insert_id;
                        $purchase_purchase_detail->qty = $request->new_qty;
                        $purchase_purchase_detail->price = $request->new_price;
                        $purchase_purchase_detail->mrp_price = $request->new_mrp_price;
                        $purchase_purchase_detail->sub_total = $request->new_qty*$request->new_mrp_price;
                        $purchase_purchase_detail->barcode = $product_info->barcode;
                        $purchase_purchase_detail->ref_id = $insert_id;
                        $purchase_purchase_detail->save();

                        $check_previous_stock = Stock::where('product_id',$new_product_insert_id->id)->latest()->pluck('current_stock')->first();
                        if(!empty($check_previous_stock)){
                            $previous_stock = $check_previous_stock;
                        }else{
                            $previous_stock = 0;
                        }
                        // product stock
                        $stock = new Stock();
                        $stock->user_id = Auth::id();
                        $stock->ref_id = $insert_id;
                        $stock->store_id = $request->store_id;
                        $stock->date = $request->date;
                        $stock->product_id = $product_info->id;
                        $stock->stock_product_type = 'Finish Goods';
                        $stock->stock_type = 'production';
                        $stock->previous_stock = $previous_stock;
                        $stock->stock_in = $request->new_qty;
                        $stock->stock_out = 0;
                        $stock->current_stock = $previous_stock + $request->new_qty;
                        $stock->save();

                        // stock minus log
                        if($stock->current_stock < 0){
                            $stock_minus_log = new StockMinusLog();
                            $stock_minus_log->user_id=Auth::user()->id;
                            $stock_minus_log->action_module='Product Production';
                            $stock_minus_log->action_done='Store';
                            $stock_minus_log->action_remarks='Product Production ID: '.$insert_id;
                            $stock_minus_log->action_date=date('Y-m-d');
                            $stock_minus_log->save();
                        }


                        // transaction
                        $transaction = new Transaction();
                        $transaction->invoice_no = NULL;
                        $transaction->user_id = Auth::id();
                        $transaction->store_id = $request->store_id;
                        $transaction->party_id = $own_party_id;
                        $transaction->date = $request->date;
                        $transaction->ref_id = $insert_id;
                        $transaction->transaction_product_type = 'Finish Goods';
                        $transaction->transaction_type = 'production';
                        $transaction->payment_type = $request->payment_type;
                        $transaction->check_number = $request->check_number ? $request->check_number : '';
                        $transaction->amount = $request->new_price;
                        $transaction->save();
                    }
                }
            }

            Toastr::success('Product Production Created Successfully', 'Success');
            return redirect()->route('productProductions.index');
        }else{
            return redirect()->back();
        }

    }


    public function show($id)
    {
        $productProduction = ProductProduction::find($id);
        $productProductionDetails = ProductProductionDetail::where('product_production_id',$id)->get();
        $transactions = Transaction::where('ref_id',$id)->get();

        $productPurchase = ProductPurchase::where('ref_id',$id)->first();
        $productPurchaseDetail = ProductPurchaseDetail::where('ref_id',$id)->first();

        return view('backend.productProduction.show', compact('productProduction','productProductionDetails','transactions','productPurchase','productPurchaseDetail'));
    }


    public function edit($id)
    {
        $auth_user_id = Auth::user()->id;
        $auth_user = Auth::user()->roles[0]->name;
        if($auth_user == "Admin"){
            $stores = Store::all();
        }else{
            $stores = Store::where('user_id',$auth_user_id)->get();
        }

        $products = Product::where('product_type','Raw Materials')->get();
        $finishGoodProducts = Product::where('product_type','Finish Goods')->get();
        $productProduction = ProductProduction::find($id);
        $productCategories = ProductCategory::all();
        $productSubCategories = ProductSubCategory::all();
        $productBrands = ProductBrand::all();
        $productUnits = ProductUnit::all();
        $productProductionDetails = ProductProductionDetail::where('product_production_id',$id)->get();
        $transaction = Transaction::where('ref_id',$id)->first();
        $stock_finish_goods = Stock::where('ref_id',$id)->where('stock_type','production')->where('stock_product_type','Finish Goods')->first();
        $productPurchaseDetails = ProductPurchaseDetail::where('ref_id',$id)->latest()->first();
        //dd($productPurchaseDetails);

        return view('backend.productProduction.edit',compact('stores','products','finishGoodProducts','productProduction','productProductionDetails','productCategories','productSubCategories','productBrands','productUnits','transaction','stock_finish_goods','productPurchaseDetails'));
    }


    public function update(Request $request, $id)
    {
        //dd($request->all());


        $own_party_id = Party::where('type','own')->pluck('id')->first();
        if($own_party_id == null){
            Toastr::warning('First Created A Own Type Party, For Production to Finish Goods Create!', 'Warning');
            return redirect()->route('productProductions.index');
        }

        if($request->products == 2){
            $this->validate($request, [
                'store_id'=> 'required',
                'product_id'=> 'required',
                'qty'=> 'required',
                'existing_product_id'=> 'required',
                'existing_qty'=> 'required',
                'existing_price'=> 'required',
                'existing_mrp_price'=> 'required',
            ]);

            $store_id = $request->store_id;
            $row_count = count($request->product_id);
            $total_amount = 0;
            for($i=0; $i<$row_count;$i++)
            {
                $total_amount += $request->sub_total[$i];
            }

            // product Production
            $productProduction = ProductProduction::find($id);
            $productProduction->user_id = Auth::id();
            $productProduction->store_id = $store_id;
            $productProduction->total_amount = $total_amount;
            $productProduction->due_amount = $total_amount;
            $productProduction->date = $request->date;
            $productProduction->update();

            for($i=0; $i<$row_count;$i++)
            {
                // product purchase detail
                $product_production_detail_id = $request->product_production_detail_id[$i];
                $purchase_production_detail = ProductProductionDetail::findOrFail($product_production_detail_id);
                $purchase_production_detail->product_category_id = $request->product_category_id[$i];
                $purchase_production_detail->product_sub_category_id = $request->product_sub_category_id[$i] ? $request->product_sub_category_id[$i] : NULL;
                $purchase_production_detail->product_brand_id = $request->product_brand_id[$i];
                $purchase_production_detail->product_id = $request->product_id[$i];
                $purchase_production_detail->qty = $request->qty[$i];
                //$purchase_production_detail->production = $request->production[$i];
                $purchase_production_detail->price = $request->price[$i];
                $purchase_production_detail->sub_total = $request->qty[$i]*$request->price[$i];
                $purchase_production_detail->update();


                // product stock out
                $stock_row = Stock::where('ref_id',$id)->where('stock_type','production')->where('stock_product_type','Raw Materials')->first();

                if($stock_row->stock_out != $request->qty[$i]){

                    if($request->qty[$i] > $stock_row->stock_out){
                        $add_or_minus_stock_out = $request->qty[$i] - $stock_row->stock_out;
                        $update_stock_out = $stock_row->stock_out + $add_or_minus_stock_out;
                        $update_current_stock = $stock_row->current_stock + $add_or_minus_stock_out;
                    }else{
                        $add_or_minus_stock_out =  $stock_row->stock_out - $request->qty[$i];
                        $update_stock_out = $stock_row->stock_out - $add_or_minus_stock_out;
                        $update_current_stock = $stock_row->current_stock - $add_or_minus_stock_out;
                    }

                    $stock_row->user_id = Auth::user()->id;
                    $stock_row->stock_out = $update_stock_out;
                    $stock_row->current_stock = $update_current_stock;
                    $stock_row->update();

                    // stock minus log
                    if($stock_row->current_stock < 0){
                        $stock_minus_log = new StockMinusLog();
                        $stock_minus_log->user_id=Auth::user()->id;
                        $stock_minus_log->action_module='Product Production';
                        $stock_minus_log->action_done='Update';
                        $stock_minus_log->action_remarks='Product Production ID: '.$id;
                        $stock_minus_log->action_date=date('Y-m-d');
                        $stock_minus_log->save();
                    }
                }
            }

            // transaction
            $transaction = Transaction::where('ref_id',$id)->where('transaction_type','production')->where('transaction_product_type','Raw Materials')->first();
            $transaction->user_id = Auth::id();
            $transaction->store_id = $store_id;
            $transaction->date = $request->date;
            $transaction->transaction_product_type = 'Raw Materials';
            $transaction->transaction_type = 'production';
            $transaction->amount = $total_amount;
            $transaction->update();






            // for stock in

            // product purchase
            $productPurchase = ProductPurchase::where('ref_id',$id)->where('purchase_product_type','Finish Goods')->first();
            $productPurchase->store_id = $store_id;
            $productPurchase->user_id = Auth::id();
            $productPurchase->date = $request->date;
            $productPurchase->total_amount = $request->existing_qty*$request->existing_price;
            $productPurchase->update();

            $product_info = Product::where('id',$request->existing_product_id)->first();

            // product purchase detail
            $purchase_purchase_detail = ProductPurchaseDetail::where('ref_id',$id)->first();
            $purchase_purchase_detail->product_purchase_id = $productPurchase->id;
            $purchase_purchase_detail->product_category_id = $product_info->product_category_id;
            $purchase_purchase_detail->product_brand_id = $product_info->product_brand_id;
            $purchase_purchase_detail->product_id = $product_info->id;
            $purchase_purchase_detail->qty = $request->existing_qty;
            $purchase_purchase_detail->price = $request->existing_price;
            $purchase_purchase_detail->mrp_price = $request->existing_mrp_price;
            $purchase_purchase_detail->sub_total = $request->existing_qty*$request->existing_price;
            $purchase_purchase_detail->update();

            // product stock in
            $stock_row = Stock::where('ref_id',$id)->where('stock_type','production')->where('stock_product_type','Finish Goods')->latest()->first();

            if($stock_row->stock_in != $request->existing_qty){

                if($request->existing_qty > $stock_row->stock_in){
                    $add_or_minus_stock_in = $request->existing_qty - $stock_row->stock_in;
                    $update_stock_in = $stock_row->stock_in + $add_or_minus_stock_in;
                    //$update_current_stock = $stock_row->current_stock + $add_or_minus_stock_in;
                    $update_current_stock = $stock_row->current_stock + $update_stock_in;
                }else{
                    $add_or_minus_stock_in =  $stock_row->stock_in - $request->existing_qty;
                    $update_stock_in = $stock_row->stock_in - $add_or_minus_stock_in;
                    //$update_current_stock = $stock_row->current_stock - $add_or_minus_stock_in;
                    $update_current_stock = $stock_row->current_stock - $update_stock_in;
                }

                $stock_row->user_id = Auth::user()->id;
                $stock_row->stock_in = $update_stock_in;
                $stock_row->current_stock = $update_current_stock;
                $stock_row->update();

                // stock minus log
                if($stock_row->current_stock < 0){
                    $stock_minus_log = new StockMinusLog();
                    $stock_minus_log->user_id=Auth::user()->id;
                    $stock_minus_log->action_module='Product Production';
                    $stock_minus_log->action_done='Update';
                    $stock_minus_log->action_remarks='Product Production ID: '.$id;
                    $stock_minus_log->action_date=date('Y-m-d');
                    $stock_minus_log->save();
                }
            }


            // transaction
            $transaction = Transaction::where('ref_id',$id)->where('transaction_type','production')->where('transaction_product_type','Finish Goods')->first();
            $transaction->user_id = Auth::id();
            $transaction->store_id = $store_id;
            $transaction->date = $request->date;
            $transaction->amount = $request->existing_price;
            $transaction->update();


            Toastr::success('Product Production Created Successfully', 'Success');
            return redirect()->route('productProductions.index');
        }elseif($request->products == 3){
//            $this->validate($request, [
//                'store_id'=> 'required',
//                'model' => 'required',
//                'name' => 'required',
//                'barcode' => 'required',
//                'new_qty' => 'required',
//                'new_price' => 'required',
//                'new_mrp_price' => 'required',
//                'new_product_category_id' => 'required',
//                //'product_sub_category_id' => 'required',
//                'new_product_brand_id' => 'required',
//                'new_product_unit_id' => 'required',
//            ]);
//
//            $row_count = count($request->product_id);
//            $total_amount = 0;
//            for($i=0; $i<$row_count;$i++)
//            {
//                $total_amount += $request->sub_total[$i];
//            }
//
//            // product Production
//            $productProduction = new ProductProduction();
//            $productProduction->user_id = Auth::id();
//            $productProduction->store_id = $request->store_id;
//            $productProduction->total_amount = $total_amount;
//            $productProduction->paid_amount = 0;
//            $productProduction->due_amount = $total_amount;
//            $productProduction->date = $request->date;
//            $productProduction->save();
//            $insert_id = $productProduction->id;
//            if($insert_id)
//            {
//                for($i=0; $i<$row_count;$i++)
//                {
//                    // product production detail
//                    $purchase_production_detail = new ProductProductionDetail();
//                    $purchase_production_detail->product_production_id = $insert_id;
//                    $purchase_production_detail->product_category_id = $request->product_category_id[$i];
//                    $purchase_production_detail->product_sub_category_id = $request->product_sub_category_id[$i] ? $request->product_sub_category_id[$i] : NULL;
//                    $purchase_production_detail->product_brand_id = $request->product_brand_id[$i];
//                    $purchase_production_detail->product_id = $request->product_id[$i];
//                    $purchase_production_detail->qty = $request->qty[$i];
//                    $purchase_production_detail->production = $request->production[$i];
//                    $purchase_production_detail->price = $request->price[$i];
//                    $purchase_production_detail->sub_total = $request->qty[$i]*$request->price[$i];
//                    $purchase_production_detail->save();
//
//                    $product_id = $request->product_id[$i];
//                    $check_previous_stock = Stock::where('product_id',$product_id)->latest()->pluck('current_stock')->first();
//                    if(!empty($check_previous_stock)){
//                        $previous_stock = $check_previous_stock;
//                    }else{
//                        $previous_stock = 0;
//                    }
//                    // product stock
//                    $stock = new Stock();
//                    $stock->user_id = Auth::id();
//                    $stock->ref_id = $insert_id;
//                    $stock->store_id = $request->store_id;
//                    $stock->date = $request->date;
//                    $stock->product_id = $request->product_id[$i];
//                    $stock->stock_product_type = 'Raw Materials';
//                    $stock->stock_type = 'production';
//                    $stock->previous_stock = $previous_stock;
//                    $stock->stock_in = 0;
//                    $stock->stock_out = $request->qty[$i];
//                    $stock->current_stock = $previous_stock - $request->qty[$i];
//                    $stock->save();
//                }
//
//                // transaction
//                $transaction = new Transaction();
//                $transaction->invoice_no = NULL;
//                $transaction->user_id = Auth::id();
//                $transaction->store_id = $request->store_id;
//                $transaction->party_id = $own_party_id;
//                $transaction->date = $request->date;
//                $transaction->ref_id = $insert_id;
//                $transaction->transaction_product_type = 'Raw Materials';
//                $transaction->transaction_type = 'production';
//                $transaction->payment_type = $request->payment_type;
//                $transaction->check_number = $request->check_number ? $request->check_number : '';
//                $transaction->amount = $total_amount;
//                $transaction->save();
//
//
//
//
//
//
//                // new product create
//                $product_name = $request->name . '.' . $request->model;
//                $product = new Product;
//                $product->product_type = $request->product_type;
//                $product->barcode = $request->barcode;
//                //$product->name = $request->name;
//                $product->name = $product_name;
//                //$product->slug = Str::slug($request->name);
//                $product->slug = Str::slug($product_name);
//                $product->product_category_id = $request->new_product_category_id;
//                $product->product_sub_category_id = Null;
//                $product->product_brand_id = $request->new_product_brand_id;
//                $product->product_unit_id = $request->new_product_unit_id;
//                $product->description = $request->description;
//                $product->model = $request->model;
//                $product->status = $request->status;
//                $image = $request->file('image');
//                if (isset($image)) {
//                    //make unique name for image
//                    $currentDate = Carbon::now()->toDateString();
//                    $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
////            resize image for hospital and upload
//                    $proImage =Image::make($image)->resize(300, 300)->save($image->getClientOriginalExtension());
//                    Storage::disk('public')->put('uploads/product/'.$imagename, $proImage);
//
//
//                }else {
//                    $imagename = "default.png";
//                }
//
//                $product->image = $imagename;
//                $product->save();
//                $new_product_insert_id = $product->id;
//
//                if($new_product_insert_id){
//                    // for stock in
//                    // product purchase
//                    $productPurchase = new ProductPurchase();
//                    $productPurchase ->party_id = $own_party_id;
//                    $productPurchase ->store_id = $request->store_id;
//                    $productPurchase ->user_id = Auth::id();
//                    $productPurchase ->date = $request->date;
//                    $productPurchase ->total_amount = $request->new_price;
//                    $productPurchase ->purchase_product_type = 'Finish Goods';
//                    $productPurchase->save();
//                    $purchase_insert_id = $productPurchase->id;
//                    if($purchase_insert_id)
//                    {
//                        $product_info = Product::where('id',$new_product_insert_id)->latest()->first();
//
//                        // product purchase detail
//                        $purchase_purchase_detail = new ProductPurchaseDetail();
//                        $purchase_purchase_detail->product_purchase_id = $purchase_insert_id;
//                        $purchase_purchase_detail->product_category_id = $product_info->product_category_id;
//                        $purchase_purchase_detail->product_sub_category_id = $product_info->product_sub_category_id ? $product_info->product_sub_category_id : NULL;
//                        $purchase_purchase_detail->product_brand_id = $product_info->product_brand_id;
//                        $purchase_purchase_detail->product_id = $new_product_insert_id;
//                        $purchase_purchase_detail->qty = $request->new_qty;
//                        $purchase_purchase_detail->price = $request->new_price;
//                        $purchase_purchase_detail->mrp_price = $request->new_mrp_price;
//                        $purchase_purchase_detail->sub_total = $request->new_qty*$request->new_mrp_price;
//                        $purchase_purchase_detail->barcode = $product_info->barcode;
//                        $purchase_purchase_detail->save();
//
//                        $check_previous_stock = Stock::where('product_id',$new_product_insert_id->id)->latest()->pluck('current_stock')->first();
//                        if(!empty($check_previous_stock)){
//                            $previous_stock = $check_previous_stock;
//                        }else{
//                            $previous_stock = 0;
//                        }
//                        // product stock
//                        $stock = new Stock();
//                        $stock->user_id = Auth::id();
//                        $stock->ref_id = $insert_id;
//                        $stock->store_id = $request->store_id;
//                        $stock->date = $request->date;
//                        $stock->product_id = $product_info->id;
//                        $stock->stock_product_type = 'Finish Goods';
//                        $stock->stock_type = 'production';
//                        $stock->previous_stock = $previous_stock;
//                        $stock->stock_in = $request->new_qty;
//                        $stock->stock_out = 0;
//                        $stock->current_stock = $previous_stock - $request->new_qty;
//                        $stock->save();
//
//
//                        // transaction
//                        $transaction = new Transaction();
//                        $transaction->invoice_no = NULL;
//                        $transaction->user_id = Auth::id();
//                        $transaction->store_id = $request->store_id;
//                        $transaction->party_id = $own_party_id;
//                        $transaction->date = $request->date;
//                        $transaction->ref_id = $insert_id;
//                        $transaction->transaction_product_type = 'Finish Goods';
//                        $transaction->transaction_type = 'production';
//                        $transaction->payment_type = $request->payment_type;
//                        $transaction->check_number = $request->check_number ? $request->check_number : '';
//                        $transaction->amount = $request->new_price;
//                        $transaction->save();
//                    }
//                }
//            }
//
//            Toastr::success('Product Production Created Successfully', 'Success');
//            return redirect()->route('productProductions.index');
        }else{
            return redirect()->back();
        }
    }


    public function destroy($id)
    {
        $productProduction = ProductProduction::find($id);
        $productProduction->delete();

        DB::table('product_production_details')->where('product_production_id',$id)->delete();
        DB::table('product_purchases')->where('ref',$id)->where('purchase_product_type','Finish Goods')->delete();
        $product_purchase_id = DB::table('product_purchases')->where('ref',$id)->where('purchase_product_type','Finish Goods')->pluck('id')->first();
        DB::table('product_purchase_details')->where('ref',$id)->where('product_purchase_id',$product_purchase_id)->delete();
        DB::table('stocks')->where('ref_id',$id)->delete();
        DB::table('transactions')->where('ref_id',$id)->delete();

        Toastr::success('Product Sale Deleted Successfully', 'Success');
        return redirect()->route('productProductions.index');
    }

    public function productProductionRelationData(Request $request){
        $store_id = $request->store_id;
        $product_id = $request->current_product_id;
        $current_stock = Stock::where('store_id',$store_id)->where('product_id',$product_id)->latest()->pluck('current_stock')->first();
        $mrp_price = ProductPurchaseDetail::join('product_purchases', 'product_purchase_details.product_purchase_id', '=', 'product_purchases.id')
            ->where('store_id',$store_id)->where('product_id',$product_id)
            ->latest('product_purchase_details.id')
            ->pluck('product_purchase_details.price')
            ->first();

        $product_category_id = Product::where('id',$product_id)->pluck('product_category_id')->first();
        $product_sub_category_id = Product::where('id',$product_id)->pluck('product_sub_category_id')->first();
        $product_brand_id = Product::where('id',$product_id)->pluck('product_brand_id')->first();
        $options = [
            'mrp_price' => $mrp_price,
            'current_stock' => $current_stock,
            'categoryOptions' => '',
            'subCategoryOptions' => '',
            'brandOptions' => '',
        ];

        if($product_category_id){
            $categories = ProductCategory::where('id',$product_category_id)->get();
            if(count($categories) > 0){
                $options['categoryOptions'] = "<select class='form-control' name='product_category_id[]' readonly>";
                foreach($categories as $category){
                    $options['categoryOptions'] .= "<option value='$category->id'>$category->name</option>";
                }
                $options['categoryOptions'] .= "</select>";
            }
        }else{
            $options['categoryOptions'] = "<select class='form-control' name='product_sub_category_id[]' readonly>";
            $options['categoryOptions'] .= "<option value=''>No Data Found!</option>";
            $options['categoryOptions'] .= "</select>";
        }
        if(!empty($product_sub_category_id)){
            $subCategories = ProductSubCategory::where('id',$product_sub_category_id)->get();
            if(count($subCategories) > 0){
                $options['subCategoryOptions'] = "<select class='form-control' name='product_sub_category_id[]' readonly>";
                foreach($subCategories as $subCategory){
                    $options['subCategoryOptions'] .= "<option value='$subCategory->id'>$subCategory->name</option>";
                }
                $options['subCategoryOptions'] .= "</select>";
            }
        }else{
            $options['subCategoryOptions'] = "<select class='form-control' name='product_sub_category_id[]' readonly>";
            $options['subCategoryOptions'] .= "<option value=''>No Data Found!</option>";
            $options['subCategoryOptions'] .= "</select>";
        }
        if($product_brand_id){
            $brands = ProductBrand::where('id',$product_brand_id)->get();
            if(count($brands) > 0){
                $options['brandOptions'] = "<select class='form-control' name='product_brand_id[]'readonly>";
                foreach($brands as $brand){
                    $options['brandOptions'] .= "<option value='$brand->id'>$brand->name</option>";
                }
                $options['brandOptions'] .= "</select>";
            }
        }else{
            $options['brandOptions'] = "<select class='form-control' name='product_sub_category_id[]' readonly>";
            $options['brandOptions'] .= "<option value=''>No Data Found!</option>";
            $options['brandOptions'] .= "</select>";
        }

        return response()->json(['success'=>true,'data'=>$options]);
    }

}
