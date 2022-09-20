<?php

namespace App\Http\Controllers;

use App\Due;
use App\FreeProduct;
use App\FreeProductSaleDetails;
use App\Helpers\UserInfo;
use App\OnlinePlatForm;
use App\Party;
use App\Product;
use App\ProductBrand;
use App\ProductCategory;
use App\ProductPurchaseDetail;
use App\ProductSale;
use App\ProductSaleDetail;
use App\ProductSubCategory;
use App\ProductUnit;
use App\Stock;
use App\StockMinusLog;
use App\StockTransfer;
use App\Store;
use App\Transaction;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductWholeSaleController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {

        $auth = Auth::user();
        $auth_user = Auth::user()->roles[0]->name;
        $parties = Party::Where('type', 'own')->get() ;
//dd($parties);
//        $parties = Party::where('type','customer')->get() ;
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
        return view('backend.productSale.wholeSalecreate',compact('online_platforms','freeProducts','parties','stores','products','productCategories','productSubCategories','productBrands','productUnits'));
    }


    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'party_id'=> 'required',
            'store_id'=> 'required',

        ]);

        $row_count = count($request->product_id);
        for($i=0; $i<$row_count;$i++)
        {

            $product_id = $request->product_id[$i];
            $check_previous_stock = Stock::where('product_id',$product_id)->where('store_id',$request->store_id)->latest()->pluck('current_stock')->first();
            //dd($check_previous_stock);
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
        $vat_amount =($total_amount*$request->vat_amount)/100;
        if($discount_type == 'flat'){
            $total_amount -= $request->discount_amount;
        }else{
            $total_amount = ($total_amount*$request->discount_amount)/100;
        }

        $get_invoice_no = ProductSale::latest()->pluck('invoice_no')->first();
        //dd($get_invoice_no);
        if(!empty($get_invoice_no)){
            $invoice_no = $get_invoice_no+1;
        }else{
            $invoice_no = 1000;
        }
        //dd($invoice_no);

        // product purchase
        $productSale = new ProductSale();
        $productSale->invoice_no = $invoice_no;
        $productSale->user_id = Auth::id();
        $productSale->party_id = $request->party_id;
        $productSale->online_platform_id = $request->online_platform_id;
        $productSale->store_id = $request->store_id;
        $productSale->date = $request->date;
        $productSale->note = $request->note;
        $productSale->reference_name = $request->reference_name;
        $productSale->sale_type ="Whole Sale";
        $productSale->online_platform_invoice_no = $request->online_platform_invoice_no ? $request->online_platform_invoice_no : '';
        $productSale->discount_type = $request->discount_type;
        $productSale->discount_amount = $request->discount_amount;
        //$productSale->vat_type = $request->vat_type;
        $productSale->vat_amount = $request->vat_amount;
        $productSale->total_amount = $total_amount;
        $productSale->total_amount = $request->total_amount;;
        $productSale->paid_amount = $request->paid_amount;
        $productSale->due_amount = $request->due_amount;
        $productSale->transport_cost = $request->transport_cost;
        $productSale->transport_area = $request->transport_area;
        $productSale->conditions = $request->conditions;
        //dd($productSale);
        $productSale->save();
        $insert_id = $productSale->id;
        if($insert_id)
        {
            for($i=0; $i<$row_count;$i++)
            {
                // product purchase detail
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
                $product_sale_detail_id = $purchase_sale_detail->id;

                $product_id = $request->product_id[$i];
                $check_previous_stock = Stock::where('product_id',$product_id)->where('store_id',$request->store_id)->latest()->pluck('current_stock')->first();
                if(!empty($check_previous_stock)){
                    $previous_stock = $check_previous_stock;
                }else{
                    $previous_stock = 0;
                }
                // product stock
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
                $stock->sale_type ="Whole Sale";
                $stock->previous_stock = $previous_stock;
                $stock->stock_in = 0;
                $stock->stock_out = $request->qty[$i];
                $stock->current_stock = $previous_stock - $request->qty[$i];
                $stock->save();

                // stock minus log
                if($stock->current_stock < 0){
                    $stock_minus_log = new StockMinusLog();
                    $stock_minus_log->user_id=Auth::user()->id;
                    $stock_minus_log->action_module='Product Whole Sale';
                    $stock_minus_log->action_done='Store';
                    $stock_minus_log->action_remarks='Sale ID: '.$insert_id;
                    $stock_minus_log->action_date=date('Y-m-d');
                    $stock_minus_log->save();
                }
            }

            // due
            $due = new Due();
            $due->invoice_no = $invoice_no;
            $due->ref_id = $insert_id;
            $due->user_id = Auth::id();
            $due->store_id = $request->store_id;
            $due->party_id = $request->party_id;
            //$due->payment_type = $request->payment_type;
            //$due->check_number = $request->check_number ? $request->check_number : '';
            $due->total_amount = $total_amount;
            $due->paid_amount = $request->paid_amount;
            $due->due_amount = $request->due_amount;
            $due->save();

            // transaction
            $transaction = new Transaction();
            $transaction->invoice_no = $invoice_no;
            $transaction->user_id = Auth::id();
            $transaction->store_id = $request->store_id;
            $transaction->party_id = $request->party_id;
            $transaction->date = $request->date;
            $transaction->ref_id = $insert_id;
            $transaction->transaction_type = 'sale';
            $transaction->sale_type = "Whole Sale";
            $transaction->payment_type = $request->payment_type;
            $transaction->check_number = $request->check_number ? $request->check_number : '';
            $transaction->check_date = $request->check_date ? $request->check_date : '';
            //$transaction->amount = $total_amount;
            $transaction->amount = $request->paid_amount;
            $transaction->save();
        }

        if($insert_id)
        {
            for($i=0; $i<$row_count_free_product;$i++)
            {
                // product purchase detail
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
            $customer_id = $customer->id;
        }else{
            $customer_name = '';
            $customer_phone = '';
            $customer_id = '';
        }

        if($insert_id)
        {
            $text_for_customer = "Dear, $customer_name  Sir,Thank you for purchasing from CleanTech Engineering, Invoice Number is $invoice_no .Rate us on www.facebook.com/cleantechbd and order online from www.cleantech.com.bd
For any queries call our support 09638-888 000";
            //dd($text_for_provider);
            UserInfo::smsAPI("88".$customer_phone,$text_for_customer);
        }


        Toastr::success('Product Sale Created Successfully', 'Success');
        if($request->print_now == 1){
            //return redirect()->route('productSales-invoice',$insert_id);
            return redirect()->route('productSales-invoice-print',$insert_id);
        }else{
            return redirect()->route('productSales.index');
        }

    }

    public function show($id)
    {
        //
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
        $parties = Party::Where('type', 'own')->get() ;
        $products = Product::all();
        $productSale = ProductSale::find($id);
        $productCategories = ProductCategory::all();
        $productSubCategories = ProductSubCategory::all();
        $productBrands = ProductBrand::all();
        $productUnits = ProductUnit::all();
        $providers = User::where('type' , 'provider' )->get() ;
        $productSaleDetails = ProductSaleDetail::where('product_sale_id',$id)->get();
        $freeProductDetails =  FreeProductSaleDetails::where('product_sale_id',$id)->get();
        // dd($productSale);
        $transaction = Transaction::where('ref_id',$id)->first();
        $stock_id = Stock::where('ref_id',$id)->where('stock_type','purchase')->pluck('id')->first();
        $online_platforms = OnlinePlatForm::all();
        $freeProducts = FreeProduct::all();
        return view('backend.productSale.WholeSaleedit',compact('providers','online_platforms','freeProductDetails','freeProducts','parties','stores','products','productSale','productSaleDetails','productCategories','productSubCategories','productBrands','productUnits','transaction','stock_id'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'party_id'=> 'required',
            'store_id'=> 'required',
        ]);

        $row_count = count($request->product_id);
        $store_id = $request->store_id;
        // product purchase
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
        $productSale->sale_type ="Whole Sale edit";
        $productSale->online_platform_id = $request->online_platform_id;
        $productSale->online_platform_invoice_no = $request->online_platform_invoice_no ? $request->online_platform_invoice_no : '';
        $productSale->discount_type = $request->discount_type;
        $productSale->discount_amount = $request->discount_amount;
        $productSale->conditions = $request->conditions;
        $productSale->total_amount =$request->total_amount;
        $productSale->paid_amount = $request->paid_amount;
        $productSale->due_amount = $request->due_amount;
        $productSale->transport_cost = $request->transport_cost;
        $productSale->transport_area = $request->transport_area;
        $productSale->update();

        for($i=0; $i<$row_count;$i++)
        {
            // product purchase detail
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
                    stock_minus_log('Product Whole Sale','Update',$action_remarks);
                }
            }else{
                if($invoice_sale_qty != $new_request_qty){
                    $update = update_stock_for_edit_sale_stock($id,$store_id,'sale',$new_request_qty,$invoice_sale_qty,$previous_current_stock,$product_id);
                    if($update && ($previous_current_stock < 0)){
                        $action_remarks = 'Sale ID: '.$id;
                        stock_minus_log('Product Whole Sale','Update',$action_remarks);
                    }
                }
            }

            // product stock
//            $store_id=$productSale->store_id;
//            $stock_row = current_stock_row($store_id,'sale',$product_id);
//            $previous_stock = $stock_row->previous_stock;
//            $stock_out = $stock_row->stock_out;
//
//            if($stock_out != $request_qty){
//                $stock_row->user_id = Auth::id();
//                $stock_row->store_id = $request->store_id;
//                $stock_row->product_id = $product_id;
//                $stock_row->previous_stock = $previous_stock;
//                $stock_row->stock_in = 0;
//                $stock_row->stock_out = $request_qty;
//                $new_stock_out = $previous_stock - $request_qty;
//                $stock_row->current_stock = $new_stock_out;
//                $stock_row->update();
//
//                // stock minus log
//                if($stock_row->current_stock < 0){
//                    $stock_minus_log = new StockMinusLog();
//                    $stock_minus_log->user_id=Auth::user()->id;
//                    $stock_minus_log->action_module='Product Whole Sale';
//                    $stock_minus_log->action_done='Update';
//                    $stock_minus_log->action_remarks='Sale ID: '.$id;
//                    $stock_minus_log->action_date=date('Y-m-d');
//                    $stock_minus_log->save();
//                }
//            }
        }

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

        // transaction
        $transaction = Transaction::where('ref_id',$id)->where('transaction_type','sale')->first();
        if(!empty($transaction)) {
            $transaction->user_id = Auth::id();
            $transaction->store_id = $request->store_id;
            $transaction->party_id = $request->party_id;
            $transaction->date = $request->date;
            $transaction->sale_type = "Whole Sale edit";
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
                // free product sale details
                $free_product_sale_detail_id = $request->free_product_detail_id[$i];
                $freeProduct_sale_detail = FreeProductSaleDetails::where('id',$free_product_sale_detail_id)->first();
                if(!empty($freeProduct_sale_detail)) {
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
        //
    }
    public function productWholeSaleRelationData(Request $request){
        $party_id = $request->party_id;
        $store_id = $request->store_id;
        $product_id = $request->current_product_id;
        $current_stock = Stock::where('store_id',$store_id)->where('product_id',$product_id)->latest()->pluck('current_stock')->first();


        $check_party_previous_product_sale_price = ProductSale::join('product_sale_details','product_sales.id','product_sale_details.product_sale_id')
            ->where('product_sales.party_id',$party_id)
            ->where('product_sales.store_id',$store_id)
            ->where('product_sale_details.product_id',$product_id)
            ->orderBy('product_sale_details.id','DESC')
            ->pluck('product_sale_details.price')
            ->first();

        if(!empty($check_party_previous_product_sale_price)){
            $wholeSale_price = $check_party_previous_product_sale_price;
        }else{
            $wholeSale_price = ProductPurchaseDetail::join('product_purchases', 'product_purchase_details.product_purchase_id', '=', 'product_purchases.id')
                ->where('store_id',$store_id)->where('product_id',$product_id)
                ->orderBy('product_purchase_details.id','DESC')
                ->pluck('product_purchase_details.wholeSale_price')
                ->first();

            if($wholeSale_price == null){
                $wholeSale_price = StockTransfer::join('stock_transfer_details', 'stock_transfer_details.stock_transfer_id', '=', 'stock_transfers.id')
                    ->where('stock_transfers.to_store_id',$store_id)->where('product_id',$product_id)
                    ->max('stock_transfer_details.wholeSale_price');
            }
        }

//        $wholeSale_price = ProductPurchaseDetail::join('product_purchases', 'product_purchase_details.product_purchase_id', '=', 'product_purchases.id')
//            ->where('store_id',$store_id)->where('product_id',$product_id)
////            ->max('product_purchase_details.wholeSale_price');
//            ->orderBy('product_purchase_details.id','DESC')
//            ->pluck('product_purchase_details.wholeSale_price')
//            ->first();
//
//        if($wholeSale_price == null){
//            $wholeSale_price = StockTransfer::join('stock_transfer_details', 'stock_transfer_details.stock_transfer_id', '=', 'stock_transfers.id')
//                ->where('stock_transfers.to_store_id',$store_id)->where('product_id',$product_id)
//                ->max('stock_transfer_details.wholeSale_price');
//        }





        $product_category_id = Product::where('id',$product_id)->pluck('product_category_id')->first();
        $product_sub_category_id = Product::where('id',$product_id)->pluck('product_sub_category_id')->first();
        $product_brand_id = Product::where('id',$product_id)->pluck('product_brand_id')->first();
        $product_unit_id = Product::where('id',$product_id)->pluck('product_unit_id')->first();
        $options = [
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
}
