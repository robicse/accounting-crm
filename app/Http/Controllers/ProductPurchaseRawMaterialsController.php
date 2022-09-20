<?php

namespace App\Http\Controllers;

use App\Party;
use App\Product;
use App\ProductBrand;
use App\ProductCategory;
use App\ProductPurchase;
use App\ProductPurchaseDetail;
use App\ProductSubCategory;
use App\Stock;
use App\StockMinusLog;
use App\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Store;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductPurchaseRawMaterialsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:product-purchase-raw-materials-list|product-purchase-raw-materials-create|product-purchase-raw-materials-edit|product-purchase-raw-materials-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-purchase-raw-materials-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-purchase-raw-materials-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-purchase-raw-materials-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        // just check where goes stock minus
        if(check_stock_minus_logs_exists() > 0){
            Toastr::warning('Stock went to minus, Please contact with administrator!', 'warning');
            return redirect()->route('home');
        }

        $productPurchases = ProductPurchase::where('purchase_product_type','Raw Materials')->latest()->get();
        return view('backend.productPurchaseRawMaterial.index',compact('productPurchases'));
    }


    public function create()
    {
        $parties = Party::where('type','supplier')->get() ;
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
        $products = Product::where('product_type','Raw Materials')->get();
        return view('backend.productPurchaseRawMaterial.create',compact('parties','stores','products','productCategories','productSubCategories','productBrands'));
    }


    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'party_id'=> 'required',
            'store_id'=> 'required',

        ]);

        $row_count = count($request->product_id);
        $total_amount = 0;
        for($i=0; $i<$row_count;$i++)
        {
            $total_amount += $request->sub_total[$i];
        }

        // product purchase
        $productPurchase = new ProductPurchase();
        $productPurchase ->party_id = $request->party_id;
        $productPurchase ->store_id = $request->store_id;
        $productPurchase ->user_id = Auth::id();
        $productPurchase ->date = $request->date;
        //$productPurchase ->payment_type = $request->payment_type;
        //$productPurchase->check_number = $request->check_number ? $request->check_number : '';
        $productPurchase ->total_amount = $total_amount;
        $productPurchase ->purchase_product_type = 'Raw Materials';
        $productPurchase->save();
        $insert_id = $productPurchase->id;
        if($insert_id)
        {
            for($i=0; $i<$row_count;$i++)
            {
                // product purchase detail
                $purchase_purchase_detail = new ProductPurchaseDetail();
                $purchase_purchase_detail->product_purchase_id = $insert_id;
                $purchase_purchase_detail->product_category_id = $request->product_category_id[$i];
                $purchase_purchase_detail->product_sub_category_id = $request->product_sub_category_id[$i] ? $request->product_sub_category_id[$i] : NULL;
                $purchase_purchase_detail->product_brand_id = $request->product_brand_id[$i];
                $purchase_purchase_detail->product_id = $request->product_id[$i];
                $purchase_purchase_detail->qty = $request->qty[$i];
                $purchase_purchase_detail->price = $request->price[$i];
                $purchase_purchase_detail->mrp_price = NULL;
                $purchase_purchase_detail->sub_total = $request->qty[$i]*$request->price[$i];
                $purchase_purchase_detail->save();

                $product_id = $request->product_id[$i];
                $check_previous_stock = Stock::where('product_id',$product_id)->pluck('current_stock')->first();
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
                $stock->stock_type = 'purchase';
                $stock->previous_stock = $previous_stock;
                $stock->stock_in = $request->qty[$i];
                $stock->stock_out = 0;
                $stock->current_stock = $previous_stock + $request->qty[$i];
                $stock->save();

                // stock minus log
                if($stock->current_stock < 0){
                    $stock_minus_log = new StockMinusLog();
                    $stock_minus_log->user_id=Auth::user()->id;
                    $stock_minus_log->action_module='Product Purchase Raw Materials';
                    $stock_minus_log->action_done='Store';
                    $stock_minus_log->action_remarks='Product Purchase Raw Material ID: '.$insert_id;
                    $stock_minus_log->action_date=date('Y-m-d');
                    $stock_minus_log->save();
                }
            }

            // transaction
            $transaction = new Transaction();
            $transaction->invoice_no = Null;
            $transaction->user_id = Auth::id();
            $transaction->store_id = $request->store_id;
            $transaction->party_id = $request->party_id;
            $transaction->date = $request->date;
            $transaction->ref_id = $insert_id;
            $transaction->transaction_product_type = 'Finish Goods';
            $transaction->transaction_type = 'purchase';
            $transaction->payment_type = $request->payment_type;
            $transaction->check_number = $request->check_number ? $request->check_number : '';
            $transaction->amount = $total_amount;
            $transaction->save();
        }

        Toastr::success('Product Purchase Created Successfully', 'Success');
        return redirect()->route('productPurchaseRawMaterials.index');

    }


    public function show($id)
    {
        $productPurchase = ProductPurchase::find($id);
        $productPurchaseDetails = ProductPurchaseDetail::where('product_purchase_id',$id)->get();
        $transaction = Transaction::where('ref_id',$id)->first();

        return view('backend.productPurchaseRawMaterial.show', compact('productPurchase','productPurchaseDetails','transaction'));
    }


    public function edit($id)
    {
        $parties = Party::where('type','supplier')->get() ;
        $auth_user_id = Auth::user()->id;
        $auth_user = Auth::user()->roles[0]->name;
        if($auth_user == "Admin"){
            $stores = Store::all();
        }else{
            $stores = Store::where('user_id',$auth_user_id)->get();
        }
        $products = Product::where('product_type','Raw Materials')->get();
        $productPurchase = ProductPurchase::find($id);
        $productCategories = ProductCategory::all();
        $productSubCategories = ProductSubCategory::all();
        $productBrands = ProductBrand::all();
        $transaction = Transaction::where('ref_id',$id)->first();
        $productPurchaseDetails = ProductPurchaseDetail::where('product_purchase_id',$id)->get();
        $stock_id = Stock::where('ref_id',$id)->where('stock_type','purchase')->pluck('id')->first();
        //dd($stock_id);
        return view('backend.productPurchaseRawMaterial.edit',compact('parties','stores','products','productPurchase','productPurchaseDetails','productCategories','productSubCategories','productBrands','transaction','stock_id'));
    }


    public function update(Request $request, $id)
    {
        //dd($request->all());
        $this->validate($request, [
            'party_id'=> 'required',
            'store_id'=> 'required',

        ]);

        $stock_id = $request->stock_id;
        $row_count = count($request->product_id);
        $total_amount = 0;
        for($i=0; $i<$row_count;$i++)
        {
            $total_amount += $request->sub_total[$i];
        }

        // product purchase
        $productPurchase = ProductPurchase::find($id);
        $productPurchase ->party_id = $request->party_id;
        $productPurchase ->store_id = $request->store_id;
        $productPurchase ->user_id = Auth::id();
        $productPurchase ->date = $request->date;
        //$productPurchase ->payment_type = $request->payment_type;
        //$productPurchase->check_number = $request->check_number ? $request->check_number : '';
        $productPurchase ->total_amount = $total_amount;
        //$productPurchase->update();

        for($i=0; $i<$row_count;$i++)
        {
            // product purchase detail
            $product_purchase_detail_id = $request->product_purchase_detail_id[$i];
            $purchase_purchase_detail = ProductPurchaseDetail::findOrFail($product_purchase_detail_id);;
            $purchase_purchase_detail->product_category_id = $request->product_category_id[$i];
            $purchase_purchase_detail->product_sub_category_id = $request->product_sub_category_id[$i] ? $request->product_sub_category_id[$i] : NULL;
            $purchase_purchase_detail->product_brand_id = $request->product_brand_id[$i];
            $purchase_purchase_detail->product_id = $request->product_id[$i];
            $purchase_purchase_detail->qty = $request->qty[$i];
            $purchase_purchase_detail->price = $request->price[$i];
            $purchase_purchase_detail->mrp_price = NULL;
            $purchase_purchase_detail->sub_total = $request->qty[$i]*$request->price[$i];
            //$purchase_purchase_detail->update();


            $product_id = $request->product_id[$i];
//            $check_previous_stock = Stock::where('product_id',$product_id)->where('id','!=',$stock_id)->pluck('current_stock')->first();
//            if(!empty($check_previous_stock)){
//                $previous_stock = $check_previous_stock;
//            }else{
//                $previous_stock = 0;
//            }
//
//            // product stock
//            $stock = Stock::where('ref_id',$id)->where('stock_type','purchase')->first();
//            $stock->user_id = Auth::id();
//            $stock->store_id = $request->store_id;
//            $stock->product_id = $request->product_id[$i];
//            $stock->date = $request->date;
//            $stock->previous_stock = $previous_stock;
//            $stock->stock_in = $request->qty[$i];
//            $stock->stock_out = 0;
//            $stock->current_stock = $previous_stock + $request->qty[$i];
//            $stock->update();

            // product stock
            $stock_row = Stock::where('ref_id',$id)->where('stock_type','purchase')->where('product_id',$product_id)->first();

            if($stock_row->stock_in != $request->qty[$i]){
                if($request->qty[$i] > $stock_row->stock_in){
                    $add_or_minus_stock_in = $request->qty[$i] - $stock_row->stock_in;
                    $update_stock_in = $stock_row->stock_in + $add_or_minus_stock_in;
                    $update_current_stock = $stock_row->current_stock + $add_or_minus_stock_in;
                }else{
                    $add_or_minus_stock_in =  $stock_row->stock_in - $request->qty[$i];
                    $update_stock_in = $stock_row->stock_in - $add_or_minus_stock_in;
                    $update_current_stock = $stock_row->current_stock - $add_or_minus_stock_in;
                }

                $stock_row->user_id = Auth::user()->id;
                $stock_row->stock_in = $update_stock_in;
                $stock_row->current_stock = $update_current_stock;
                $stock_row->update();

                // stock minus log
                if($stock_row->current_stock < 0){
                    $stock_minus_log = new StockMinusLog();
                    $stock_minus_log->user_id=Auth::user()->id;
                    $stock_minus_log->action_module='Product Purchase Raw Materials';
                    $stock_minus_log->action_done='Update';
                    $stock_minus_log->action_remarks='Product Purchase Raw Material ID: '.$id;
                    $stock_minus_log->action_date=date('Y-m-d');
                    $stock_minus_log->save();
                }
            }
        }

        // transaction
        $transaction = Transaction::where('ref_id',$id)->where('transaction_type','purchase')->first();
        $transaction->invoice_no = Null;
        $transaction->user_id = Auth::id();
        $transaction->store_id = $request->store_id;
        $transaction->party_id = $request->party_id;
        $transaction->date = $request->date;
        $transaction->payment_type = $request->payment_type;
        $transaction->check_number = $request->check_number ? $request->check_number : '';
        $transaction->amount = $total_amount;
        $transaction->update();

        Toastr::success('Product Purchases Updated Successfully', 'Success');
        return redirect()->route('productPurchaseRawMaterials.index');
    }


    public function destroy($id)
    {
        $productPurchase = ProductPurchase::find($id);
        $productPurchase->delete();

        DB::table('product_purchase_details')->where('product_purchase_id',$id)->delete();
        DB::table('stocks')->where('ref_id',$id)->delete();
        DB::table('transactions')->where('ref_id',$id)->delete();

        Toastr::success('Product purchase Deleted Successfully', 'Success');
        return redirect()->route('productPurchases.index');
    }

    public function productRelationData(Request $request){
        $product_id = $request->current_product_id;
        $product_category_id = Product::where('id',$product_id)->pluck('product_category_id')->first();
        $product_sub_category_id = Product::where('id',$product_id)->pluck('product_sub_category_id')->first();
        $product_brand_id = Product::where('id',$product_id)->pluck('product_brand_id')->first();
        $options = [
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
    public function invoice()
    {
        return view('backend.productPurchaseRawMaterial.invoice');
    }
    public function invoicePrint()
    {
        return view('backend.productPurchaseRawMaterial.invoice-print');
    }

    public function newParty(Request $request){
        //dd($request->all());
        $this->validate($request, [
            'type'=> 'required',
            'name' => 'required',
            'phone'=> 'required',
            'email'=> '',
            'address'=> '',
        ]);
        $parties = new Party();
        $parties->type = $request->type;
        $parties->name = $request->name;
        $parties->slug = Str::slug($request->name);
        $parties->phone = $request->phone;
        $parties->email = $request->email;
        $parties->address = $request->address;
        $parties->status = 1;
        $parties->save();
        $insert_id = $parties->id;

        if ($insert_id){
            $sdata['id'] = $insert_id;
            $sdata['name'] = $parties->name;
            echo json_encode($sdata);

        }
        else {
            $data['exception'] = 'Some thing mistake !';
            echo json_encode($data);

        }
    }
}
