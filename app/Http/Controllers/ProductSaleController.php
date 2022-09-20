<?php

namespace App\Http\Controllers;

use App\Account;
use App\Due;
use App\FreeProduct;
use App\FreeProductSaleDetails;
use App\Helpers\UserInfo;
use App\OnlinePlatForm;
use App\Party;
use App\Posting;
use App\Product;
use App\ProductBrand;
use App\ProductCategory;
use App\ProductPurchaseDetail;
use App\ProductSale;
use App\ProductSaleDetail;
use App\ProductSubCategory;
use App\ProductUnit;
use App\SaleService;
use App\SaleServiceDuration;
use App\Service;
use App\Stock;
use App\StockMinusLog;
use App\StockTransfer;
use App\Transaction;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Store;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use NumberFormatter;

class ProductSaleController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:product-sale-list|product-sale-create|product-sale-edit|product-sale-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-sale-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-sale-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-sale-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        //dd('d');
//        $auth_user_id = Auth::user()->id;
//        $auth_user = Auth::user()->roles[0]->name;
//        if($auth_user == "Admin"){
//        $productSales = ProductSale::latest()->get();
//        }else{
//            $productSales = ProductSale::where('user_id',$auth_user_id)->latest()->get();
//        }

        // just check where goes stock minus
        if(check_stock_minus_logs_exists() > 0){
            Toastr::warning('Stock went to minus, Please contact with administrator!', 'warning');
            return redirect()->route('home');
        }

        $auth_user_id = Auth::user()->id;
        $auth_user = Auth::user()->roles[0]->name;
        $start_date = $request->start_date ? $request->start_date : '';
        $end_date = $request->end_date ? $request->end_date : '';
        $reference_name = $request->reference_name ? $request->reference_name : '';
        $sale_type = $request->sale_type == 'All' ? null : $request->sale_type;

        if ($reference_name && $start_date && $end_date && $sale_type){
            if ($auth_user == "Admin") {
                $productSales = ProductSale::where('sale_type','LIKE', '%'. $sale_type. '%')->where('reference_name',$reference_name)->where('date', '>=', $start_date)->where('date', '<=', $end_date)->latest('id','desc')->get();
            } else {
                $productSales = ProductSale::where('sale_type','LIKE', '%'. $sale_type. '%')->where('reference_name',$reference_name)->where('date', '>=', $start_date)->where('date', '<=', $end_date)->where('user_id', $auth_user_id)->latest('id','desc')->get();
            }
        }
        elseif($start_date && $end_date && empty($reference_name) && empty($sale_type)) {
            if ($auth_user == "Admin") {
                $productSales = ProductSale::where('date', '>=', $start_date)->where('date', '<=', $end_date)->latest('id','desc')->get();
            } else {
                $productSales = ProductSale::where('reference_name',$reference_name)->where('date', '>=', $start_date)->where('date', '<=', $end_date)->where('user_id', $auth_user_id)->latest('id','desc')->get();
            }
        }
        elseif($start_date && $end_date && $reference_name && empty($sale_type)) {
            if ($auth_user == "Admin") {
                $productSales = ProductSale::where('reference_name',$reference_name)->where('date', '>=', $start_date)->where('date', '<=', $end_date)->latest('id','desc')->get();
            } else {
                $productSales = ProductSale::where('reference_name',$reference_name)->where('date', '>=', $start_date)->where('date', '<=', $end_date)->where('user_id', $auth_user_id)->latest('id','desc')->get();
            }
        }
        elseif($start_date && $end_date && $sale_type && empty($reference_name)) {

            if ($auth_user == "Admin") {
                $productSales = ProductSale::where('sale_type','LIKE', '%'. $sale_type. '%')->where('date', '>=', $start_date)->where('date', '<=', $end_date)->latest('id','desc')->get();
            } else {
                $productSales = ProductSale::where('sale_type','LIKE', '%'. $sale_type. '%')->where('date', '>=', $start_date)->where('date', '<=', $end_date)->where('user_id', $auth_user_id)->latest('id','desc')->get();
            }
        }
        elseif ($reference_name && $sale_type){

            if ($auth_user == "Admin") {
                $productSales = ProductSale::where('sale_type','LIKE', '%'. $sale_type. '%')->where('reference_name',$reference_name)->latest('id','desc')->get();
            } else {
                $productSales = ProductSale::where('sale_type','LIKE', '%'. $sale_type. '%')->where('reference_name',$reference_name)->where('user_id', $auth_user_id)->latest('id','desc')->get();
            }
        }
        elseif ($reference_name){

            if ($auth_user == "Admin") {
                $productSales = ProductSale::where('reference_name',$reference_name)->latest('id','desc')->get();
            } else {
                $productSales = ProductSale::where('reference_name',$reference_name)->where('user_id', $auth_user_id)->latest('id','desc')->get();
            }
        }
        elseif ($sale_type){

            if ($auth_user == "Admin") {
                $productSales = ProductSale::where('sale_type','LIKE', '%'. $sale_type. '%')->latest('id','desc')->get();
            } else {
                $productSales = ProductSale::where('sale_type','LIKE', '%'. $sale_type. '%')->where('user_id', $auth_user_id)->latest('id','desc')->get();
            }
        }
        else{
            if ($auth_user == "Admin") {
                $productSales = ProductSale::latest('id','desc')->get();
            } else {
                $productSales = ProductSale::where('user_id', $auth_user_id)->latest('id','desc')->get();
            }
        }
        $serviceProviders = User::where('type','provider')->get();
        return view('backend.productSale.index',compact('productSales','start_date','end_date','serviceProviders','reference_name','sale_type'));
    }



    public function create()
    {

        $auth = Auth::user();
        $auth_user = Auth::user()->roles[0]->name;
        $parties = Party::where('type','customer' )->get() ;
        if($auth_user == "Admin"){
            $stores = Store::all();
        }else{
            $stores = Store::where('id',$auth->store_id)->get();
        }
        $productCategories = ProductCategory::all();
        $productSubCategories = ProductSubCategory::all();
        $productBrands = ProductBrand::all();
        $productUnits = ProductUnit::all();
        $products = Product::latest()->get();
        $online_platforms = OnlinePlatForm::all();
        $freeProducts = FreeProduct::all();
        return view('backend.productSale.create',compact('online_platforms','freeProducts','parties','stores','products','productCategories','productSubCategories','productBrands','productUnits'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'party_id'=> 'required',
            'store_id'=> 'required',

        ]);

        $row_count = count($request->product_id);
        for($i=0; $i<$row_count;$i++)
        {
            $product_id = $request->product_id[$i];
            $check_previous_stock = Stock::where('product_id',$product_id)->where('store_id',$request->store_id)->latest()->pluck('current_stock')->first();
            if(!empty($check_previous_stock)){
                if($check_previous_stock == 0)
                {
                    Toastr::success('Product Stock Not Available', 'warning');
                    return redirect()->back();
                }
            }
        }
        $row_count_free_product = count($request->free_product_id);
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

        $get_invoice_no = ProductSale::latest()->pluck('invoice_no')->first();
        if(!empty($get_invoice_no)){
            $invoice_no = $get_invoice_no+1;
        }else{
            $invoice_no = 1000;
        }

        $productSale = new ProductSale();
        $productSale->invoice_no = $invoice_no;
        $productSale->user_id = Auth::id();
        $productSale->party_id = $request->party_id;
        $productSale->online_platform_id = $request->online_platform_id;
        $productSale->store_id = $request->store_id;
        $productSale->date = $request->date;
        $productSale->note = $request->note;
        $productSale->reference_name = $request->reference_name;
        $productSale->sale_type ="Retail Sale";
        $productSale->online_platform_invoice_no = $request->online_platform_invoice_no ? $request->online_platform_invoice_no : '';
        $productSale->discount_type = $request->discount_type;
        $productSale->discount_amount = $request->discount_amount;
        $productSale->vat_amount = $request->vat_amount;
        $productSale->total_amount = $request->total_amount;
        $productSale->paid_amount = $request->paid_amount;
        $productSale->due_amount = $request->due_amount;
        $productSale->transport_cost = $request->transport_cost;
        $productSale->transport_area = $request->transport_area;
        $productSale->conditions = $request->conditions;
        $productSale->save();
        $insert_id = $productSale->id;
        if($insert_id)
        {
            for($i=0; $i<$row_count;$i++)
            {
                $purchase_sale_detail = new ProductSaleDetail();
                $purchase_sale_detail->product_sale_id = $insert_id;
                $purchase_sale_detail->return_type = $request->return_type[$i];
                $purchase_sale_detail->product_category_id = $request->product_category_id[$i];
                $purchase_sale_detail->product_sub_category_id = $request->product_sub_category_id[$i] ? $request->product_sub_category_id[$i] : NULL;
                $purchase_sale_detail->product_brand_id = $request->product_brand_id[$i];
                $purchase_sale_detail->product_unit_id = $request->product_unit_id[$i];
                $purchase_sale_detail->product_id = $request->product_id[$i];
                $purchase_sale_detail->qty = $request->qty[$i];
                $purchase_sale_detail->price = $request->price[$i];
                $purchase_sale_detail->sub_total = $request->qty[$i]*$request->price[$i];
                $purchase_sale_detail->save();

                $product_id = $request->product_id[$i];
                $check_previous_stock = Stock::where('product_id',$product_id)->where('store_id',$request->store_id)->latest()->pluck('current_stock')->first();
                if(!empty($check_previous_stock)){
                    $previous_stock = $check_previous_stock;
                }else{
                    $previous_stock = 0;
                }

                $stock = new Stock();
                if ($previous_stock < 0)
                {
                    Toastr::success('Product Stock Not Available', 'warning');
                    return redirect()->back();
                }
                $stock->user_id = Auth::id();
                $stock->ref_id = $insert_id;
                $stock->store_id = $request->store_id;
                $stock->date = $request->date;
                $stock->product_id = $request->product_id[$i];
                $stock->stock_type = 'sale';
                $stock->sale_type = "Retail Sale";
                $stock->previous_stock = $previous_stock;
                $stock->stock_in = 0;
                $stock->stock_out = $request->qty[$i];
                $stock->current_stock = $previous_stock - $request->qty[$i];
                $stock->save();

                if($stock->current_stock < 0){
                    $stock_minus_log = new StockMinusLog();
                    $stock_minus_log->user_id=Auth::user()->id;
                    $stock_minus_log->action_module='Product Sale';
                    $stock_minus_log->action_done='Store';
                    $stock_minus_log->action_remarks='Sale ID: '.$insert_id;
                    $stock_minus_log->action_date=date('Y-m-d');
                    $stock_minus_log->save();
                }
            }

            $due = new Due();
            $due->invoice_no = $invoice_no;
            $due->ref_id = $insert_id;
            $due->user_id = Auth::id();
            $due->store_id = $request->store_id;
            $due->party_id = $request->party_id;
            $due->total_amount = $total_amount;
            $due->paid_amount = $request->paid_amount;
            $due->due_amount = $request->due_amount;
            $due->save();

            $transaction = new Transaction();
            $transaction->invoice_no = $invoice_no;
            $transaction->user_id = Auth::id();
            $transaction->store_id = $request->store_id;
            $transaction->party_id = $request->party_id;
            $transaction->date = $request->date;
            $transaction->ref_id = $insert_id;
            $transaction->transaction_type = 'sale';
            $transaction->sale_type = "Retail Sale";
            $transaction->payment_type = $request->payment_type;
            $transaction->check_number = $request->check_number ? $request->check_number : '';
            $transaction->check_date = $request->check_date ? $request->check_date : '';
            $transaction->amount = $request->paid_amount;
            $transaction->save();
        }

        if($insert_id)
        {
            for($i=0; $i<$row_count_free_product;$i++)
            {
                $freeProduct_sale_detail = new FreeProductSaleDetails();
                $freeProduct_sale_detail->product_sale_id = $insert_id;
                $freeProduct_sale_detail->free_product_id = $request->free_product_id[$i];
                $freeProduct_sale_detail->save();
            }
        }
        $customer= DB::table('parties')

            ->where('id',$request->party_id)
            ->select('parties.name','parties.phone','parties.id')
            ->first();
        if(!empty($customer)){
            $customer_name = $customer->name;
            $customer_phone = $customer->phone;
        }else{
            $customer_name = '';
            $customer_phone = '';
        }
        if($insert_id)
        {
            $text_for_customer = "Dear, $customer_name  Sir,Thank you for purchasing from CleanTech Engineering, Invoice Number is $invoice_no .Rate us on www.facebook.com/cleantechbd and order online from www.cleantech.com.bd
For any queries call our support 09638-888 000";
            UserInfo::smsAPI("88".$customer_phone,$text_for_customer);
        }


        Toastr::success('Product Sale Created Successfully', 'Success');
        if($request->print_now == 1){
            return redirect()->route('productSales-invoice-print',$insert_id);
        }else{
            return redirect()->route('productSales.index');
        }

    }


    public function show($id)
    {


        $productSale = ProductSale::find($id);
        $productSaleDetails = ProductSaleDetail::where('product_sale_id',$id)->get();
        $transactions = Transaction::where('ref_id',$id)->first();

        return view('backend.productSale.show', compact('productSale','productSaleDetails','transactions'));
    }


    public function edit($id)
    {
        $auth = Auth::user();
        $auth_user = Auth::user()->roles[0]->name;
        if($auth_user == "Admin"){
            $stores = Store::all();
        }else{
            $stores = Store::where('id',$auth->store_id)->get();
        }
        $parties = Party::where('type' , 'customer')->orWhere('type' , 'own')->get() ;
        $products = Product::all();
        $productSale = ProductSale::find($id);
        $productCategories = ProductCategory::all();
        $productSubCategories = ProductSubCategory::all();
        $productBrands = ProductBrand::all();
        $productUnits = ProductUnit::all();
        $providers = User::where('type' , 'provider' )->get() ;
        $productSaleDetails = ProductSaleDetail::where('product_sale_id',$id)->get();
        $freeProductDetails =  FreeProductSaleDetails::where('product_sale_id',$id)->get();
        $transaction = Transaction::where('ref_id',$id)->first();
        $stock_id = Stock::where('ref_id',$id)->where('stock_type','sale')->pluck('id')->first();
        $online_platforms = OnlinePlatForm::all();
        $freeProducts = FreeProduct::all();
        return view('backend.productSale.edit',compact('providers','online_platforms','freeProductDetails','freeProducts','parties','stores','products','productSale','productSaleDetails','productCategories','productSubCategories','productBrands','productUnits','transaction','stock_id'));
    }


    public function update(Request $request, $id)
    {
        //dd($request->all());
        $this->validate($request, [
            'party_id'=> 'required',
            'store_id'=> 'required',
        ]);

        $row_count = count($request->product_id);
        $store_id = $request->store_id;
        $productSale = ProductSale::find($id);
        $previous_store_id = $productSale->store_id;

        for($i=0; $i<$row_count;$i++)
        {
            $product_id = $request->product_id[$i];
            $new_request_qty = $request->qty[$i];
            $product_sale_detail_id = $request->product_Sale_detail_id[$i];
            $purchase_sale_detail = ProductsaleDetail::findOrFail($product_sale_detail_id);
            $invoice_sale_qty = $purchase_sale_detail->qty;
            if( ($store_id != $previous_store_id) || (($invoice_sale_qty != $new_request_qty) && ($new_request_qty > $invoice_sale_qty)) ){
                $stock_row = current_stock_row($store_id,'sale',$product_id);
                if((empty($stock_row)) || (!empty($stock_row) && ($stock_row->previous_stock == 0)) ){
                    $product_name = get_product_name_by_product_id($product_id);
                    $store_name = get_store_name_by_store_id($store_id);
                    Toastr::warning('Product Stock Not Available For product '.$product_name.' For Store '.$store_name, 'warning');
                    return redirect()->back();
                }
            }
        }

        $total_amount = 0;
        for($i=0; $i<$row_count;$i++)
        {
            $total_amount += $request->sub_total[$i];
        }

        $productSale->user_id = Auth::id();
        $productSale->party_id = $request->party_id;
        $productSale->store_id = $request->store_id;
        $productSale->provider_id = $request->provider_id;
        $productSale->date = $request->date;
        $productSale->note = $request->note;
        $productSale->reference_name = $request->reference_name;
        $productSale->sale_type ="Retail Sale edit";
        $productSale->online_platform_id = $request->online_platform_id;
        $productSale->online_platform_invoice_no = $request->online_platform_invoice_no ? $request->online_platform_invoice_no : '';
        $productSale->discount_type = $request->discount_type;
        $productSale->discount_amount = $request->discount_amount;
        $productSale->total_amount =$request->total_amount;
        $productSale->paid_amount = $request->paid_amount;
        $productSale->due_amount = $request->due_amount;
        $productSale->vat_amount = $request->vat_amount;
        $productSale->transport_cost = $request->transport_cost;
        $productSale->transport_area = $request->transport_area;
        $productSale->conditions = $request->conditions;

        for($i=0; $i<$row_count;$i++)
        {
            $product_sale_detail_id = $request->product_Sale_detail_id[$i];
            $purchase_sale_detail = ProductsaleDetail::findOrFail($product_sale_detail_id);
            $invoice_sale_qty = $purchase_sale_detail->qty;
            $purchase_sale_detail->return_type = $request->return_type[$i];
            $purchase_sale_detail->product_category_id = $request->product_category_id[$i];
            $purchase_sale_detail->product_sub_category_id = $request->product_sub_category_id[$i] ? $request->product_sub_category_id[$i] : NULL;
            $purchase_sale_detail->product_brand_id = $request->product_brand_id[$i];
            $purchase_sale_detail->product_id = $request->product_id[$i];
            $purchase_sale_detail->qty = $request->qty[$i];
            $purchase_sale_detail->price = $request->price[$i];
            $purchase_sale_detail->sub_total = $request->qty[$i]*$request->price[$i];
            $purchase_sale_detail->update();

            $product_id = $request->product_id[$i];
            $new_request_qty = $request->qty[$i];

            $stock_row = current_stock_row($store_id,'sale',$product_id);
            if(!empty($stock_row)){
                $previous_current_stock = $stock_row->current_stock;
            }else{
                $previous_current_stock = 0;
            }

            if($store_id != $previous_store_id){
                $update = delete_stock_and_sync_for_edit_sale_stock($id,$previous_store_id, $store_id,'sale',$new_request_qty,$previous_current_stock,$product_id);
                if($update && ($previous_current_stock < 0)){
                    $action_remarks = 'Sale ID: '.$id;
                    stock_minus_log('Product Sale','Update',$action_remarks);
                }
            }else{
                if($invoice_sale_qty != $new_request_qty){
                    $update = update_stock_for_edit_sale_stock($id,$store_id,'sale',$new_request_qty,$invoice_sale_qty,$previous_current_stock,$product_id);
                    if($update && ($previous_current_stock < 0)){
                        $action_remarks = 'Sale ID: '.$id;
                        stock_minus_log('Product Sale','Update',$action_remarks);
                    }
                }
            }
        }

        //finally update
        $productSale->update();

        // due
        $due = Due::where('ref_id',$id)->where('invoice_no',$productSale->invoice_no)->first();
        if(!empty($due)){
            $due->user_id = Auth::id();
            $due->store_id = $request->store_id;
            $due->party_id = $request->party_id;
            $due->total_amount = $total_amount;
            $due->paid_amount = $request->paid_amount;
            $due->due_amount = $request->due_amount;
            $due->update();
        }

        $transaction = Transaction::where('ref_id',$id)->where('transaction_type','sale')->first();
        if(!empty($transaction)){
            $transaction->user_id = Auth::id();
            $transaction->store_id = $request->store_id;
            $transaction->party_id = $request->party_id;
            $transaction->date = $request->date;
            $transaction->sale_type = "Retail Sale";
            $transaction->payment_type = $request->payment_type;
            $transaction->check_number = $request->check_number ? $request->check_number : '';
            $transaction->check_date = $request->check_date ? $request->check_date : '';
            $transaction->amount = $total_amount;
            $transaction->update();
        }

        $row_count_product_sale = count($request->free_product_id);
        {
            for($i=0; $i<$row_count_product_sale;$i++)
            {
                $free_product_sale_detail_id = $request->free_product_detail_id[$i];
                $freeProduct_sale_detail = FreeProductSaleDetails::where('id',$free_product_sale_detail_id)->first();
                if(!empty($freeProduct_sale_detail)){
                    $freeProduct_sale_detail->free_product_id = $request->free_product_id[$i];
                    $freeProduct_sale_detail->save();
                }
            }
        }

        Toastr::success('Product Sale Updated Successfully', 'Success');
        return redirect()->route('productSales.index');
    }


    public function destroy($id)
    {

        $productSale = ProductSale::find($id);
        $productSale->delete();

        $productSaleDetails= DB::table('product_sale_details')->where('product_sale_id',$id)->delete();
        DB::table('sale_services')->where('product_sale_detail_id',$productSaleDetails)->delete();
        DB::table('stocks')->where('ref_id',$id)->delete();
        DB::table('transactions')->where('ref_id',$id)->delete();
        DB::table('dues')->where('ref_id',$id)->delete();

        Toastr::success('Product Sale Deleted Successfully', 'Success');
        return redirect()->route('productSales.index');
    }

    public function Addservice($id)
    {
        //dd($id);
        // $productSale = ProductSale::find($id);
        $productSaleDetail = ProductSaleDetail::where('id',$id)->first();
        $product = Product::where('id',$id)->first();
        //dd($productSaleDetail);
        $services = Service::latest()->get();
        return view('backend.productSale.addServices',compact('productSaleDetail','services','product'));
    }

    public function Storeservice(Request $request ){
        //dd($request->all());

        $this->validate($request, [
            'service_id'=> 'required',
        ]);
        $product_sale_detail_id = $request->product_sale_detail_id;
        //dd($product_sale_detail_id);
        $row_count = count($request->service_id);
        for($i=0; $i<$row_count;$i++) {

            $saleServices = new SaleService();
            $saleServices->product_sale_detail_id = $product_sale_detail_id;
            $saleServices->created_user_id = Auth::id();
            $saleServices->service_id = $request->service_id[$i];
            $saleServices->duration = $request->duration[$i];
            $saleServices->start_date = $request->start_date[$i];
            $saleServices->end_date = $request->end_date[$i];
            $saleServices->status = 0;
            $saleServices->save();
            $insert_id = $saleServices->id;

            if($insert_id){
                $duration_row_count = $request->duration[$i];
                if ($duration_row_count != NULL){
                    $service_date = $request->start_date[$i];
                    $end_date = $request->end_date[$i];
                    do {
                        // initial
                        $saleServiceDuration = new SaleServiceDuration();
                        $saleServiceDuration->sale_service_id = $insert_id;
                        $saleServiceDuration->service_date = $service_date;
                        $saleServiceDuration->save();
                        //$x++;
                        //$start_date = $request->start_date[$i];
                        $add_next_service_date = $service_date."+".$duration_row_count." month";
                        $nextServiceDate = date("Y-m-d",strtotime($add_next_service_date));

                        $service_date = $nextServiceDate;
                    } while ($service_date <= $end_date);
                }
            }

        }

        return redirect()->route('productSales.index');
    }
    public function Showservice(Request $request, $id){
        //dd($id);
        $productSaleDetail = ProductSaleDetail::where('id',$id)->get();
        //dd($productSaleDetail);
        //$saleService =  SaleService::find($id);
        $saleServices =  SaleService::where('product_sale_detail_id',$id)->get();

        //dd($saleServicesDuration);
        $services = Service::latest()->get();
        return view('backend.productSale.showServices',compact('productSaleDetail','services','saleServices'));
    }

    public function Editservice($id){
        //dd($id);
        //$productSale = ProductSale::find($id);
        $productSaleDetail = ProductSaleDetail::where('id',$id)->first();
        //$saleService =  SaleService::find($id);
        $saleServices =  SaleService::where('product_sale_detail_id',$id)->get();

        $services = Service::latest()->get();
        //dd($saleServices);
        return view('backend.productSale.editServices',compact('productSaleDetail','services','saleServices'));
    }
    public function Updateeservice(Request $request,$id ){
        //dd($id);
        //dd($request->all());

        $this->validate($request, [
            'service_id'=> 'required',
        ]);
        $row_count = count($request->service_id);
        for($i=0; $i<$row_count;$i++) {
            $sale_service_id = $request->sale_service_id[$i];
            $saleServices =  SaleService::where('id',$sale_service_id)->where('product_sale_detail_id',$id)->first();
            $saleServices->created_user_id = Auth::id();
            $saleServices->service_id = $request->service_id[$i];
            $saleServices->duration = $request->duration[$i];
            $saleServices->start_date = $request->start_date[$i];
            $saleServices->end_date = $request->end_date[$i];
            $saleServices->status = 0;;
            $saleServices->save();
            $insert_id = $saleServices->id;
            if($insert_id){
//                $duration_row_count = $request->duration[$i];
//                //dd($duration_row_count);
//                if ($duration_row_count != NULL){
//                    $service_date = $request->start_date[$i];
//                    $end_date = $request->end_date[$i];
//
//                    do {
//                        // initial
//                        $saleServiceDuration = SaleServiceDuration::where('sale_service_id',$sale_service_id)->first();
//                        $saleServiceDuration->sale_service_id = $insert_id;
//                        $saleServiceDuration->service_date = $service_date;
//
//                        //$x++;
//                        //$start_date = $request->start_date[$i];
//                        $add_next_service_date = $service_date."+".$duration_row_count." month";
//                        $nextServiceDate = date("Y-m-d",strtotime($add_next_service_date));
//                        //dd($saleServiceDuration);
//                        $saleServiceDuration->update();
//                        $service_date = $nextServiceDate;
//                    } while ($service_date <= $end_date);
//
//
//
//                }

                $duration_row_count = $request->duration[$i];
                if ($duration_row_count != NULL){

                    DB::table('sale_service_durations')->where('sale_service_id',$sale_service_id)->delete();

                    $service_date = $request->start_date[$i];
                    $end_date = $request->end_date[$i];
                    do {
                        // initial
                        $saleServiceDuration = new SaleServiceDuration();
                        $saleServiceDuration->sale_service_id = $insert_id;
                        $saleServiceDuration->service_date = $service_date;
                        $saleServiceDuration->save();
                        //$x++;
                        //$start_date = $request->start_date[$i];
                        $add_next_service_date = $service_date."+".$duration_row_count." month";
                        $nextServiceDate = date("Y-m-d",strtotime($add_next_service_date));

                        $service_date = $nextServiceDate;
                    } while ($service_date <= $end_date);
                }
            }
        }

        return redirect()->route('productSales.index');
    }

    public function productSaleRelationData(Request $request){
        $store_id = $request->store_id;
        $product_id = $request->current_product_id;
        $current_stock = Stock::where('store_id',$store_id)->where('product_id',$product_id)->latest()->pluck('current_stock')->first();
        $mrp_price = ProductPurchaseDetail::join('product_purchases', 'product_purchase_details.product_purchase_id', '=', 'product_purchases.id')
            ->where('store_id',$store_id)->where('product_id',$product_id)
//            ->max('product_purchase_details.mrp_price');
            ->orderBy('product_purchase_details.id','DESC')
        ->pluck('product_purchase_details.mrp_price')
        ->first();
        //return response()->json(['success'=>true,'data'=>$mrp_price]);
        if($mrp_price == null){
            $mrp_price = StockTransfer::join('stock_transfer_details', 'stock_transfer_details.stock_transfer_id', '=', 'stock_transfers.id')
                ->where('stock_transfers.to_store_id',$store_id)->where('product_id',$product_id)
                ->max('stock_transfer_details.mrp_price');
        }

        $product_category_id = Product::where('id',$product_id)->pluck('product_category_id')->first();
        $product_sub_category_id = Product::where('id',$product_id)->pluck('product_sub_category_id')->first();
        $product_brand_id = Product::where('id',$product_id)->pluck('product_brand_id')->first();
        $product_unit_id = Product::where('id',$product_id)->pluck('product_unit_id')->first();
        $options = [
            'mrp_price' => $mrp_price,
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





    public function invoice($id)
    {
        $productSale = ProductSale::find($id);

        $free_products = FreeProductSaleDetails::where('product_sale_id',$id)->get();
        $productSaleDetails = ProductSaleDetail::where('product_sale_id',$id)->get();
        $transactions = Transaction::where('ref_id',$id)->first();
//        /dd($transactions);
        $store_id = $productSale->store_id;
        $party_id = $productSale->party_id;
        $store = Store::find($store_id);
        $party = Party::find($party_id);
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return view('backend.productSale.invoice', compact('free_products','productSale','productSaleDetails','transactions','store','party','digit'));
    }
    public function Challaninvoice($id)
    {
        //dd($id);
        $productSale = ProductSale::find($id);
        $free_products = FreeProductSaleDetails::where('product_sale_id',$id)->get();
        //dd($free_products);
        $productSaleDetails = ProductSaleDetail::where('product_sale_id',$id)->get();
        $transactions = Transaction::where('ref_id',$id)->first();
        $store_id = $productSale->store_id;
        $party_id = $productSale->party_id;
        $store = Store::find($store_id);
        $party = Party::find($party_id);
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return view('backend.productSale.challan-invoice', compact('free_products','productSale','productSaleDetails','transactions','store','party','digit'));
    }
    public function invoicePrint($id)
    {
        $productSale = ProductSale::find($id);
        $free_products = FreeProductSaleDetails::where('product_sale_id',$id)->get();
        $productSaleDetails = ProductSaleDetail::where('product_sale_id',$id)->get();
        $transactions = Transaction::where('ref_id',$id)->get();
        $store_id = $productSale->store_id;
        $party_id = $productSale->party_id;
        $store = Store::find($store_id);
        $party = Party::find($party_id);
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return view('backend.productSale.invoice-print', compact('free_products','productSale','productSaleDetails','transactions','store','party','digit'));

    }
    public function ChallanPrint($id)
    {
        $productSale = ProductSale::find($id);
        $free_products = FreeProductSaleDetails::where('product_sale_id',$id)->get();
        $productSaleDetails = ProductSaleDetail::where('product_sale_id',$id)->get();
        $transactions = Transaction::where('ref_id',$id)->first();
        $store_id = $productSale->store_id;
        $party_id = $productSale->party_id;
        $store = Store::find($store_id);
        $party = Party::find($party_id);
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return view('backend.productSale.challan-invoice-print', compact('free_products','productSale','productSaleDetails','transactions','store','party','digit'));
    }

    public function invoicePrintCountNumber(Request $request){
        $productSale = ProductSale::find($request->product_sale_id);
        $productSale->invoice_count += 1;
        $affected_row = $productSale->save();
        if($affected_row){
            return $productSale->invoice_count;
        }else{
            return false;
        }
    }

    public function invoiceEdit($id)
    {
        $productSale = ProductSale::find($id);
        $free_products = FreeProductSaleDetails::where('product_sale_id',$id)->get();
        $productSaleDetails = ProductSaleDetail::where('product_sale_id',$productSale->id)->get();
        $transactions = Transaction::where('ref_id',$id)->get();
        $store_id = $productSale->store_id;
        $party_id = $productSale->party_id;
        $store = Store::find($store_id);
        $party = Party::find($party_id);
        //dd($productSaleDetails);

        $productCategories = ProductCategory::all();
        $productSubCategories = ProductSubCategory::all();
        $productBrands = ProductBrand::all();
        $products = Product::all();
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return view('backend.productSale.invoice-edit', compact('free_products','productSale','productSaleDetails','transactions','store','party','productCategories','productSubCategories','productBrands','products'));
    }

    public function updateInvoice(Request $request, $id){
        //dd($id);
        //dd($request->all());

        $row_count = count($request->product_id);
        $total_amount = $request->current_total_amount;
        for($i=0; $i<$row_count;$i++)
        {
            // product sale detail insert
            $purchase_sale_detail = new ProductSaleDetail();
            $purchase_sale_detail->product_sale_id = $id;
            //$purchase_sale_detail->return_type = $request->return_type[$i];
            $purchase_sale_detail->product_category_id = $request->product_category_id[$i];
            $purchase_sale_detail->product_sub_category_id = $request->product_sub_category_id[$i] ? $request->product_sub_category_id[$i] : NULL;
            $purchase_sale_detail->product_brand_id = $request->product_brand_id[$i];
            $purchase_sale_detail->product_id = $request->product_id[$i];
            $purchase_sale_detail->qty = $request->qty[$i];
            $purchase_sale_detail->price = $request->price[$i];
            $purchase_sale_detail->sub_total = $request->qty[$i]*$request->price[$i];
            $purchase_sale_detail->save();

            $product_id = $request->product_id[$i];
            $check_previous_stock = Stock::where('product_id',$product_id)->latest()->pluck('current_stock')->first();
            if(!empty($check_previous_stock)){
                $previous_stock = $check_previous_stock;
            }else{
                $previous_stock = 0;
            }
            // product stock insert
            $stock = new Stock();
            $stock->user_id = Auth::id();
            $stock->ref_id = $id;
            $stock->store_id = $request->store_id;
            $stock->product_id = $request->product_id[$i];
            $stock->stock_type = 'sale';
            $stock->previous_stock = $previous_stock;
            $stock->stock_in = 0;
            $stock->stock_out = $request->qty[$i];
            $stock->current_stock = $previous_stock - $request->qty[$i];
            $stock->date = date('Y-m-d');
            $stock->save();
        }

        // product sale update
        $productSale = ProductSale::find($id);
        $productSale->user_id = Auth::id();
        //$productSale->party_id = $request->party_id;
        $productSale->store_id = $request->store_id;
        //$productSale->payment_type = $request->payment_type;
        //$productSale->delivery_service = $request->delivery_service;
        //$productSale->delivery_service_charge = $request->delivery_service_charge;
        $productSale->discount_type = $request->discount_type;
        $productSale->discount_amount = $request->discount_amount;
        $productSale->total_amount = $total_amount;
        $productSale->paid_amount = $request->paid_amount;
        $productSale->due_amount = $request->due_amount;
        $productSale->update();



        // due update
        $due = Due::where('ref_id',$id)->first();;
        $due->user_id = Auth::id();
        $due->store_id = $request->store_id;
        //$due->party_id = $request->party_id;
        //$due->payment_type = $request->payment_type;
        $due->total_amount = $total_amount;
        $due->paid_amount = $request->paid_amount;
        $due->due_amount = $request->due_amount;
        $due->update();

        // transaction update
        $transaction = Transaction::where('ref_id',$id)->where('transaction_type','sale')->first();
        $transaction->user_id = Auth::id();
        $transaction->store_id = $request->store_id;
        //$transaction->party_id = $request->party_id;
        //$transaction->payment_type = $request->payment_type;
        $transaction->amount = $total_amount;
        $transaction->update();


        Toastr::success('Invoice Updated Successfully', 'Success');
        return redirect()->route('productSales.index');
    }

    public function newParty(Request $request){

        $this->validate($request, [
            'name' => 'required',
        ]);
        $parties = new Party();
        $parties->type = $request->type;
        $parties->name = $request->name;
        $parties->phone = $request->phone;
        $parties->email = $request->email;
        $parties->address = $request->address;
        $parties->status = 1;
        $parties->save();
        $insert_id = $parties->id;
        $text_for_customer = "Dear  $parties->name Sir,
Thank you for purchasing from CleanTech Engineering, your Customer ID is  C000$insert_id.
Rate us on www.facebook.com/cleantechbd and order online from www.cleantech.com.bd
For any queries call our support 09638-888 000..";
        UserInfo::smsAPI("88".$parties->phone,$text_for_customer);
        if ($insert_id){
            // $sdata['id'] = $insert_id;
            $sdata['name'] = $parties->name;
            $sdata['email'] = $parties->email;
            $sdata['phone'] = $parties->phone;
            $sdata['password'] = Hash::make(123456);
            $sdata['party_id'] = $insert_id;
//            $sdata['role_id'] = 3;
            echo json_encode($sdata);
            $user = User::create($sdata);

            $user->assignRole('Customer');
            //dd($user);
        }

        else {
            $data['exception'] = 'Some thing mistake !';
            echo json_encode($data);

        }
        $account = DB::table('accounts')->where('HeadLevel',3)->where('HeadCode', 'like', '1010301%')->Orderby('created_at', 'desc')->limit(1)->first();
        //dd($account);
        if(!empty($account)){
            $headcode=$account->HeadCode+1;
            //$p_acc = $headcode ."-".$request->name;
        }else{
            $headcode="1010301";
            //$p_acc = $headcode ."-".$request->name;
        }
        $p_acc = $request->name;

        $PHeadName = 'Account Receivable';
        $HeadLevel = 3;
        $HeadType = 'A';


        $account = new Account();
        $account->party_id      = $insert_id;
        $account->HeadCode      = $headcode;
        $account->HeadName      = $p_acc;
        $account->PHeadName     = $PHeadName;
        $account->HeadLevel     = $HeadLevel;
        $account->IsActive      = '1';
        $account->IsTransaction = '1';
        $account->IsGL          = '1';
        $account->HeadType      = $HeadType;
        $account->CreateBy      = Auth::User()->id;
        $account->UpdateBy      = Auth::User()->id;
        $account->save();


    }

    public function payDue(Request $request){
        //dd($request->all());
        $product_sale_id = $request->product_sale_id;
        $product_sale = ProductSale::find($product_sale_id);

        $total_amount=$product_sale->total_amount;
        $paid_amount=$product_sale->paid_amount;

        $product_sale->paid_amount=$paid_amount+$request->new_paid;
        $product_sale->due_amount=$total_amount-($paid_amount+$request->new_paid);
        $product_sale->update();

        $due = new Due();
        $due->invoice_no=$product_sale->invoice_no;
        $due->ref_id=$request->product_sale_id;
        $due->user_id=$product_sale->user_id;
        $due->store_id=$product_sale->store_id;
        $due->party_id=$product_sale->party_id;
        //$due->payment_type=$product_sale->payment_type;
        $due->total_amount=$product_sale->total_amount;
        $due->paid_amount=$request->new_paid;
        $due->due_amount=$total_amount-($paid_amount+$request->new_paid);
        $due->save();

        // transaction
        $transaction = new Transaction();
        $transaction->invoice_no = $product_sale->invoice_no;
        $transaction->user_id = Auth::id();
        $transaction->store_id = $product_sale->store_id;
        $transaction->party_id = $product_sale->party_id;
        $transaction->ref_id = $product_sale->id;
        $transaction->transaction_type = 'due';
        $transaction->payment_type = $request->payment_type;
        $transaction->check_number = $request->check_number ? $request->check_number : '';
        $transaction->check_date = $request->check_date ? $request->check_date : '';
        $transaction->amount = $request->new_paid;
        $transaction->date = date('Y-m-d');
        $transaction->save();

        Toastr::success('Due Pay Successfully', 'Success');
        return redirect()->back();

    }

    public function customerDue()
    {
        $auth_user_id = Auth::user()->id;
        $auth_user = Auth::user()->roles[0]->name;
        if($auth_user == "Admin"){
            $productSales = ProductSale::where('due_amount','>',0)->latest()->get();
        }else{
            $productSales = ProductSale::where('user_id',$auth_user_id)->where('due_amount','>',0)->get();
        }
        return view('backend.productSale.customer_due',compact('productSales'));
    }

}
