<?php

namespace App\Http\Controllers;

use App\ChartOfAccount;
use App\Ledger;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LedgerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ledger-list|ledger-create|ledger-edit|ledger-delete', ['only' => ['index','show','voucher_invoice']]);
        $this->middleware('permission:ledger-create', ['only' => ['create','store']]);
        $this->middleware('permission:ledger-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:ledger-delete', ['only' => ['destroy']]);
        $this->middleware('permission:ledger-form', ['only' => ['general_ledger_form']]);
        $this->middleware('permission:cashbook-form', ['only' => ['cashBook_form']]);
        $this->middleware('permission:bankbook-form', ['only' => ['bankBook_form']]);
        $this->middleware('permission:recipt-form', ['only' => ['receiptPayment_form']]);
    }

    public function index()
    {
        $ledgers = Ledger::latest()->get();
        return view('backend.ledger.index',compact('ledgers'));
    }


    public function create()
    {
        $chartOfAccounts = ChartOfAccount::all();
        return view('backend.ledger.create',compact('chartOfAccounts'));
    }


    public function store(Request $request)
    {
        //dd($request->all());

        $row_count = count($request->chart_of_account_id);
        // check duplicate name
        for($i = 0; $i < $row_count; $i++) {
            $chart_of_account_id = $request->chart_of_account_id[$i];
            $name = $request->name[$i];

            $check_ledger = Ledger::where('chart_of_account_id',$chart_of_account_id)
                ->where('name',$name)
                ->first();
            if(!empty($check_ledger)){
                Toastr::warning('Ledger Already Exists, Please Try Another Name.', 'Warning');
                return redirect()->route('Ledger.index');
            }
        }
        // check duplicate name
        //dd($row_count);
        for($i = 0; $i < $row_count; $i++) {

           // $account_id = $request->chart_of_account_id;
            //$accounts = ChartOfAccount::where('id',$account_id)->first();
            $ledgers = new Ledger();
            $ledgers->chart_of_account_id = $request->chart_of_account_id[$i];
            $ledgers->name = $request->name[$i];
      //dd($ledgers->chart_of_account_id);
            $ledgers->save();
        }
        Toastr::success('Ledger Created Successfully', 'Success');
        return redirect()->route('Ledger.index');

    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $chartOfAccounts = ChartOfAccount::all();
        $ledgers = Ledger::find($id);
       //dd($chartOfAccounts);
        return view('backend.ledger.edit',compact('chartOfAccounts','ledgers'));
    }


    public function update(Request $request, $id)
    {
        $ledgers = Ledger::find($id);
        $ledgers->chart_of_account_id = $request->chart_of_account_id;
        $ledgers->name = $request->name;;
        //dd($ledgers->chart_of_account_id);
        $ledgers->save();
        Toastr::success('Ledger Updated Successfully', 'Success');
        return redirect()->route('Ledger.index');
    }


    public function destroy($id)
    {
        $ledgers = Ledger::find($id);
        $ledgers->delete();
        Toastr::success('Ledger Deleted Successfully', 'Success');
        return redirect()->route('Ledger.index');
    }

    public function general_ledger_form()
    {

        $chartOfAccounts = ChartOfAccount::all();
        $ledgers = Ledger::all();
        $chartOfAccountGroup2s = DB::table('chart_of_accounts')->select('group_2')->groupBy('group_2')->get();
        //$chartOfAccountGroup3s = DB::table('chart_of_accounts')->select('group_3')->groupBy('group_3')->get();

        return view('backend.new-account.general_ledger_form', compact('chartOfAccounts','ledgers','chartOfAccountGroup2s'));
    }

    public function view_general_ledger(Request $request)
    {
        $general_ledger = $request->ledger_id;
        $group_2 = $request->group_2;
        $group_3 = $request->group_3;
       //dd($group_3);
        $date_from = $request->date_from;
        $date_to = $request->date_to;

//dd($gl_pre_valance_data);
        //dd($request->all());
        if((!empty($general_ledger)) && (!empty($date_from)) && (!empty($date_to)) && (empty($group_2)) && (empty($group_3)))
        {
            $gl_pre_valance_data = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->select('ledger_id', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('posting_date', '<',$date_from)
                ->where('ledger_id',$general_ledger)
                ->groupBy('ledger_id')
                ->first();
        }
        elseif((!empty($group_3)) && (!empty($date_from)) && (!empty($date_to)) ){
            $gl_pre_valance_data = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('posting_date', '<',$date_from)
                ->where('group_3',$group_3)
                ->groupBy('group_3')
                ->first();
        }
        elseif((!empty($group_2)) && (!empty($date_from)) && (!empty($date_to)) ){
            $gl_pre_valance_data = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->select('group_2', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('posting_date', '<',$date_from)
                ->where('group_2',$group_2)
                ->groupBy('group_2')
                ->first();
        }
        else{
            $gl_pre_valance_data = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->select('ledger_id', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('posting_date', '<',$date_from)
                ->groupBy('ledger_id')
                ->first();
        }
        //dd($gl_pre_valance_data);

        $PreBalance=0;
        $preDebCre = 'De/Cr';
        if(!empty($gl_pre_valance_data))
        {
            //echo 'ok';exit;
            $debit = $gl_pre_valance_data->debit;
            $credit = $gl_pre_valance_data->credit;
            if($debit > $credit)
            {
                $PreBalance = $debit - $credit;
                $preDebCre = 'De';
            }else{
                $PreBalance = $credit - $debit;
                $preDebCre = 'Cr';
            }
        }

        if( (empty($group_2)) && (empty($group_3) ))
        {
            //echo 'okk';exit;
            $general_ledger_infos = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->where('ledger_id',$general_ledger)
                ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
                ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
                ->get();
        } elseif ((!empty($group_2)) &&  (empty($group_3)) ){
            $general_ledger_infos = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->where('group_2',$group_2)
                ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
                ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
                ->get();
        }
        elseif ( (!empty($group_3)) ){
            $general_ledger_infos = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                // ->where('postings.account_no',$general_ledger)
                ->where('group_3',$group_3)
                ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
                ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
                ->get();
        }
        else
        {
            //echo 'noo';exit;
            $general_ledger_infos = DB::table('posting_form_details')
                //->join('accounts', 'postings.id', '=', 'accounts.user_id')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
                //->select('postings.voucher_type_id','postings.voucher_no', 'postings.date', 'postings.account_no', 'postings.transaction_description', 'postings.debit', 'postings.credit', 'accounts.HeadName', 'accounts.PHeadName', 'accounts.HeadType')
                ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
                ->get();
        }

        //dd($general_ledger_infos);

        return view('backend.new-account.general_ledger_view', compact('general_ledger_infos','PreBalance', 'preDebCre', 'general_ledger', 'date_from', 'date_to','group_2','group_3'));
    }


    public function general_ledger_print($date_from,$date_to)
    {
        //dd($transaction_head);
        //echo ($transaction_head->account_no);
        //exit;
        if( (!empty($transaction_head)) && (!empty($date_from)) && (!empty($date_to)) )
        {
            $gl_pre_valance_data = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->select('ledger_id', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('posting_date', '<',$date_from)
                ->where('ledger_id',$transaction_head)
                ->groupBy('ledger_id')
                ->first();
        }else{
            $gl_pre_valance_data = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->select('ledger_id', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('posting_date', '<',$date_from)
                ->groupBy('ledger_id')
                ->first();
        }

        $PreBalance=0;
        $preDebCre = 'De/Cr';
        if(!empty($gl_prevalance_data))
        {
            //echo 'ok';exit;
            $debit = $gl_prevalance_data->debit;
            $credit = $gl_prevalance_data->credit;
            if($debit > $credit)
            {
                $PreBalance = $debit - $credit;
                $preDebCre = 'De';
            }else{
                $PreBalance = $credit - $debit;
                $preDebCre = 'Cr';
            }
        }


        if( (!empty($transaction_head)) && (!empty($date_from)) && (!empty($date_to)) )
        {
            //echo 'okk';exit;
            $general_ledger_infos = DB::table('posting_form_details')
                //->join('accounts', 'postings.id', '=', 'accounts.user_id')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                // ->where('postings.account_no',$general_ledger)
                ->where('ledger_id',$transaction_head)
                ->whereBetween('posting_forms.posting_date', [$date_from, $date_to])
                ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
                ->get();
        }else{
            //echo 'noo';exit;
            $general_ledger_infos = DB::table('posting_form_details')
                //->join('accounts', 'postings.id', '=', 'accounts.user_id')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->whereBetween('posting_forms.posting_date', [$date_from, $date_to])
                //->select('postings.voucher_type_id','postings.voucher_no', 'postings.date', 'postings.account_no', 'postings.transaction_description', 'postings.debit', 'postings.credit', 'accounts.HeadName', 'accounts.PHeadName', 'accounts.HeadType')
                ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
                ->get();
        }

        //dd($general_ledger_infos);

        return view('backend.new-account.general_ledger_print', compact('general_ledger_infos','PreBalance', 'preDebCre', 'transaction_head', 'date_from', 'date_to'));
    }

    public function cashBook_form()
    {
        $cashbooks= ChartOfAccount::where('id',1)->get();
        $ledgers = Ledger::all();
        return view('backend.new-account.cashbook_form',compact('cashbooks','ledgers'));
    }

    public function view_cashBook(Request $request)
    {
        $general_ledger = $request->ledger_id;
        $group_2 = $request->group_2;
        $group_3 = $request->group_3;
        //dd($group_3);
        $date_from = $request->date_from;
        $date_to = $request->date_to;

//dd($gl_pre_valance_data);
        //dd($request->all());
        if((!empty($general_ledger)) && (!empty($date_from)) && (!empty($date_to)) && (empty($group_2)) && (empty($group_3)))
        {
            $gl_pre_valance_data = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->select('ledger_id', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('posting_date', '<',$date_from)
                ->where('ledger_id',$general_ledger)
                ->groupBy('ledger_id')
                ->first();
        }
        elseif((!empty($group_3)) && (!empty($date_from)) && (!empty($date_to)) ){
            $gl_pre_valance_data = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('posting_date', '<',$date_from)
                ->where('group_3',$group_3)
                ->groupBy('group_3')
                ->first();
        }
        elseif((!empty($group_2)) && (!empty($date_from)) && (!empty($date_to)) ){
            $gl_pre_valance_data = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->select('group_2', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('posting_date', '<',$date_from)
                ->where('group_2',$group_2)
                ->groupBy('group_2')
                ->first();
        }
        else{
            $gl_pre_valance_data = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->select('ledger_id', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('posting_date', '<',$date_from)
                ->groupBy('ledger_id')
                ->first();
        }
        //dd($gl_pre_valance_data);

        $PreBalance=0;
        $preDebCre = 'De/Cr';
        if(!empty($gl_pre_valance_data))
        {
            //echo 'ok';exit;
            $debit = $gl_pre_valance_data->debit;
            $credit = $gl_pre_valance_data->credit;
            if($debit > $credit)
            {
                $PreBalance = $debit - $credit;
                $preDebCre = 'De';
            }else{
                $PreBalance = $credit - $debit;
                $preDebCre = 'Cr';
            }
        }

        if( (empty($group_2)) && (empty($group_3) ))
        {
            //echo 'okk';exit;
            $general_ledger_infos = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->where('ledger_id',$general_ledger)
                ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
                ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
                ->get();
        } elseif ((!empty($group_2)) &&  (empty($group_3)) ){
            $general_ledger_infos = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->where('group_2',$group_2)
                ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
                ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
                ->get();
        }
        elseif ( (!empty($group_3)) ){
            $general_ledger_infos = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                // ->where('postings.account_no',$general_ledger)
                ->where('group_3',$group_3)
                ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
                ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
                ->get();
        }
        else
        {
            //echo 'noo';exit;
            $general_ledger_infos = DB::table('posting_form_details')
                //->join('accounts', 'postings.id', '=', 'accounts.user_id')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
                //->select('postings.voucher_type_id','postings.voucher_no', 'postings.date', 'postings.account_no', 'postings.transaction_description', 'postings.debit', 'postings.credit', 'accounts.HeadName', 'accounts.PHeadName', 'accounts.HeadType')
                ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
                ->get();
        }

        //dd($general_ledger_infos);

        return view('backend.new-account.cashbook_view', compact('general_ledger_infos','PreBalance', 'preDebCre', 'general_ledger', 'date_from', 'date_to','group_2','group_3'));
    }
    public function bankBook_form()
    {
        $bankbooks= ChartOfAccount::where('id',2)->get();
        $ledgers = Ledger::all();
        return view('backend.new-account.bankbook_form',compact('bankbooks','ledgers'));
    }
    public function view_bankBook(Request $request)
    {
        $general_ledger = $request->ledger_id;
        $group_2 = $request->group_2;
        $group_3 = $request->group_3;
        //dd($general_ledger);
        $date_from = $request->date_from;
        $date_to = $request->date_to;

//dd($gl_pre_valance_data);
        //dd($request->all());
        if((!empty($general_ledger)) && (!empty($date_from)) && (!empty($date_to)) && (empty($group_2)) && (empty($group_3)))
        {
            $gl_pre_valance_data = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->select('ledger_name','ledger_id', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('posting_date', '<',$date_from)
                ->where('ledger_id',$general_ledger)
                ->groupBy('ledger_id')
                ->groupBy('ledger_name')
                ->first();
        }
        elseif((!empty($group_3)) && (!empty($date_from)) && (!empty($date_to)) ){
            $gl_pre_valance_data = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->select('ledger_name','group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('posting_date', '<',$date_from)
                ->where('group_3',$group_3)
                ->groupBy('group_3')
                ->groupBy('ledger_name')
                ->first();
        }
        elseif((!empty($group_2)) && (!empty($date_from)) && (!empty($date_to)) ){
            $gl_pre_valance_data = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->select('ledger_name','group_2', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('posting_date', '<',$date_from)
                ->where('group_2',$group_2)
                ->groupBy('group_2')
                ->groupBy('ledger_name')
                ->first();
        }
        else{
            $gl_pre_valance_data = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->select('ledger_name','ledger_id', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('posting_date', '<',$date_from)
                ->groupBy('ledger_id')
                ->groupBy('ledger_name')
                ->first();
        }
        //dd($gl_pre_valance_data);

        $PreBalance=0;
        $preDebCre = 'De/Cr';
        if(!empty($gl_pre_valance_data))
        {
            //echo 'ok';exit;
            $debit = $gl_pre_valance_data->debit;
            $credit = $gl_pre_valance_data->credit;
            if($debit > $credit)
            {
                $PreBalance = $debit - $credit;
                $preDebCre = 'De';
            }else{
                $PreBalance = $credit - $debit;
                $preDebCre = 'Cr';
            }
        }

        if( (empty($group_2)) && (empty($group_3) ))
        {
            //echo 'okk';exit;
            $general_ledger_infos = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->where('ledger_id',$general_ledger)
                ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
                ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
                ->get();
        } elseif ((!empty($group_2)) &&  (empty($group_3)) ){
            $general_ledger_infos = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->where('group_2',$group_2)
                ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
                ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
                ->get();
        }
        elseif ( (!empty($group_3)) ){
            $general_ledger_infos = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                // ->where('postings.account_no',$general_ledger)
                ->where('group_3',$group_3)
                ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
                ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
                ->get();
        }
        else
        {
            //echo 'noo';exit;
            $general_ledger_infos = DB::table('posting_form_details')
                //->join('accounts', 'postings.id', '=', 'accounts.user_id')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
                //->select('postings.voucher_type_id','postings.voucher_no', 'postings.date', 'postings.account_no', 'postings.transaction_description', 'postings.debit', 'postings.credit', 'accounts.HeadName', 'accounts.PHeadName', 'accounts.HeadType')
                ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
                ->get();
        }

        //dd($general_ledger_infos);

        return view('backend.new-account.bankbook_view', compact('general_ledger_infos','PreBalance', 'preDebCre', 'general_ledger', 'date_from', 'date_to','group_2','group_3','gl_pre_valance_data'));
    }
    public function receiptPayment_form()
    {
        $bankbooks= ChartOfAccount::where('id',1)->get();
        $ledgers = Ledger::where('id',10)->get();
       // dd($ledgers);
        return view('backend.new-account.receipt_form',compact('bankbooks','ledgers'));
    }
    public function view_receiptPayment(Request $request)
    {
        $general_ledger = $request->ledger_id;
        $group_2 = $request->group_2;
        $group_3 = $request->group_3;
        //dd($group_3);
        $date_from = $request->date_from;
        $date_to = $request->date_to;

//dd($gl_pre_valance_data);
        //dd($request->all());
        if((!empty($general_ledger)) && (!empty($date_from)) && (!empty($date_to)) && (empty($group_2)) && (empty($group_3)))
        {
            $gl_pre_valance_data = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->select('ledger_id', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('posting_date', '<',$date_from)
                ->where('ledger_id',$general_ledger)
                ->groupBy('ledger_id')
                ->first();
        }
        elseif((!empty($group_3)) && (!empty($date_from)) && (!empty($date_to)) ){
            $gl_pre_valance_data = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('posting_date', '<',$date_from)
                ->where('group_3',$group_3)
                ->groupBy('group_3')
                ->first();
        }
        elseif((!empty($group_2)) && (!empty($date_from)) && (!empty($date_to)) ){
            $gl_pre_valance_data = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->select('group_2', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('posting_date', '<',$date_from)
                ->where('group_2',$group_2)
                ->groupBy('group_2')
                ->first();
        }
        else{
            $gl_pre_valance_data = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->select('ledger_id', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('posting_date', '<',$date_from)
                ->groupBy('ledger_id')
                ->first();
        }
        //dd($gl_pre_valance_data);

        $PreBalance=0;
        $preDebCre = 'De/Cr';
        if(!empty($gl_pre_valance_data))
        {
            //echo 'ok';exit;
            $debit = $gl_pre_valance_data->debit;
            $credit = $gl_pre_valance_data->credit;
            if($debit > $credit)
            {
                $PreBalance = $debit - $credit;
                $preDebCre = 'De';
            }else{
                $PreBalance = $credit - $debit;
                $preDebCre = 'Cr';
            }
        }

        if( (empty($group_2)) && (empty($group_3) ))
        {
            //echo 'okk';exit;
            $general_ledger_infos = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->where('ledger_id',$general_ledger)
                ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
                ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
                ->get();
        } elseif ((!empty($group_2)) &&  (empty($group_3)) ){
            $general_ledger_infos = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->where('group_2',$group_2)
                ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
                ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
                ->get();
        }
        elseif ( (!empty($group_3)) ){
            $general_ledger_infos = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                // ->where('postings.account_no',$general_ledger)
                ->where('group_3',$group_3)
                ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
                ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
                ->get();
        }
        else
        {
            //echo 'noo';exit;
            $general_ledger_infos = DB::table('posting_form_details')
                //->join('accounts', 'postings.id', '=', 'accounts.user_id')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
                //->select('postings.voucher_type_id','postings.voucher_no', 'postings.date', 'postings.account_no', 'postings.transaction_description', 'postings.debit', 'postings.credit', 'accounts.HeadName', 'accounts.PHeadName', 'accounts.HeadType')
                ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
                ->get();
        }

        //dd($general_ledger_infos);

        return view('backend.new-account.receipt_view', compact('general_ledger_infos','PreBalance', 'preDebCre', 'general_ledger', 'date_from', 'date_to','group_2','group_3'));
    }

}
