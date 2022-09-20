<?php

namespace App\Http\Controllers;

use App\Exports\DeliveryExport;
use App\Exports\LossProfitExport;
use App\Exports\LossProfitExportFilter;
use App\Exports\TransactionExport;
use App\Store;
use Illuminate\Http\Request;
use App\Transaction;
use App\ProductPurchaseDetail;
//use Illuminate\Support\Facades\DB;
use DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:product-list', ['only' => ['transactionList','lossProfit']]);
    }

    public function transactionStore(){
       // dd('ff');
        $stores = Store::all();
        //dd($stores);

        return view('backend.transaction.transaction_store', compact('stores'));
    }
    public function transactionList(Request $request,$store_id){
        $stores = Store::all();
        $auth_user_id = Auth::user()->id;
        $auth_user = Auth::user()->roles[0]->name;
        $start_date = $request->start_date ? $request->start_date : '';
        $end_date = $request->end_date ? $request->end_date : '';


        if($start_date && $end_date) {
            if ($auth_user == "Admin") {
                $transactions = Transaction::where('date', '>=', $start_date)->where('date', '<=', $end_date)->where('store_id',$store_id)->latest('id','desc')->get();
            } else {
                $transactions = Transaction::where('date', '>=', $start_date)->where('date', '<=', $end_date)->where('store_id',$store_id)->where('user_id', $auth_user_id)->latest('id','desc')->get();
            }
        }else{
            if ($auth_user == "Admin") {
                $transactions = Transaction::where('store_id',$store_id)->latest('id','desc')->get();
            } else {
                $transactions = Transaction::where('store_id',$store_id)->where('user_id', $auth_user_id)->latest('id','desc')->get();
            }
        }
        //$transactions = Transaction::where('store_id',$store_id)->latest()->get();
        return view('backend.transaction.index', compact('stores','store_id','transactions','start_date','end_date'));
    }

    public function lossProfitStore(Request $request){

        $stores = Store::all();
        return view('backend.transaction.transaction_loss_profit_store', compact('stores'));
    }
    public function lossProfitdup(Request $request){
        //dd($request->all());
        $store_id = $request->store_id ? $request->store_id : '' ;
        $start_date = $request->start_date ? $request->start_date : '';
        $end_date = $request->end_date ? $request->end_date : '';

        return view('backend.transaction.loss_profit_dup', compact('start_date','end_date','store_id'));
    }

    public function lossProfit(Request $request){
        //dd($request->all());
        $start_date = $request->start_date ? $request->start_date : '';
        $end_date = $request->end_date ? $request->end_date : '';
        if($start_date && $end_date) {
            $transactions = Transaction::where('date', '>=', $start_date)->where('date', '<=', $end_date)->latest('id','desc')->get();
        } else {
            $transactions = Transaction::where('date', '>=', $start_date)->where('date', '<=', $end_date)->latest('id','desc')->get();
        }
        $stores = Store::all();
        return view('backend.transaction.loss_profit', compact('stores','start_date','end_date','transactions'));
    }

    public function deliveryList(){
        $stores = Store::all();
        return view('backend.transaction.transaction_list', compact('stores'));
    }
    public function export()
    {
        //return Excel::download(new UsersExport, 'users.xlsx');
        return Excel::download(new TransactionExport, 'transaction.xlsx');
    }
    public function deliveryExport()
    {
        return Excel::download(new DeliveryExport, 'delivery.xlsx');
    }

    public function lossProfitExport()
    {
        return Excel::download(new LossProfitExport, 'loss_profit.xlsx');
    }

    public function lossProfitExportFilter(Request $request, $start_date, $end_date)
    {
        //dd('okk1');
        return Excel::download(new LossProfitExportFilter, 'loss_profit.xlsx');
    }
}
