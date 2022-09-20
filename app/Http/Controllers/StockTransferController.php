<?php

namespace App\Http\Controllers;

use App\DeliveryService;
use App\Party;
use App\Product;
use App\ProductBrand;
use App\ProductCategory;
use App\ProductPurchase;
use App\ProductPurchaseDetail;
use App\ProductSubCategory;
use App\ProductUnit;
use App\Stock;
use App\StockMinusLog;
use App\StockTransfer;
use App\StockTransferDetail;
use App\Store;
use App\Transaction;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use NumberFormatter;

class StockTransferController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:stock-transfer-list|stock-transfer-create|stock-transfer-edit|stock-transfer-delete', ['only' => ['index','show','invoice']]);
        $this->middleware('permission:stock-transfer-create', ['only' => ['create','store']]);
        $this->middleware('permission:stock-transfer-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:stock-transfer-invoice', ['only' => ['invoice']]);
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
            $stockTransfers = StockTransfer::latest()->get();
        }else{
            $stockTransfers = StockTransfer::where('user_id',$auth_user_id)->latest()->get();
        }
        //dd($stockTransfers);
        return view('backend.stockTransfer.index',compact('stockTransfers'));
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
        $products = Product::all();
        $deliveryServices = DeliveryService::all();
        return view('backend.stockTransfer.create',compact('stores','products','productCategories','productSubCategories','productBrands','deliveryServices'));
    }

    public function store(Request $request)
    {
        //dd($request->all());

        //dd($request->all());

        $this->validate($request, [
            'from_store_id'=> 'required',
            'to_store_id'=> 'required',
            'product_id'=> 'required',
            'qty'=> 'required',
            'price'=> 'required',

        ]);

        $row_count = count($request->product_id);
        $total_amount = 0;
        for($i=0; $i<$row_count;$i++)
        {
            $total_amount += $request->sub_total[$i];
        }
        $discount_type = $request->discount_type;
        if($discount_type == 'flat'){
            $total_amount -= $request->discount_amount;
        }else{
            $total_amount = ($total_amount*$request->discount_amount)/100;
        }

        $get_invoice_no = StockTransfer::latest()->pluck('invoice_no')->first();
        //dd($get_invoice_no);
        if(!empty($get_invoice_no)){
            $get_invoice = str_replace("stock-transfer-","",$get_invoice_no);
            //$invoice_no = $get_invoice_no+1;
            $invoice_no = $get_invoice+1;
        }else{
            $invoice_no = 5000;
        }

        $date = date('Y-m-d');


        // product purchase
        $stock_transfer = new StockTransfer();
        $stock_transfer->invoice_no = 'stock-transfer-'.$invoice_no;
        $stock_transfer->send_user_id = Auth::id();
        $stock_transfer->send_date = $date;
        $stock_transfer->send_remarks = $request->remarks;
        $stock_transfer->note = $request->note;
        $stock_transfer->from_store_id = $request->from_store_id;
        $stock_transfer->to_store_id = $request->to_store_id;
        $stock_transfer->delivery_service_id = $request->delivery_service_id;
        $stock_transfer->delivery_service_charge = $request->delivery_service_charge;
        $stock_transfer->discount_type = $request->discount_type;
        $stock_transfer->discount_amount = $request->discount_amount;
        $stock_transfer->total_amount =$request->total_amount;
        $stock_transfer->paid_amount = $request->paid_amount;
        $stock_transfer->due_amount = $request->due_amount;
        $stock_transfer->receive_user_id = Auth::id();
        $stock_transfer->receive_date = $date;
        $stock_transfer->receive_remarks = $request->remarks;
        $stock_transfer->receive_status = 'received';
        //dd($stock_transfer);
        $stock_transfer->save();
        $insert_id = $stock_transfer->id;
        if($insert_id)
        {
            for($i=0; $i<$row_count;$i++)
            {
                // product purchase detail
                $stock_transfer_detail = new StockTransferDetail();
                $stock_transfer_detail->stock_transfer_id = $insert_id;
                $stock_transfer_detail->product_category_id = $request->product_category_id[$i];
//                $stock_transfer_detail->product_sub_category_id = $request->product_sub_category_id[$i] ? $request->product_sub_category_id[$i] : NULL;
                $stock_transfer_detail->product_brand_id = $request->product_brand_id[$i];
                $stock_transfer_detail->product_id = $request->product_id[$i];
                $stock_transfer_detail->qty = $request->qty[$i];
                $stock_transfer_detail->price = $request->price[$i];
                $stock_transfer_detail->wholeSale_price = $request->wholeSale_price[$i];
                $stock_transfer_detail->mrp_price = $request->mrp_price[$i];
                $stock_transfer_detail->sub_total = $request->qty[$i]*$request->price[$i];
                //dd($stock_transfer_detail);
                $stock_transfer_detail->save();

                $product_id = $request->product_id[$i];



                // from stock / stock out
                $check_previous_stock = Stock::where('store_id',$request->from_store_id)->where('product_id',$product_id)->latest()->pluck('current_stock')->first();
                if(!empty($check_previous_stock)){
                    $previous_stock = $check_previous_stock;
                }else{
                    $previous_stock = 0;
                }
                // product stock
                $stock = new Stock();
                $stock->user_id = Auth::id();
                $stock->ref_id = $insert_id;
                $stock->store_id = $request->from_store_id;
                $stock->product_id = $request->product_id[$i];
                $stock->stock_type = 'from stock out';
                $stock->previous_stock = $previous_stock;
                $stock->stock_in = 0;
                $stock->stock_out = $request->qty[$i];
                $stock->current_stock = $previous_stock - $request->qty[$i];
                $stock->date = $date;
                $stock->save();

                // stock minus log
                if($stock->current_stock < 0){
                    $stock_minus_log = new StockMinusLog();
                    $stock_minus_log->user_id=Auth::user()->id;
                    $stock_minus_log->action_module='Stock Transfer Out';
                    $stock_minus_log->action_done='Store';
                    $stock_minus_log->action_remarks='Stock Transfer Out ID: '.$insert_id;
                    $stock_minus_log->action_date=date('Y-m-d');
                    $stock_minus_log->save();
                }

                // to stock / stock in
                $check_previous_stock = Stock::where('store_id',$request->to_store_id)->where('product_id',$product_id)->latest()->pluck('current_stock')->first();
                if(!empty($check_previous_stock)){
                    $previous_stock = $check_previous_stock;
                }else{
                    $previous_stock = 0;
                }
                // product stock
                $stock = new Stock();
                $stock->user_id = Auth::id();
                $stock->ref_id = $insert_id;
                $stock->store_id = $request->to_store_id;
                $stock->product_id = $request->product_id[$i];
                $stock->stock_type = 'to stock in';
                $stock->previous_stock = $previous_stock;
                $stock->stock_in = $request->qty[$i];
                $stock->stock_out = 0;
                $stock->current_stock = $previous_stock + $request->qty[$i];
                $stock->date = $date;
                $stock->save();

                // stock minus log
                if($stock->current_stock < 0){
                    $stock_minus_log = new StockMinusLog();
                    $stock_minus_log->user_id=Auth::user()->id;
                    $stock_minus_log->action_module='Stock Transfer In';
                    $stock_minus_log->action_done='Store';
                    $stock_minus_log->action_remarks='Stock Transfer In ID: '.$insert_id;
                    $stock_minus_log->action_date=date('Y-m-d');
                    $stock_minus_log->save();
                }
            }
        }

        Toastr::success('Product Sale Created Successfully', 'Success');
        return redirect()->route('stockTransfers.index');
    }

    public function show($id)
    {
        $stockTransfer = StockTransfer::where('id',$id)->first();

        $stockTransferDetails = StockTransferDetail::where('stock_transfer_id',$id)->get();
        //dd($stockTransferDetail);

        return view('backend.stockTransfer.show',compact('stockTransfer','stockTransferDetails'));
    }

    public function invoice($id)
    {
        $stockTransfer = StockTransfer::where('id',$id)->first();

        $stockTransferDetails = StockTransferDetail::where('stock_transfer_id',$id)->get();
        //dd($stockTransferDetail);
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return view('backend.stockTransfer.invoice',compact('stockTransfer','stockTransferDetails','digit'));
    }
    public function invoicePrint($id)
    {
        $stockTransfer = StockTransfer::where('id',$id)->first();

        $stockTransferDetails = StockTransferDetail::where('stock_transfer_id',$id)->get();
        //dd($stockTransferDetail);
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return view('backend.stockTransfer.invoice-print',compact('stockTransfer','stockTransferDetails','digit'));
    }
    public function productSaleRelationData(Request $request){
        $store_id = $request->store_id;
        $product_id = $request->current_product_id;
        $current_stock = Stock::where('store_id',$store_id)->where('product_id',$product_id)->latest()->pluck('current_stock')->first();
        $price = ProductPurchaseDetail::join('product_purchases', 'product_purchase_details.product_purchase_id', '=', 'product_purchases.id')
            ->where('store_id',$store_id)->where('product_id',$product_id)
            ->max('product_purchase_details.price');

        $mrp_price = ProductPurchaseDetail::join('product_purchases', 'product_purchase_details.product_purchase_id', '=', 'product_purchases.id')
            ->where('store_id',$store_id)->where('product_id',$product_id)
            ->max('product_purchase_details.mrp_price');

        $wholeSale_price = ProductPurchaseDetail::join('product_purchases', 'product_purchase_details.product_purchase_id', '=', 'product_purchases.id')
            ->where('store_id',$store_id)->where('product_id',$product_id)
            ->max('product_purchase_details.wholeSale_price');
        //->pluck('product_purchase_details.mrp_price')
        //->first();

        $product_category_id = Product::where('id',$product_id)->pluck('product_category_id')->first();
        $product_sub_category_id = Product::where('id',$product_id)->pluck('product_sub_category_id')->first();
        $product_brand_id = Product::where('id',$product_id)->pluck('product_brand_id')->first();
        $product_unit_id = Product::where('id',$product_id)->pluck('product_unit_id')->first();
        $options = [
            'price' => $price,
            'mrp_price' => $mrp_price,
            'wholeSale_price' => $wholeSale_price,
            'current_stock' => $current_stock,
            'categoryOptions' => '',
            'subCategoryOptions' => '',
            'brandOptions' => '',
            'unitOptions' => '',
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
            $options['brandOptions'] = "<select class='form-control' name='product_brand_id[]' readonly>";
            $options['brandOptions'] .= "<option value=''>No Data Found!</option>";
            $options['brandOptions'] .= "</select>";
        }

        if($product_unit_id){
            $units = ProductUnit::where('id',$product_unit_id)->get();
            if(count($units) > 0){
                $options['unitOptions'] = "<select class='form-control' name='product_unit_id[]' readonly>";
                foreach($units as $unit){
                    $options['unitOptions'] .= "<option value='$unit->id'>$unit->name</option>";
                }
                $options['unitOptions'] .= "</select>";
            }
        }else{
            $options['unitOptions'] = "<select class='form-control' name='product_unit_id[]' readonly>";
            $options['unitOptions'] .= "<option value=''>No Data Found!</option>";
            $options['unitOptions'] .= "</select>";
        }

        return response()->json(['success'=>true,'data'=>$options]);
    }
    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
