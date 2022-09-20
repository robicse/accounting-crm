<?php

namespace App\Http\Controllers;

use App\Due;
use App\Party;
use App\Product;
use App\ProductBrand;
use App\ProductCategory;
use App\ProductPurchaseDetail;
use App\ProductSale;
use App\ProductSaleDetail;
use App\ProductSubCategory;
use App\Stock;
use App\StockMinusLog;
use App\Store;
use App\Transaction;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ProductPosSaleController extends Controller
{
    public function index()
    {
        // just check where goes stock minus
        if(check_stock_minus_logs_exists() > 0){
            Toastr::warning('Stock went to minus, Please contact with administrator!', 'warning');
            return redirect()->route('home');
        }

        //Session::put('product_sale_id',14);
        Session::forget('product_sale_id');

        $auth_user_id = Auth::user()->id;
        $auth_user = Auth::user()->roles[0]->name;
        if($auth_user == "Admin"){
            $productPosSales = ProductSale::where('sale_type','pos')->latest()->get();
        }else{
            $productPosSales = ProductSale::where('sale_type','pos')->where('user_id',$auth_user_id)->latest()->get();
        }
        return view('backend.productPosSale.index',compact('productPosSales'));
    }

    public function create()
    {
        $auth = Auth::user();
        $auth_user = Auth::user()->roles[0]->name;
        $parties = Party::where('type','customer')->get() ;
        if($auth_user == "Admin"){
            $stores = Store::all();
        }else{
            $stores = Store::where('id',$auth->store_id)->get();
        }
        $productCategories = ProductCategory::all();
        $productSubCategories = ProductSubCategory::all();
        $productBrands = ProductBrand::all();
        $products = DB::table('product_purchase_details')
            ->select('product_purchase_details.product_id','product_purchase_details.barcode')
            ->leftJoin('products','products.id','=','product_purchase_details.product_id')
            ->groupBy('product_purchase_details.product_id')
            ->groupBy('product_purchase_details.barcode')
            ->latest('products.id')->get();

        return view('backend.productPosSale.create',compact('parties','stores','products','productCategories','productSubCategories','productBrands'));
    }

    public function selectedform($barcode, $store_id){

        $baseurl = URL('/pos_insert');


        $html = "<form name=\"form\" id=\"form\" action=\"".$baseurl."\" method=\"post\" enctype=\"multipart/form-data\">
                    <div class=\"form-group row\">
                    <div class=\"col-md-8\">
                    <input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\" />
                    <input type=\"hidden\" name=\"store_id\" value=\"".$store_id."\" />
                    <div class=\"table-responsive\">
                    <table class=\"table table-striped\">
                        <thead>
                            <tr>
                                <th width=\"30\">No</th>
                                <th>Barcode</th>
                                <th>Product Name</th>
                                <th align=\"right\">Price</th>
                                <th>Quantity</th>
                                <th align=\"right\">Sub Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>";
        if(Cart::count() > 0):
            foreach(Cart::content() as $item):
                $html .= "<tr>";
                $html .= "<th width=\"30\">1</th>";
                $html .= "<th>".$item->options['barcode']."</th>";
                $html .= "<th>".$item->name."</th>";
                $html .= "<th align=\"right\">".$item->price."</th>";
                //$html .= "<th><input type=\"text\" value=\"".$item->qty."\" size=\"28\" </th>";
                $html .= "<th>".$item->qty."</th>";
                $html .= "<th align=\"right\">".$item->price."</th>";
                $html .= "<th><input type=\"button\" class=\"btn btn-warning\" name=\"remove\" id=\"remove\" size=\"28\" value=\"Remove\" onClick=\"deleteCart('$item->rowId')\" /></th>";
                $html .= "</tr>";
            endforeach;
            $html .= "<tr><th align=\"right\" colspan=\"7\"><input type=\"button\" class=\"btn btn-danger\" name=\"remove\" id=\"remove\" size=\"28\" value=\"Clear Item\" onClick=\"deleteAllCart()\" /></th></tr>";
        endif;
        $html .= "</tbody>
                    </table>
                    </div>
                    </div>

                    <div class=\"col-md-4\">
                        <div class=\"form-group row\">
                            <label for=\"sub_total\" class=\"col-md-4 control-label\">Sub Total</label>
                            <div class=\"col-md-8\">
                                <input type=\"text\" class=\"form-control\" id=\"sub_total\" value=\"".Cart::subtotal()."\" readonly>
                            </div>
                        </div>
                        <div class=\"form-group row\">
                            <label for=\"member\" class=\"col-md-4 control-label\">Customer</label>
                            <div class=\"col-md-8\">
                                <div class=\"input-group\">
                                    <input id=\"member\" type=\"text\" class=\"form-control\" name=\"customer\" value=\"Mr.\">
                                    <span class=\"input-group-btn\">
                                      <button onclick=\"showMember()\" type=\"button\" class=\"btn btn-info\">select</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class=\"form-group row\">
                            <label for=\"vat_amount\" class=\"col-md-4 control-label\">Vat(Percentage)</label>
                            <div class=\"col-md-4\">
                                <input type=\"text\" class=\"form-control\" id=\"vat_amount\" onkeyup=\"vatAmount('')\" value=\"0\">
                            </div>
                            <div class=\"col-md-4\">
                                <input type=\"text\" class=\"form-control\" name=\"vat_amount\" id=\"show_vat_amount\" value=\"0\" readonly>
                            </div>
                        </div>
                        <div class=\"form-group row\">
                            <label for=\"discount_amount\" class=\"col-md-4 control-label\">Discount(Flat)</label>
                            <div class=\"col-md-8\">
                                <input type=\"number\" class=\"form-control\" name=\"discount_amount\" id=\"discount_amount\" onkeyup=\"discountAmount('')\" value=\"0\">
                            </div>
                        </div>
                        <div class=\"form-group row\">
                            <label for=\"grand_total\" class=\"col-md-4 control-label\">Grand Total</label>
                            <div class=\"col-md-8\">
                                <input type=\"hidden\" class=\"form-control\" id=\"store_grand_total\" value=\"".Cart::subtotal()."\" readonly>
                                <input type=\"text\" class=\"form-control\" name=\"grand_total\" id=\"grand_total\" value=\"".Cart::subtotal()."\" readonly>
                            </div>
                        </div>
                        <div class=\"form-group row\">
                            <label for=\"paid_amount\" class=\"col-md-4 control-label\">Paid</label>
                            <div class=\"col-md-8\">
                                <input type=\"number\" class=\"form-control\" value=\"0\" name=\"paid_amount\" onkeyup=\"paidAmount('')\" id=\"paid_amount\">
                            </div>
                        </div>
                        <div class=\"form-group row\">
                            <label for=\"due_amount\" class=\"col-md-4 control-label\">Due</label>
                            <div class=\"col-md-8\">
                                <input type=\"text\" class=\"form-control\" id=\"due_amount\" name=\"due_amount\" value=\"".Cart::subtotal()."\" readonly>
                            </div>
                        </div>
                        <div class=\"form-group row\">
                            <label for=\"due_amount\" class=\"col-md-4 control-label\">Payment Type</label>
                            <div class=\"col-md-8\">
                                <select class=\"form-control\" id=\"payment_type\" name=\"payment_type\" onchange=\"productType('')\">
                                    <option value=\"Cash\">Cash</option>
                                    <option value=\"Check\">Check</option>
                                </select>
                                <span>&nbsp;</span>
                                <input type=\"text\" name=\"check_number\" id=\"check_number\" class=\"form-control\" placeholder=\"Check Number\" readonly=\"readonly\">
                            </div>
                        </div>
                        <div class=\"box-footer\">
                        <div class=\"col-md-8\">
                            <button type=\"submit\" class=\"btn btn-primary pull-right simpan\"><i class=\"fa fa-floppy-o\"></i> Save</button>
                        </div>
                    </div>
                    </div>
            </form>";
        echo json_encode($html);

    }

    public function postInsert(Request $request){
        //dd($request->all());
        $customer = $request->customer;
        if(is_numeric($customer) && strlen($customer) > 9){
            $customer_check_exits = Party::where('phone',$customer)->pluck('id')->first();
            if($customer_check_exits){
                $customer_id = $customer_check_exits;
            }else{
                $parties = new Party();
                $parties->type = 'customer';
                $parties->name = '';
                $parties->phone = $customer;
                $parties->slug = Str::slug($customer);
                $parties->email = '';
                $parties->address = '';
                $parties->status = 1;
                $parties->save();
                $customer_id = $parties->id;
            }
        }elseif(is_string($customer)){
            if($customer == 'Mr.'){
                $customer_check_exits = Party::where('name',$customer)->pluck('id')->first();
                if($customer_check_exits){
                    $customer_id = $customer_check_exits;
                }else{
                    $parties = new Party();
                    $parties->type = 'customer';
                    $parties->name = $customer;
                    $parties->slug = Str::slug($customer);
                    $parties->phone = '01700000000';
                    $parties->email = 'mr@gamil.com';
                    $parties->address = '';
                    $parties->status = 1;
                    $parties->save();
                    $customer_id = $parties->id;
                }
            }else{
                $customer_check_exits = Party::where('id',$customer)->pluck('id')->first();
                if($customer_check_exits){
                    $customer_id = $customer_check_exits;
                }else{
                    $parties = new Party();
                    $parties->type = 'customer';
                    $parties->name = $customer;
                    $parties->slug = Str::slug($customer);
                    $parties->phone = '';
                    $parties->email = '';
                    $parties->address = '';
                    $parties->status = 1;
                    $parties->save();
                    $customer_id = $parties->id;
                }
            }
        }else{
            $customer_id = $request->customer;
        }

//        echo $customer_id;
//        echo '<pre>';
//        print_r($request->all());
//        echo '</pre>';
//        dd(Cart::content());


        //$total_amount = Cart::subtotal();
        $vat_amount = $request->vat_amount;
        $discount_amount = $request->discount_amount;
        $total_amount = $request->grand_total;
        $paid_amount = $request->paid_amount;
        $due_amount = $request->due_amount;
        $payment_type = $request->payment_type;
        $check_number = $request->check_number;



        $get_invoice_no = ProductSale::latest()->pluck('invoice_no')->first();
        if(!empty($get_invoice_no)){
            $invoice_no = $get_invoice_no+1;
        }else{
            $invoice_no = 1000;
        }

        // product purchase
        $productSale = new ProductSale();
        $productSale->invoice_no = $invoice_no;
        $productSale->user_id = Auth::id();
        $productSale->party_id = $customer_id;
        $productSale->store_id = $request->store_id;
        $productSale->date = date('Y-m-d');
        $productSale->delivery_service = NULL;
        $productSale->delivery_service_charge = 0;
        $productSale->vat_type = 'percentage';
        $productSale->vat_amount = $vat_amount;
        $productSale->discount_type = 'flat';
        $productSale->discount_amount = $discount_amount;
        $productSale->total_amount = $total_amount;
        $productSale->paid_amount = $paid_amount;
        $productSale->due_amount = $due_amount;
        $productSale->sale_type = 'pos';
        $productSale->save();
        $insert_id = $productSale->id;
        if($insert_id)
        {
            foreach (Cart::content() as $content) {
                $product = Product::where('id',$content->id)->first();

                // product purchase detail
                $purchase_sale_detail = new ProductSaleDetail();
                $purchase_sale_detail->product_sale_id = $insert_id;
                $purchase_sale_detail->return_type = 'not returnable';
                $purchase_sale_detail->product_category_id = $product->product_category_id;
                $purchase_sale_detail->product_sub_category_id = $product->product_sub_category_id ? $product->product_sub_category_id : NULL;
                $purchase_sale_detail->product_brand_id = $product->product_brand_id;
                $purchase_sale_detail->product_unit_id = $product->product_unit_id;
                $purchase_sale_detail->product_id = $content->id;
                $purchase_sale_detail->qty = $content->qty;
                $purchase_sale_detail->price = $content->price;
                $purchase_sale_detail->sub_total = $content->qty*$content->price;
                $purchase_sale_detail->save();

                $check_previous_stock = Stock::where('product_id',$content->id)->latest()->pluck('current_stock')->first();
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
                $stock->date = date('Y-m-d');
                $stock->product_id = $content->id;
                $stock->stock_type = 'sale';
                $stock->previous_stock = $previous_stock;
                $stock->stock_in = 0;
                $stock->stock_out = $content->qty;
                $stock->current_stock = $previous_stock - $content->qty;
                $stock->save();

                // stock minus log
                if($stock->current_stock < 0){
                    $stock_minus_log = new StockMinusLog();
                    $stock_minus_log->user_id=Auth::user()->id;
                    $stock_minus_log->action_module='Product POOS Sale';
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
            $due->party_id = $customer_id;
            $due->total_amount = $total_amount;
            $due->paid_amount = $request->paid_amount;
            $due->due_amount = $request->due_amount;
            $due->save();

            // transaction
            $transaction = new Transaction();
            $transaction->invoice_no = $invoice_no;
            $transaction->user_id = Auth::id();
            $transaction->store_id = $request->store_id;
            $transaction->party_id = $customer_id;
            $transaction->date = date('Y-m-d');
            $transaction->ref_id = $insert_id;
            $transaction->transaction_type = 'sale';
            $transaction->payment_type = $payment_type;
            $transaction->check_number = $check_number ? $check_number : '';
            $transaction->amount = $paid_amount;
            $transaction->save();

            // session add product sale id
            Session::put('product_sale_id',$insert_id);

            Toastr::success('Order Successfully done! ');
            Cart::destroy();
            return back();
        }else{
            Toastr::warning('Something went wrong! ');
            Cart::destroy();
            return back();
        }
    }

}
