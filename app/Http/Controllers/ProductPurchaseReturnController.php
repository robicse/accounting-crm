<?php

namespace App\Http\Controllers;

use App\Party;
use App\ProductPurchase;
use App\ProductPurchaseDetail;
use App\ProductPurchaseReturn;
use App\ProductPurchaseReturnDetail;
use App\Stock;
use App\StockMinusLog;
use App\Store;
use App\Transaction;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductPurchaseReturnController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:product-purchase-return-list|product-sale-return-create|product-purchase-return-edit|product-purchase-return-delete', ['only' => ['index','show','returnablePurchaseProduct','saleProductReturn']]);
        $this->middleware('permission:product-purchase-return-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-purchase-return-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-purchase-return-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        // just check where goes stock minus
        if(check_stock_minus_logs_exists() > 0){
            Toastr::warning('Stock went to minus, Please contact with administrator!', 'warning');
            return redirect()->route('home');
        }

        $productPurchaseReturns = ProductPurchaseReturn::all();
       // dd($productPurchaseReturns);
        return view('backend.productPurchaseReturn.index',compact('productPurchaseReturns'));
    }


    public function create()
    {
        //
    }
    public function returnablePurchaseProduct()
    {
        $auth_user_id = Auth::user()->id;
        $auth_user = Auth::user()->roles[0]->name;
        $parties = Party::where('type','supplier')->get() ;
        if($auth_user == "Admin"){
            $stores = Store::all();
        }else{
            $stores = Store::where('user_id',$auth_user_id)->get();
        }
        $productPurchases = ProductPurchase::latest()->get();


        return view('backend.productPurchaseReturn.returnable_purchase_products',compact('parties','stores','productPurchases'));
    }
    public function getReturnablePurchaseProduct($purchase_id){
        $productPurchase = ProductPurchase::where('id',$purchase_id)->first();
        $products = DB::table('product_purchase_details')
            ->join('products','product_purchase_details.product_id','=','products.id')
            ->where('product_purchase_details.product_purchase_id',$purchase_id)
            ->select('product_purchase_details.id','product_purchase_details.product_id','product_purchase_details.qty','product_purchase_details.price','products.name')
            ->get();

        $html = "<table class=\"table table-striped tabel-penjualan\">
                        <thead>
                            <tr>
                                 <th width=\"30\">No</th>
                                <th>Product Name</th>
                                <th align=\"right\">Received Quantity</th>
                                 <th>Unit Price</th>
                                 <th>Already Return Quantity</th>
                                 <th>Already Return Amount</th>
                                <th>Return Quantity</th>
                                <th>Return Amount</th>
                                <th>Reason</th>
                            </tr>
                        </thead>
                        <tbody>";
        if(count($products) > 0):
            foreach($products as $key => $item):
                $check_purchase_return_qty = check_purchase_return_qty($productPurchase->store_id,$item->product_id,$productPurchase->invoice_no);
                $check_purchase_return_price = check_purchase_return_price($productPurchase->store_id,$item->product_id,$productPurchase->invoice_no);
                $key += 1;
                $html .= "<tr>";
                $html .= "<th width=\"30\">1</th>";
                $html .= "<th><input type=\"hidden\" class=\"form-control\" name=\"product_id[]\" id=\"product_id_$key\" value=\"$item->product_id\" size=\"28\" /><input type=\"hidden\" class=\"form-control\" name=\"product_purchase_detail_id[]\" id=\"product_sale_detail_id_$key\" value=\"$item->id\" size=\"28\" />$item->name</th>";
                $html .= "<th><input type=\"text\" class=\"form-control\" name=\"qty[]\" id=\"qty_$key\" value=\"$item->qty\" size=\"28\" readonly /></th>";
                $html .= "<th><input type=\"text\" class=\"form-control\" name=\"total_amount[]\" id=\"total_amount_$key\"  value=\"$item->price\" size=\"28\" readonly/></th>";
                $html .= "<th><input type=\"text\" class=\"form-control\" name=\"check_purchase_return_qty[]\" id=\"check_purchase_return_qty_$key\" value=\"$check_purchase_return_qty\" readonly /></th>";
                $html .= "<th><input type=\"text\" class=\"form-control\" name=\"total_return_amount[]\" id=\"total_return_amount_$key\"  value=\"$check_purchase_return_price\" size=\"28\" readonly/></th>";
                $html .= "<th><input type=\"text\" class=\"form-control\" name=\"return_qty[]\" id=\"return_qty_$key\" onkeyup=\"return_qty($key,this);\" size=\"28\" /></th>";


                $html .= "<th><input type=\"text\" class=\"form-control\" name=\"return_amount[]\" id=\"return_amount_$key\"  size=\"28\" /></th>";

                $html .= "<th><textarea type=\"text\" class=\"form-control\" name=\"reason[]\" id=\"reason_$key\"  size=\"28\" ></textarea> </th>";
                $html .= "</tr>";
            endforeach;
            $html .= "<tr>";
            $html .= "<th colspan=\"2\"><select name=\"payment_type\" id=\"payment_type\" class=\"form-control\" onchange=\"productType('')\" >
                    <option value=\"Cash\" selected>Cash</option>
                    <option value=\"Check\">Check</option>
            </select> </th>";
            $html .= "<th><input type=\"text\" name=\"check_number\" id=\"check_number\" class=\"form-control\" placeholder=\"Check Number\" readonly=\"readonly\"  size=\"28\" ></th>";
            $html .= "</tr>";
        endif;
        $html .= "</tbody>
                    </table>";
        echo json_encode($html);
        //dd($html);
    }
    public function purchaseProductReturn(Request $request){
        //dd($request->all());
        $row_count = count($request->return_qty);
        $productPurchase = ProductPurchase::where('id',$request->product_purchase_id)->first();
       // dd($row_count);

        $total_return_amount = 0;
        $total_amount = 0;
        for ($i = 0; $i < $row_count; $i++) {
            if ($request->return_qty[$i] != null) {
                $total_return_amount += $request->return_amount[$i]*$request->return_qty[$i];
                $total_amount += $request->total_amount[$i]*$request->return_qty[$i];
            }
        }
        $product_purchase_return = new ProductPurchaseReturn();
        $product_purchase_return->invoice_no = 'return-'.$productPurchase->invoice_no;
        $product_purchase_return->purchase_invoice_no = $productPurchase->invoice_no;
        $product_purchase_return->product_purchase_id = $productPurchase->id;
        $product_purchase_return->user_id = Auth::id();
        $product_purchase_return->store_id = $productPurchase->store_id;
        $product_purchase_return->party_id = $productPurchase->party_id;
        $product_purchase_return->payment_type = $productPurchase->payment_type;
        $product_purchase_return->discount_type = $productPurchase->discount_type;
        $product_purchase_return->discount_amount = 0;
        $product_purchase_return->total_amount = $total_amount;
        $product_purchase_return->total_return_amount = $total_return_amount;
        $product_purchase_return->save();

        $insert_id = $product_purchase_return->id;
        if($insert_id) {
            for ($i = 0; $i < $row_count; $i++) {
                if ($request->return_qty[$i] != null) {
                    $product_purchase_detail_id = $request->product_purchase_detail_id[$i];
                    $productPurchaseDetail = ProductPurchaseDetail::where('id',$product_purchase_detail_id)->first();

                    $product_purchase_return_detail = new ProductPurchaseReturnDetail();
                    $product_purchase_return_detail->product_purchase_return_id = $insert_id;
                    $product_purchase_return_detail->product_purchase_detail_id = $productPurchaseDetail->id;
                    $product_purchase_return_detail->product_category_id = $productPurchaseDetail->product_category_id;
                    $product_purchase_return_detail->product_sub_category_id = $productPurchaseDetail->product_sub_category_id;
                    $product_purchase_return_detail->product_brand_id = $productPurchaseDetail->product_brand_id;
                    $product_purchase_return_detail->product_id = $productPurchaseDetail->product_id;
                    $product_purchase_return_detail->qty = $request->return_qty[$i];
                    $product_purchase_return_detail->price = $request->total_amount[$i];
                    $product_purchase_return_detail->return_price = $request->return_amount[$i];
                    $product_purchase_return_detail->reason = $request->reason[$i];
                    $product_purchase_return_detail->save();

                    $product_id = $productPurchaseDetail->product_id;


                    $check_previous_stock = Stock::where('product_id', $product_id)->where('store_id',$productPurchase->store_id)->latest()->pluck('current_stock')->first();
                    if (!empty($check_previous_stock)) {
                        $previous_stock = $check_previous_stock;
                    } else {
                        $previous_stock = 0;
                    }

                    // product stock
                    $stock = new Stock();
                    $stock->user_id = Auth::id();
                    $stock->ref_id = $insert_id;
                    $stock->store_id = $product_purchase_return->store_id;
                    $stock->product_id = $product_id;
                    $stock->stock_type = 'purchase return';
                    $stock->previous_stock = $previous_stock;
                    $stock->stock_in = $request->return_qty[$i];
                    $stock->stock_out = 0;
                    $stock->current_stock = $previous_stock - $request->return_qty[$i];
                    $stock->date = date('Y-m-d');
                    $stock->save();

                    // stock minus log
                    if($stock->current_stock < 0){
                        $stock_minus_log = new StockMinusLog();
                        $stock_minus_log->user_id=Auth::user()->id;
                        $stock_minus_log->action_module='Product Purchase Return';
                        $stock_minus_log->action_done='Store';
                        $stock_minus_log->action_remarks='Product Purchase Return ID: '.$insert_id;
                        $stock_minus_log->action_date=date('Y-m-d');
                        $stock_minus_log->save();
                    }

//                    $current_stock_update = Stock::where('product_id',$product_id)->first();
//                    $exists_current_stock = $current_stock_update->current_stock;
//                    $update_current_stock = $exists_current_stock - $request->return_qty[$i];
//                    $current_stock_update->current_stock=$update_current_stock;
//                    $current_stock_update->save();

                }
            }

            // transaction
            $transaction = new Transaction();
            $transaction->invoice_no = 'return-' . $product_purchase_return->invoice_no;
            $transaction->user_id = Auth::id();
            $transaction->store_id = $product_purchase_return->store_id;
            $transaction->party_id = $product_purchase_return->party_id;
            $transaction->ref_id = $insert_id;
            $transaction->transaction_type = 'purchase return';
            $transaction->payment_type = $request->payment_type;
            $transaction->date = date('Y-m-d');
            $transaction->amount = $total_return_amount;
            $transaction->save();
        }

        Toastr::success('Product Purchase Return Created Successfully', 'Success');
        return redirect()->route('productPurchaseReturns.index');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $productPurchaseReturn = ProductPurchaseReturn::find($id);
        //dd($productPurchaseReturn);
        $productPurchaseReturnDetails = ProductPurchaseReturnDetail::where('product_purchase_return_id',$id)->get();
        $transaction = Transaction::where('ref_id',$id)->first();

        return view('backend.productPurchaseReturn.show', compact('productPurchaseReturn','productPurchaseReturnDetails','transaction'));
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
