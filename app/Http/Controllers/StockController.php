<?php

namespace App\Http\Controllers;

use App\Exports\StockExport;
use App\Exports\TransactionExport;
use App\Product;
use App\Stock;
use App\Store;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class StockController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:stock-list', ['only' => ['stockList']]);
        $this->middleware('permission:stock-summary-list', ['only' => ['stockSummaryList']]);
        $this->middleware('permission:stock-low-list', ['only' => ['stockLowList']]);
    }


    function stock_sync(){
        $stock_data = Stock::whereIn('id', function($query) {
            $query->from('stocks')->groupBy('store_id')->groupBy('product_id')->selectRaw('MIN(id)');
        })->get();

        $row_count = count($stock_data);
        if($row_count > 0){
            foreach ($stock_data as $key => $data){
                $product_id = $data->product_id;
                $store_id = $data->store_id;
                product_store_stock_sync($product_id,$store_id);
            }
            Toastr::success('Stock Synchronize Successfully Updated!', 'Success');
        }
        return redirect()->back();
    }

    public function allStockList(Request $request){
        //dd($request->all());

//        $stores = Store::latest()->get();
//        $start_date = $request->start_date ? $request->start_date : '';
//        $end_date = $request->end_date ? $request->end_date : '';
//        $product_id = Input::get('product_id') ? Input::get('product_id') : '';
//        $products =Product::latest()->get();
//

//        return view('backend.stock.all-stock', compact('stores','start_date','end_date','products','product_id'));

        $stores = Store::all();
        //dd($stores);
        return view('backend.stock.all-stock', compact('stores'));
    }


    public function stockDetails(Request $request,$store_id){

        $auth_user_id = Auth::user()->id;
        $auth_user = Auth::user()->roles[0]->name;
        $start_date = $request->start_date ? $request->start_date : '';
        $end_date = $request->end_date ? $request->end_date : '';


        if($start_date && $end_date) {
            if ($auth_user == "Admin") {
                $stocks = Stock::where('date', '>=', $start_date)->where('date', '<=', $end_date)->where('store_id',$store_id)->latest('id','desc')->get();
            } else {
                $stocks = Stock::where('date', '>=', $start_date)->where('date', '<=', $end_date)->where('store_id',$store_id)->where('user_id', $auth_user_id)->latest('id','desc')->get();
            }
        }else{
            if ($auth_user == "Admin") {
                $stocks = Stock::where('store_id',$store_id)->latest('id','desc')->get();
            } else {
                $stocks = Stock::where('store_id',$store_id)->where('user_id', $auth_user_id)->latest('id','desc')->get();
            }
        }
//dd($stocks);

        //$stocks = Stock::where('store_id',$store_id)->latest()->get();
        $stores = Store::all();
        return view('backend.stock.details', compact('stocks','start_date','end_date','stores','store_id'));
    }

    public function stockList(){
        $stores = Store::all();
        return view('backend.stock.sale-list', compact('stores'));
    }
    public function stockPurchaseList(){
        $stores = Store::all();
        return view('backend.stock.purchase-list', compact('stores'));
    }
    public function export()
    {
        //return Excel::download(new UsersExport, 'users.xlsx');
        return Excel::download(new StockExport, 'stock.xlsx');
    }

    public function stockPurchaseDetails($store_id)
    {
        $stocks = Stock::where('store_id',$store_id)->where('stock_type','=','purchase')->latest()->get();
        $stores = Store::latest()->get();
        return view('backend.stock.purchase-details', compact('stores','stocks'));
    }
    public function stockSaleDetails($store_id){
        $stocks = Stock::where('store_id',$store_id)->where('stock_type','=','sale')->latest()->get();
        $stores = Store::all();
        return view('backend.stock.sale-details', compact('stocks','stores'));
    }

    public function stockSummaryList(){
        $stores = Store::all();
        return view('backend.stock.stock_summary', compact('stores'));
    }
    public function stockSummary(Request $request,$store_id){
        $start_date = $request->start_date ? $request->start_date : '';
        $end_date = $request->end_date ? $request->end_date : '';
        $stock_id = DB::table('stocks')->where('store_id',$store_id)->groupBy('product_id')->selectRaw('MAX(id)');

        if($start_date && $end_date){
            $stocks = Stock::where('store_id',$store_id)->whereIn('id',$stock_id)->where('date', '>=', $start_date)->where('date', '<=', $end_date)->latest('id')->get();
        }else{
            $stocks = Stock::where('store_id',$store_id)->whereIn('id',$stock_id)->latest('id')->get();
        }

        return view('backend.stock.stock_summary_details', compact('stocks','store_id','start_date','end_date'));
    }
    public function stockSummaryInvoice($id){
        $store = Store::find($id);
        $stock_id = DB::table('stocks')->where('store_id',$id)->groupBy('product_id')->selectRaw('MAX(id)');
        $stocks = Stock::where('store_id',$id)->whereIn('id',$stock_id)->latest('id')->get();
        return view('backend.stock.stock_summary_invoice',compact('store','stocks'));
    }
    public function stockLowList(){
        $stores = Store::all();
        return view('backend.stock.stock_low', compact('stores'));
    }
    public function stockLowListDEtails($store_id){
        $stocks = \App\Stock::where('store_id',$store_id)
            ->whereIn('id', function($query) {
                $query->from('stocks')->where('current_stock','<', 10)->groupBy('product_id')->selectRaw('MAX(id)');
            })->latest('id')->get();
        $stores = Store::all();
        return view('backend.stock.stock_low_details', compact('stores','stocks'));
    }

    public function stockDateWise(Request $request,$store_id){
        //dd($request->all());
        $start_date = $request->start_date ? $request->start_date : '';
        $end_date = $request->end_date ? $request->end_date : '';
        $stores = Store::all();
        return view('backend.stock.all-stock', compact('stores','start_date','end_date'));
    }
}
