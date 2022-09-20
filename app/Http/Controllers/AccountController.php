<?php

namespace App\Http\Controllers;

use App\Account;
use App\Posting;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:coa-print', ['only' => ['coa_print']]);
        $this->middleware('permission:cash-book-list', ['only' => ['cash_book_form']]);

        $this->middleware('permission:debit-voucher-list', ['only' => ['debit_voucher_form','view_debit_voucher']]);
        $this->middleware('permission:credit-voucher-list', ['only' => ['credit_voucher_form','view_credit_voucher']]);


    }

    public function index()
    {

        //echo 'okk';exit;

        $accounts = Account::where('IsActive',1)->get();
        //dd($accounts);
        return view('backend.account.tree',compact('accounts'));
    }

    public static function dfs($HeadName,$HeadCode,$oResult,$visit,$d)
    {
        if($d==0) echo "<li>$HeadName";
        else      echo "<li><a href='javascript:' onclick=\"loadData('".$HeadCode."')\">$HeadName</a>";
        $p=0;
        for($i=0;$i< count($oResult);$i++)
        {
            if (!$visit[$i])
            {
                if ($HeadName==$oResult[$i]->PHeadName)
                {
                    $visit[$i]=true;
                    if($p==0) echo "<ul>";
                    $p++;
                    //$this->dfs($oResult[$i]->HeadName,$oResult[$i]->HeadCode,$oResult,$visit,$d+1);
                    static::dfs($oResult[$i]->HeadName,$oResult[$i]->HeadCode,$oResult,$visit,$d+1);
                }
            }
        }
        if($p==0)
            echo "</li>";
        else
            echo "</ul>";
    }

    public function selectedform($id){
        //echo 'okk';
        //echo $id;

        $accounts = Account::where('HeadCode',$id)->first();
        //dd($result);

        $party_accounts = Account::where('HeadCode',10204)->orWhere('HeadCode','like','10203%')->orWhere('HeadCode','like','50202%')->Orderby('HeadName','asc')->get();

        //$baseurl = base_url().'/'.'accounts/accounts/insert_coa';
        $baseurl = URL('/insert_coa');
        $isactive = 'Checked';

        // One Way
        if ($accounts) {
            $html = "";
            $html .= "<form name=\"form\" id=\"form\" action=\"".$baseurl."\" method=\"post\" enctype=\"multipart/form-data\">
            <input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\" />
            <div id=\"newData\">
                <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">
                    <tr>
                        <td>Head Code</td>
                        <td><input type=\"text\" name=\"txtHeadCode\" id=\"txtHeadCode\" class=\"form_input\"  value=\"".$accounts->HeadCode."\" readonly=\"readonly\"/></td>
                    </tr>
                    <tr>
                        <td>Head Name</td>
                        <td><input type=\"text\" name=\"txtHeadName\" id=\"txtHeadName\" class=\"form_input\" value=\"".$accounts->HeadName."\"/>
                            <input type=\"hidden\" name=\"HeadName\" id=\"HeadName\" class=\"form_input\" value=\"".$accounts->HeadName."\"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Parent Head</td>
                        <td><input type=\"text\" name=\"txtPHead\" id=\"txtPHead\" class=\"form_input\" readonly=\"readonly\" value=\"".$accounts->PHeadName."\"/></td>
                    </tr>
                    <tr>
                        <td>Head Level</td>
                        <td><input type=\"text\" name=\"txtHeadLevel\" id=\"txtHeadLevel\" class=\"form_input\" readonly=\"readonly\" value=\"".$accounts->HeadLevel."\"/></td>
                    </tr>
                    <tr>
                        <td>Head Type</td>
                        <td><input type=\"text\" name=\"txtHeadType\" id=\"txtHeadType\" class=\"form_input\" readonly=\"readonly\" value=\"".$accounts->HeadType."\"/></td>
                    </tr>
                    <br/>";
            if($accounts->PHeadName=='Bank'):

                $html .= "<tr>
                        <td>Bank User</td>
                        <td>

                                <select name=\"bankUserAccount\" class=\"form - control\" style=\"width: 180px\">
			                        <option value=\"\">Select One</option>";

                if($party_accounts ):
                    foreach($party_accounts as $party_account):
                        $html .="<option value=\"$party_account->HeadCode\"";
                        if($party_account->HeadCode == $accounts->BankUserAccount){ $html .="selected";}
                        $html .=">$party_account->HeadName</option>";
                    endforeach;
                endif;
                $html .="</select>
                        </td>
                    </tr>";
            endif;


            $html .="<tr>
                        <td>&nbsp;</td>
                        <td><input type=\"checkbox\" name=\"IsTransaction\" value=\"1\" id=\"IsTransaction\" size=\"28\"  onchange=\"IsTransaction_change();\"";
            if($accounts->IsTransaction==1){ $html .="checked";}

            $html .="/><label for=\"IsTransaction\"> IsTransaction</label>
                                            <input type=\"checkbox\" value=\"1\" name=\"IsActive\" id=\"IsActive\"";
            if($accounts->IsActive==1){ $html .="checked";}
            $html .=" size=\"28\" checked=\"".$isactive."\" /><label for=\"IsActive\"> IsActive</label>
                                            <input type=\"checkbox\" value=\"1\" name=\"IsGL\" id=\"IsGL\" size=\"28\"";
            if($accounts->IsGL==1){ $html .="checked";}
            $html .=" onchange=\"IsGL_change();\"/><label for=\"IsGL\"> IsGL</label>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>";
            //$html .="<input type=\"button\" name=\"btnNew\" id=\"btnNew\" value=\"New\" onClick=\"newdata(".$accounts->HeadCode.")\" />
            $html .="<input type=\"button\" name=\"btnNew\" id=\"btnNew\" value=\"New\"";
            if($accounts->PHeadName=='Account Receivable' || $accounts->PHeadName=='Customer Receivable' || $accounts->PHeadName=='Current Liabilities' || $accounts->PHeadName=='Account Payable'){ $html .="disabled=\"disabled\"";}
            $html .=" onClick=\"newdata(".$accounts->HeadCode.")\" />
                                        <input type=\"submit\" name=\"btnSave\" id=\"btnSave\" value=\"Save\" disabled=\"disabled\"/>";
            //$html .=" <input type=\"submit\" name=\"btnUpdate\" id=\"btnUpdate\" value=\"Update\" />";
            $html .=" <input type=\"submit\" name=\"btnUpdate\" id=\"btnUpdate\"";
            if($accounts->PHeadName=='Account Receivable' || $accounts->PHeadName=='Customer Receivable' || $accounts->PHeadName=='Current Liabilities' || $accounts->PHeadName=='Account Payable'){ $html .="disabled=\"disabled\"";}
            $html .="    value=\"Update\" />";
            $html .=" </td>
                    </tr>
                </table>
            </div>
        </form>";
        }
        echo json_encode($html);

        // Two Way
        //return view('backend.account.account_form',compact('accounts','baseurl','isactive'));
    }

    public function newform($id){

        /*$newdata = $this->db->select('*')
            ->from('acc_coa')
            ->where('HeadCode',$id)
            ->get()
            ->row();*/
        $newdata = Account::where('HeadCode',$id)->first();
        //dd($newdata);


        /*$newidsinfo = $this->db->select('*,count(HeadCode) as hc')
            ->from('acc_coa')
            ->where('PHeadName',$newdata->HeadName)
            ->get()
            ->row();*/
        /*$newidsinfo = Account::where('PHeadName',$newdata->HeadName)->get();
        $wordCount = $newidsinfo->count();

        //$nid  = $newidsinfo->hc;
        $nid  = $wordCount;
        $n =$nid + 1;
        if ($n / 10 < 1)
            $HeadCode = $id . "0" . $n;
        else
            $HeadCode = $id . $n;*/

        $newidsinfo = Account::where('PHeadName',$newdata->HeadName)->orderby('HeadCode', 'desc')->first();

        $n = 1;
        if($newidsinfo)
        {
            $nid  = $newidsinfo->HeadCode;
            $HeadCode = $nid + 1;
        }else{
            $HeadCode = $id . "0" . $n;
        }


        $info['headcode'] =  $HeadCode;
        $info['rowdata'] =  $newdata;
        $info['headlabel'] =  $newdata->HeadLevel+1;
        echo json_encode($info);
    }

    public function insert_coa(Request $request){
        //echo 'okk';exit;
        //dd($request->all());
        /*if(!empty(Auth::User()->getRoleNames())){
            foreach(Auth::User()->getRoleNames() as $v){
                print_r($v);
            }
        }*/

        //dd(Auth::User()->id);

        /*$headcode =$request->post('txtHeadCode');
        $HeadName =$request->post('txtHeadName');
        $PHeadName =$request->post('txtPHead');
        $HeadLevel =$request->post('txtHeadLevel');
        $txtHeadType =$request->post('txtHeadType');
        $isact =$request->post('IsActive');
        $IsActive = (!empty($isact)?$isact:0);
        $trns =$request->post('IsTransaction');
        $IsTransaction = (!empty($trns)?$trns:0);
        $isgl=$request->post('IsGL');
        $IsGL = (!empty($isgl)?$isgl:0);
        $createby=Auth::User()->id;
        //$updateby=$this->session->userdata('id');
        $createdate=date('Y-m-d H:i:s');

        $postData = array(
            'HeadCode'       =>  $headcode,
            'HeadName'       =>  $HeadName,
            'PHeadName'      =>  $PHeadName,
            'HeadLevel'      =>  $HeadLevel,
            'IsActive'       =>  $IsActive,
            'IsTransaction'  =>  $IsTransaction,
            'IsGL'           =>  $IsGL,
            'HeadType'       => $txtHeadType,
            'IsBudget'       => 0,
            'CreateBy'       => $createby,
            'CreateDate'     => $createdate,
        );*/




        $isact =$request->post('IsActive');
        $IsActive = (!empty($isact)?$isact:0);
        $trns =$request->post('IsTransaction');
        $IsTransaction = (!empty($trns)?$trns:0);
        $isgl=$request->post('IsGL');
        $IsGL = (!empty($isgl)?$isgl:0);
        $createby=Auth::User()->id;
        $createdate=date('Y-m-d H:i:s');

        $account = new Account;
        $account->HeadCode = $request->post('txtHeadCode');
        $account->HeadName = $request->post('txtHeadName');
        $account->PHeadName = $request->post('txtPHead');
        $account->HeadLevel = $request->post('txtHeadLevel');
        $account->IsActive = $IsActive;
        $account->IsTransaction = $IsTransaction;
        $account->IsGL = $IsGL;
        $account->HeadType = $request->post('txtHeadType');
        $account->CreateBy = $createby;
        $account->UpdateBy = $createby;
        //$account->save();




        /*$upinfo = $this->db->select('*')
            ->from('acc_coa')
            ->where('HeadCode',$headcode)
            ->get()
            ->row();*/
        $upinfo = Account::where('HeadCode',$request->post('txtHeadCode'))->first();

        if(empty($upinfo)){
            //$this->db->insert('acc_coa',$postData);
            $account->save();
        }else{
            /*$hname =$request->post('HeadName');
            $updata = array(
                'PHeadName'      =>  $request->post('txtHeadName'),
            );
            $this->db->where('HeadCode',$headcode)
                ->update('acc_coa',$postData);
            $this->db->where('PHeadName',$hname)
                ->update('acc_coa',$updata);

            $account->update();*/



            //dd($request->all());

            $upinfo = Account::where('HeadName',$request->post('HeadName'))->first();
            //dd($upinfo);
            $upinfo->HeadName = $request->post('txtHeadName');
            $upinfo->IsGL = $request->post('IsGL') ? $request->post('IsGL') : 0;
            $upinfo->IsTransaction = $request->post('IsTransaction') ? $request->post('IsTransaction') : 0;
            $upinfo->bankUserAccount = $request->post('bankUserAccount') ? $request->post('bankUserAccount') : '';

            $upinfo->update();
        }
        //redirect($_SERVER['HTTP_REFERER']);
        return back()->withResponse('Accounts Inserted Successfully');
    }

    public function coa_print(){

        return  view('backend.account.coa_print');
    }
    public function cash_book_form(Request $request)
    {
       // dd($request->all());
        $PreBalance=0;
        $preDebCre = 'De/Cr';
        $cash_data_results = '';

        if ($request->isMethod('post')) {

            $cash_prevalance_data = DB::table('postings')
                ->select('account_no', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('date', '<',$request->date_from)
                ->where('account_no','10201')
                ->where('is_approved','approved')
                ->groupBy('account_no')
                ->first();


            if(!empty($cash_prevalance_data))
            {
                //echo 'ok';exit;
                $debit = $cash_prevalance_data->debit;
                $credit = $cash_prevalance_data->credit;
                if($debit > $credit)
                {
                    $PreBalance = $debit - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $debit;
                    $preDebCre = 'Cr';
                }
            }

            if( (!empty($request->date_from)) && (!empty($request->date_to)) )
            {
                $cash_data_results = DB::table('postings')
                    ->where('is_approved','approved')
                    ->whereBetween('date', [$request->date_from, $request->date_to])
                    ->where(function ($query) {
                        $query->where('account_no','=','10201')  // cash
                        ->orWhere('account_no','LIKE','10201%') // bank
                        ->Where('bank_user','=','Inventories'); // bank
                    })
                    ->get();
            }else{
                $cash_data_results = DB::table('postings')
                    ->where('is_approved','approved')
                    ->where(function ($query) {
                        $query->where('account_no','=','10201')  // cash
                        ->orWhere('account_no','LIKE','10201%') // bank
                        ->Where('bank_user','=','Inventories'); // bank
                    })
                    ->get();
            }
        }

        $date_from = '';
        $date_to = '';

        if($request->date_from)
        {
            $date_from = $request->date_from;
        }
        if($request->date_to)
        {
            $date_to = $request->date_to;
        }
//dd($cash_prevalance_data);
//dd($cash_data_results);
        return view('backend.account.cashbook', compact('cash_data_results', 'PreBalance', 'preDebCre','date_from','date_to'));
    }

    public function cash_book_print($date_from,$date_to)
    {
        $PreBalance=0;
        $preDebCre = 'De/Cr';
        $cash_data_results = '';



        $cash_prevalance_data = DB::table('postings')
            ->select('account_no', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
            ->where('date', '<',$date_from)
            ->where('account_no','10201')
            ->where('is_approved','approved')
            ->groupBy('account_no')
            ->first();


        if(!empty($cash_prevalance_data))
        {
            //echo 'ok';exit;
            $debit = $cash_prevalance_data->debit;
            $credit = $cash_prevalance_data->credit;
            if($debit > $credit)
            {
                $PreBalance = $debit - $credit;
                $preDebCre = 'De';
            }else{
                $PreBalance = $credit - $debit;
                $preDebCre = 'Cr';
            }
        }

        if( (!empty($date_from)) && (!empty($date_to)) )
        {
            $cash_data_results = DB::table('postings')
                ->where('account_no','10201')
                ->where('is_approved','approved')
                ->whereBetween('date', [$date_from, $date_to])
                ->get();
        }else{
            $cash_data_results = DB::table('postings')
                ->where('account_no','10201')
                ->where('is_approved','approved')
                ->get();
        }

        return view('backend.account.cashbook_print', compact('cash_data_results', 'PreBalance', 'preDebCre','date_from','date_to'));
    }


    public function debit_voucher_form(){
        $general_ledger_account_nos = DB::table('accounts')
            ->where('IsGL','1')
            ->where(function ($query) {
                $query->where('HeadCode','LIKE','501%')
                ->orWhere('HeadCode','LIKE','40%');
            })
            ->Orderby('HeadName', 'asc')
            ->get();
        //dd($accounts);

        return view('backend.account.debit_voucher_form', compact('general_ledger_account_nos'));
    }

    public function view_debit_voucher(Request $request)
    {
        $general_ledger = $request->general_ledger;
        //dd($general_ledger);
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $acc_name = Account::where('HeadCode',$request->general_ledger)->pluck('HeadName')->first();
        $transaction_no = Account::where('HeadCode',$request->general_ledger)->pluck('id')->first();
        $transaction = Posting::where('account_id',$transaction_no)->pluck('id')->first();
//dd($acc_name);
        if( (!empty($general_ledger)) && (!empty($date_from)) && (!empty($date_to)) )
        {
            //echo 'okk';exit;
            $general_ledger_infos = DB::table('postings')
                //->join('accounts', 'postings.id', '=', 'accounts.user_id')
                ->leftJoin('accounts', 'postings.account_no', '=', 'accounts.HeadCode')
                ->where('postings.account_no',$general_ledger)
                ->where('postings.debit','>',0)
                ->whereBetween('postings.date', [$date_from, $date_to])
                ->select('postings.voucher_no', 'postings.date', 'postings.account_no', 'postings.transaction_description', 'postings.debit', 'postings.credit', 'accounts.HeadName', 'accounts.PHeadName', 'accounts.HeadType')
                ->get();
        }else{
            //echo 'noo';exit;
            $general_ledger_infos = DB::table('postings')
                //->join('accounts', 'postings.id', '=', 'accounts.user_id')
                ->leftJoin('accounts', 'postings.account_no', '=', 'accounts.HeadCode')
                ->where('postings.debit','>',0)
                ->whereBetween('postings.date', [$date_from, $date_to])
                ->select('postings.voucher_no', 'postings.date', 'postings.account_no', 'postings.transaction_description', 'postings.debit', 'postings.credit', 'accounts.HeadName', 'accounts.PHeadName', 'accounts.HeadType')
                ->get();
        }

        //dd($general_ledger_infos);

        return view('backend.account.debit_voucher_view', compact('general_ledger_infos', 'general_ledger', 'date_from', 'date_to','acc_name','transaction'));
    }


    public function debit_voucher_print($transaction_head,$date_from,$date_to)
    {
//echo ($transaction_head->account_no);
//exit;

        $transaction_no = Account::where('HeadCode',$transaction_head)->pluck('id')->first();
        $transaction = Posting::where('account_id',$transaction_no)->pluck('id')->first();
        //dd($transaction);
        $acc_name = Account::where('HeadCode',$transaction_head)->pluck('HeadName')->first();
        //dd($acc_name);
        if( (!empty($transaction_head)) && (!empty($date_from)) && (!empty($date_to)) )
        {
            $gl_prevalance_data = DB::table('postings')
                ->select('account_no', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('date', '<',$date_from)
                ->where('account_no',$transaction_head)
                ->groupBy('account_no')
                ->first();
        }else{
            $gl_prevalance_data = DB::table('postingspostings')
                ->select('account_no', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('date', '<',$date_from)
                ->groupBy('account_no')
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
            $general_ledger_infos = DB::table('postings')
                //->join('accounts', 'postings.id', '=', 'accounts.user_id')
                ->leftJoin('accounts', 'postings.account_no', '=', 'accounts.HeadCode')
                ->where('postings.account_no',$transaction_head)
                ->whereBetween('postings.date', [$date_from, $date_to])
                ->select('postings.voucher_no', 'postings.date', 'postings.account_no', 'postings.transaction_description', 'postings.debit', 'postings.credit', 'accounts.HeadName', 'accounts.PHeadName', 'accounts.HeadType')
                ->get();
        }else{
            //echo 'noo';exit;
            $general_ledger_infos = DB::table('postings')
                //->join('accounts', 'postings.id', '=', 'accounts.user_id')
                ->leftJoin('accounts', 'postings.account_no', '=', 'accounts.HeadCode')
                ->whereBetween('postings.date', [$date_from, $date_to])
                ->select('postings.voucher_no',  'postings.date', 'postings.account_no', 'postings.transaction_description', 'postings.debit', 'postings.credit', 'accounts.HeadName', 'accounts.PHeadName', 'accounts.HeadType')
                ->get();
        }

        //dd($general_ledger_infos);

        return view('backend.account.debit_voucher_print', compact('acc_name','transaction','general_ledger_infos','PreBalance', 'preDebCre', 'transaction_head', 'date_from', 'date_to'));
    }


    public function credit_voucher_form(){
        $general_ledger_account_nos = DB::table('accounts')
                                    ->where('IsGL','1')
                                    ->where('HeadCode','LIKE','10103%')
                                    ->Orderby('HeadName', 'asc')
                                    ->get();
        //dd($accounts);

        return view('backend.account.credit_voucher_form', compact('general_ledger_account_nos'));
    }
    public function view_credit_voucher(Request $request)
    {
        $general_ledger = $request->general_ledger;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $acc_name = Account::where('HeadCode',$request->general_ledger)->pluck('HeadName')->first();
        $transaction_no = Account::where('HeadCode',$request->general_ledger)->pluck('id')->first();
        $transaction = Posting::where('account_id',$transaction_no)->pluck('id')->first();
        //dd($transaction);
        if( (!empty($general_ledger)) && (!empty($date_from)) && (!empty($date_to)) )
        {
            //echo 'okk';exit;
            $general_ledger_infos = DB::table('postings')
                //->join('accounts', 'postings.id', '=', 'accounts.user_id')
                ->leftJoin('accounts', 'postings.account_no', '=', 'accounts.HeadCode')
                ->where('postings.account_no',$general_ledger)
                ->where('postings.credit','>',0)
                ->whereBetween('postings.date', [$date_from, $date_to])
                ->select('postings.voucher_no', 'postings.date', 'postings.account_no', 'postings.transaction_description', 'postings.debit', 'postings.credit', 'accounts.HeadName', 'accounts.PHeadName', 'accounts.HeadType')
                ->get();
        }else{
            //echo 'noo';exit;
            $general_ledger_infos = DB::table('postings')
                //->join('accounts', 'postings.id', '=', 'accounts.user_id')
                ->leftJoin('accounts', 'postings.account_no', '=', 'accounts.HeadCode')
                ->where('postings.credit','>',0)
                ->whereBetween('postings.date', [$date_from, $date_to])
                ->select('postings.voucher_no', 'postings.date', 'postings.account_no', 'postings.transaction_description', 'postings.debit', 'postings.credit', 'accounts.HeadName', 'accounts.PHeadName', 'accounts.HeadType')
                ->get();
        }

        //dd($general_ledger_infos);

        return view('backend.account.credit_voucher_view', compact('general_ledger_infos', 'general_ledger', 'date_from', 'date_to','acc_name','transaction'));
    }
    public function credit_voucher_print($transaction_head,$date_from,$date_to)
    {
//echo ($transaction_head->account_no);
//exit;
        $transaction_no = Account::where('HeadCode',$transaction_head)->pluck('id')->first();
        $transaction = Posting::where('account_id',$transaction_no)->pluck('id')->first();
        $acc_name = Account::where('HeadCode',$transaction_head)->pluck('HeadName')->first();
        if( (!empty($transaction_head)) && (!empty($date_from)) && (!empty($date_to)) )
        {
            $gl_prevalance_data = DB::table('postings')
                ->select('account_no', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('date', '<',$date_from)
                ->where('account_no',$transaction_head)
                ->groupBy('account_no')
                ->first();
        }else{
            $gl_prevalance_data = DB::table('postings')
                ->select('account_no', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('date', '<',$date_from)
                ->groupBy('account_no')
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
            $general_ledger_infos = DB::table('postings')
                //->join('accounts', 'postings.id', '=', 'accounts.user_id')
                ->leftJoin('accounts', 'postings.account_no', '=', 'accounts.HeadCode')
                ->where('postings.account_no',$transaction_head)
                ->whereBetween('postings.date', [$date_from, $date_to])
                ->select('postings.voucher_no', 'postings.date', 'postings.account_no', 'postings.transaction_description', 'postings.debit', 'postings.credit', 'accounts.HeadName', 'accounts.PHeadName', 'accounts.HeadType')
                ->get();
        }else{
            //echo 'noo';exit;
            $general_ledger_infos = DB::table('postings')
                //->join('accounts', 'postings.id', '=', 'accounts.user_id')
                ->leftJoin('accounts', 'postings.account_no', '=', 'accounts.HeadCode')
                ->whereBetween('postings.date', [$date_from, $date_to])
                ->select('postings.voucher_no',  'postings.date', 'postings.account_no', 'postings.transaction_description', 'postings.debit', 'postings.credit', 'accounts.HeadName', 'accounts.PHeadName', 'accounts.HeadType')
                ->get();
        }

        //dd($general_ledger_infos);

        return view('backend.account.credit_voucher_print', compact('acc_name','transaction','general_ledger_infos','PreBalance', 'preDebCre', 'transaction_head', 'date_from', 'date_to'));
    }
}
