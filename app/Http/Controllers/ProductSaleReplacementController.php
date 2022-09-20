<?php

namespace App\Http\Controllers;

use App\Party;
use App\Product;
use App\ProductBrand;
use App\ProductCategory;
use App\ProductSale;
use App\ProductSaleDetail;
use App\ProductSaleReplacement;
use App\ProductSaleReplacementDetail;
use App\ProductSubCategory;
use App\ProductUnit;
use App\Stock;
use App\StockMinusLog;
use App\Store;
use App\Transaction;
use Brian2694\Toastr\Facades\Toastr;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductSaleReplacementController extends Controller
{

    public function index()
    {
        $auth_user_id = Auth::user()->id;
        $auth_user = Auth::user()->roles[0]->name;
        if($auth_user == "Admin"){
            $productSaleReplacements = ProductSaleReplacement::latest()->get();
        }else{
            $productSaleReplacements = ProductSaleReplacement::where('user_id',$auth_user_id)->latest()->get();
        }
        return view('backend.productSaleReplacement.index',compact('productSaleReplacements'));
    }


    public function create()
    {
       // dd('kk');
        $auth_user_id = Auth::user()->id;
        $auth_user = Auth::user()->roles[0]->name;
        $parties = Party::where('type','customer')->get() ;
        if($auth_user == "Admin"){
            $stores = Store::all();
        }else{
            $stores = Store::where('user_id',$auth_user_id)->get();
        }
        $productSales = ProductSale::latest()->get();

        return view('backend.productSaleReplacement.create',compact('parties','stores','productSales'));
    }



    public function getSaleProduct($sale_id){
        //$products = ProductSaleDetail::where('product_sale_id',$sale_id)->get();
        $products = DB::table('product_sale_details')
            ->join('products','product_sale_details.product_id','=','products.id')
            ->where('product_sale_details.product_sale_id',$sale_id)
            ->select('product_sale_details.product_id','product_sale_details.qty','products.name')
            ->get();

        $html = "<table class=\"table table-striped tabel-penjualan\">
                        <thead>
                            <tr>
                                <th width=\"30\">No</th>
                                <th>Product Name</th>
                                <th align=\"right\"> Quantity</th>
                                <th>Replace Quantity</th>
                                <th>Reason</th>
                            </tr>
                        </thead>
                        <tbody>";
                        if(count($products) > 0):
                            foreach($products as $key => $item):
                                $key += 1;
                                $html .= "<tr>";
                                $html .= "<th width=\"30\">1</th>";
                                $html .= "<th><input type=\"hidden\" class=\"form-control\" name=\"product_id[]\" id=\"product_id_$key\" value=\"$item->product_id\" size=\"28\" />$item->name</th>";
                                $html .= "<th><input type=\"text\" class=\"form-control\" name=\"qty[]\" id=\"qty_$key\" value=\"$item->qty\" size=\"28\" readonly /></th>";
                                $html .= "<th><input type=\"text\" class=\"form-control\" name=\"replace_qty[]\" id=\"replace_qty_$key\" onkeyup=\"replace_qty($key,this);\" size=\"28\" /></th>";
                                $html .= "<th><textarea type=\"text\" class=\"form-control\" name=\"reason[]\" id=\"reason_$key\"  size=\"28\" ></textarea> </th>";
                                $html .= "</tr>";
                            endforeach;
                            //$html .= "<tr><th align=\"right\" colspan=\"7\"><input type=\"button\" class=\"btn btn-danger\" name=\"remove\" id=\"remove\" size=\"28\" value=\"Clear Item\" onClick=\"deleteAllCart()\" /></th></tr>";
                        endif;
                        $html .= "</tbody>
                    </table>";
        echo json_encode($html);
    }


    public function store(Request $request)
    {
        //dd($request->all());
        $row_count = count($request->replace_qty);

        $productSale = ProductSale::where('id',$request->product_sale_id)->first();
        // product replacement
        $purchase_sale_replacement = new ProductSaleReplacement();
        $purchase_sale_replacement->invoice_no = 'replace-'.$productSale->invoice_no;
        $purchase_sale_replacement->sale_invoice_no = $productSale->invoice_no;
        $purchase_sale_replacement->product_sale_id = $request->product_sale_id;
        $purchase_sale_replacement->user_id = Auth::user()->id;
        $purchase_sale_replacement->store_id = $productSale->store_id;
        $purchase_sale_replacement->party_id = $productSale->party_id;
        $purchase_sale_replacement->date = date('Y-m-d');
        $purchase_sale_replacement->save();
        $insert_id = $purchase_sale_replacement->id;

        if($insert_id){
            for($i=0; $i<$row_count;$i++)
            {
                if($request->replace_qty[$i] != null){
                    // product replacement detail
                    $purchase_sale_replacement_detail = new ProductSaleReplacementDetail();
                    $purchase_sale_replacement_detail->p_s_replacement_id = $insert_id;
                    $purchase_sale_replacement_detail->product_id = $request->product_id[$i];
                    $purchase_sale_replacement_detail->replace_qty = $request->replace_qty[$i];
                    $purchase_sale_replacement_detail->price = $request->price[$i];
                    $purchase_sale_replacement_detail->reason = $request->reason[$i];
                    $purchase_sale_replacement_detail->save();

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
                    $stock->store_id = $productSale->store_id;
                    $stock->date = date('Y-m-d');
                    $stock->product_id = $request->product_id[$i];
                    $stock->stock_type = 'replace';
                    $stock->previous_stock = $previous_stock;
                    $stock->stock_in = 0;
                    $stock->stock_out = $request->replace_qty[$i];
                    $stock->current_stock = $previous_stock - $request->replace_qty[$i];
                    $stock->save();

                    // stock minus log
                    if($stock->current_stock < 0){
                        $stock_minus_log = new StockMinusLog();
                        $stock_minus_log->user_id=Auth::user()->id;
                        $stock_minus_log->action_module='Product Sale Replacement';
                        $stock_minus_log->action_done='Store';
                        $stock_minus_log->action_remarks='Product Sale Replacement ID: '.$insert_id;
                        $stock_minus_log->action_date=date('Y-m-d');
                        $stock_minus_log->save();
                    }
                }
            }
        }

        Toastr::success('Product Sale Created Successfully', 'Success');
        return redirect()->route('productSaleReplacement.index');
    }


    public function show($id)
    {
        $productSaleReplacement = ProductSaleReplacement::find($id);
        $productSaleReplacementDetails = ProductSaleReplacementDetail::where('p_s_replacement_id',$id)->get();

        return view('backend.productSaleReplacement.show', compact('productSaleReplacement','productSaleReplacementDetails'));
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
        $parties = Party::where('type','customer')->get() ;
        $products = Product::all();
        $productBrands = ProductBrand::all();
        $productSaleReplacement = ProductSaleReplacement::find($id);
        $productSaleReplacementDetails = ProductSaleReplacementDetail::where('p_s_replacement_id',$id)->get();

        return view('backend.productSaleReplacement.edit',compact('parties','stores','products','productSaleReplacement','productSaleReplacementDetails','productBrands'));
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());

        $row_count = count($request->replace_qty);

        for($i=0; $i<$row_count;$i++) {
            if ($request->replace_qty[$i] != null) {
                // product replacement detail
                $product_Sale_replacement_detail_id = $request->product_Sale_replacement_detail_id[$i];
                $purchase_sale_replacement_detail = ProductSaleReplacementDetail::find($product_Sale_replacement_detail_id);
                $purchase_sale_replacement_detail->replace_qty = $request->replace_qty[$i];
                $purchase_sale_replacement_detail->reason = $request->reason[$i];
                $purchase_sale_replacement_detail->save();


                $product_id = $request->product_id[$i];

                // product stock
                $stock_row = Stock::where('ref_id',$id)->where('stock_type','replace')->where('product_id',$product_id)->first();

                if($stock_row->stock_out != $request->replace_qty[$i]) {

                    if ($request->replace_qty[$i] > $stock_row->stock_out) {
                        $add_or_minus_stock_out = $request->replace_qty[$i] - $stock_row->stock_out;
                        $update_stock_out = $stock_row->stock_out + $add_or_minus_stock_out;
                        $update_current_stock = $stock_row->current_stock - $add_or_minus_stock_out;
                    } else {
                        $add_or_minus_stock_out = $stock_row->stock_out - $request->replace_qty[$i];
                        $update_stock_out = $stock_row->stock_out - $add_or_minus_stock_out;
                        $update_current_stock = $stock_row->current_stock + $add_or_minus_stock_out;
                    }


                    $stock_row->user_id = Auth::user()->id;
                    $stock_row->stock_out = $update_stock_out;
                    $stock_row->current_stock = $update_current_stock;
                    $stock_row->update();

                    // stock minus log
                    if($stock_row->current_stock < 0){
                        $stock_minus_log = new StockMinusLog();
                        $stock_minus_log->user_id=Auth::user()->id;
                        $stock_minus_log->action_module='Product Sale Replacement';
                        $stock_minus_log->action_done='Update';
                        $stock_minus_log->action_remarks='Product Sale Replacement ID: '.$id;
                        $stock_minus_log->action_date=date('Y-m-d');
                        $stock_minus_log->save();
                    }
                }


            }
        }

        Toastr::success('Product Sale Updated Successfully', 'Success');
        return redirect()->route('productSaleReplacement.index');
    }


    public function destroy($id)
    {
        $productSaleReplacement = ProductSaleReplacement::find($id);
        $productSaleReplacement->delete();

        DB::table('product_sale_replacement_details')->where('p_s_replacement_id',$id)->delete();
        DB::table('stocks')->where('ref_id',$id)->where('stock_type','replace')->delete();
        //DB::table('transactions')->where('ref_id',$id)->delete();

        Toastr::success('Product Sale Replacement Deleted Successfully', 'Success');
        return redirect()->route('productSaleReplacement.index');
    }
}
