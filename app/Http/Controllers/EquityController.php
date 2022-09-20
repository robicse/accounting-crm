<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquityController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:equity-form', ['only' => ['equityForm']]);

    }
    public function equityForm(){
        return view('backend.new-account.equity');
    }
    public function viewEquity(Request $request ){
        $date_from = date('Y-m-01');
        $date_to = date('Y-m-d');

        $PreBalance=0;
        $preDebCre = 'De/Cr';
        $PreResultAssets = '';
        $PreResultIncomes = '';
        $PreResultExpenses = '';
        $PreResultLiabilities = '';

        $oResultAssets = '';
        $oResultIncomes = '';
        $oResultExpenses = '';
        $oResultLiabilities = '';

        if ($request->isMethod('post') && $request->date_from && $request->date_to) {
            $date_from = $request->date_from;
            $date_to = $request->date_to;

            $pre_sum_assets_debit = 0;
            $pre_sum_assets_credit = 0;

            $PreResultAssets = DB::table('posting_form_details')
                ->join('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                //->select('postings.debit', 'postings.credit', 'postings.transaction_description', 'accounts.HeadName')
                ->select('posting_form_details.ledger_id','posting_form_details.ledger_name', DB::raw('SUM(posting_form_details.debit) as debit, SUM(posting_form_details.credit) as credit'))
                // ->where('postings.is_approved','approved')
                ->where('posting_form_details.head_type','A')
                ->where('posting_forms.posting_date','<', $date_from)
                ->groupBy('posting_form_details.ledger_id')
                ->groupBy('posting_form_details.ledger_name')
                ->get();

            if(count($PreResultAssets) > 0)
            {
                foreach($PreResultAssets as $PreResultAsset)
                {
                    $pre_sum_assets_debit += $PreResultAsset->debit;
                    $pre_sum_assets_credit += $PreResultAsset->credit;
                }
            }

            //dd($PreResultAssets);

            $pre_sum_income_debit = 0;
            $pre_sum_income_credit = 0;

            $PreResultIncomes = DB::table('posting_form_details')
                ->join('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                //->select('postings.debit', 'postings.credit', 'postings.transaction_description', 'accounts.HeadName')
                ->select('posting_form_details.ledger_id','posting_form_details.ledger_name', DB::raw('SUM(posting_form_details.debit) as debit, SUM(posting_form_details.credit) as credit'))
                ->where('posting_form_details.head_type','I')
                ->where('posting_forms.posting_date','<', $date_from)
                ->groupBy('posting_form_details.ledger_id')
                ->groupBy('posting_form_details.ledger_name')
                ->get();

            if(count($PreResultIncomes) > 0)
            {
                foreach($PreResultIncomes as $PreResultIncome)
                {
                    $pre_sum_income_debit += $PreResultIncome->debit;
                    $pre_sum_income_credit += $PreResultIncome->credit;
                }
            }

            $pre_sum_expense_debit = 0;
            $pre_sum_expense_credit = 0;

            $PreResultExpenses = DB::table('posting_form_details')
                ->join('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                //->select('postings.debit', 'postings.credit', 'postings.transaction_description', 'accounts.HeadName')
                ->select('posting_form_details.ledger_id','posting_form_details.ledger_name', DB::raw('SUM(posting_form_details.debit) as debit, SUM(posting_form_details.credit) as credit'))
                ->where('posting_form_details.head_type','E')
                ->where('posting_forms.posting_date','<', $date_from)
                ->groupBy('posting_form_details.ledger_id')
                ->groupBy('posting_form_details.ledger_name')
                ->get();


            if(count($PreResultExpenses) > 0)
            {
                foreach($PreResultExpenses as $PreResultExpense)
                {
                    $pre_sum_expense_debit += $PreResultExpense->debit;
                    $pre_sum_expense_credit += $PreResultExpense->credit;
                }
            }

            $pre_sum_liability_debit = 0;
            $pre_sum_liability_credit = 0;
            $PreResultLiabilities = DB::table('posting_form_details')
                ->join('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                //->select('postings.debit', 'postings.credit', 'postings.transaction_description', 'accounts.HeadName')
                ->select('posting_form_details.ledger_id','posting_form_details.ledger_name', DB::raw('SUM(posting_form_details.debit) as debit, SUM(posting_form_details.credit) as credit'))
                ->where('posting_form_details.head_type','L')
                ->where('posting_forms.posting_date','<', $date_from)
                ->groupBy('posting_form_details.ledger_id')
                ->groupBy('posting_form_details.ledger_name')
                ->get();


            if(count($PreResultLiabilities) > 0)
            {
                foreach($PreResultLiabilities as $PreResultLiabilitie)
                {
                    $pre_sum_liability_debit += $PreResultLiabilitie->debit;
                    $pre_sum_liability_credit += $PreResultLiabilitie->credit;
                }
            }

            $final_pre_sum_debit = $pre_sum_assets_debit + $pre_sum_income_debit + $pre_sum_expense_debit + $pre_sum_liability_debit;
            $final_pre_sum_credit = $pre_sum_assets_credit + $pre_sum_income_credit + $pre_sum_expense_credit + $pre_sum_liability_credit;
            if($final_pre_sum_debit > $final_pre_sum_credit)
            {
                $PreBalance = $final_pre_sum_debit - $final_pre_sum_credit;
                $preDebCre = 'De';
            }else{
                $PreBalance = $final_pre_sum_credit - $final_pre_sum_debit;
                $preDebCre = 'Cr';
            }

            $oResultAssets = DB::table('posting_form_details')
                ->join('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                //->select('postings.debit', 'postings.credit', 'postings.transaction_description', 'accounts.HeadName')
                ->select('posting_form_details.ledger_id','posting_form_details.ledger_name', DB::raw('SUM(posting_form_details.debit) as debit, SUM(posting_form_details.credit) as credit'))
                ->where('posting_form_details.head_type','A')
                ->whereBetween('posting_forms.posting_date', [$date_from, $date_to])
                ->groupBy('posting_form_details.ledger_id')
                ->groupBy('posting_form_details.ledger_name')
                ->get();

            $oResultIncomes = DB::table('posting_form_details')
                ->join('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                //->select('postings.debit', 'postings.credit', 'postings.transaction_description', 'accounts.HeadName')
                ->select('posting_form_details.ledger_id','posting_form_details.ledger_name', DB::raw('SUM(posting_form_details.debit) as debit, SUM(posting_form_details.credit) as credit'))
                ->where('posting_form_details.head_type','I')
                ->whereBetween('posting_forms.posting_date', [$date_from, $date_to])
                ->groupBy('posting_form_details.ledger_id')
                ->groupBy('posting_form_details.ledger_name')
                ->get();
            $oResultExpenses = DB::table('posting_form_details')
                ->join('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                //->select('postings.debit', 'postings.credit', 'postings.transaction_description', 'accounts.HeadName')
                ->select('posting_form_details.ledger_id','posting_form_details.ledger_name', DB::raw('SUM(posting_form_details.debit) as debit, SUM(posting_form_details.credit) as credit'))
                ->where('posting_form_details.head_type','E')
                ->whereBetween('posting_forms.posting_date', [$date_from, $date_to])
                ->groupBy('posting_form_details.ledger_id')
                ->groupBy('posting_form_details.ledger_name')
                ->get();
            $oResultLiabilities = DB::table('posting_form_details')
                ->join('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                //->select('postings.debit', 'postings.credit', 'postings.transaction_description', 'accounts.HeadName')
                ->select('posting_form_details.ledger_id','posting_form_details.ledger_name', DB::raw('SUM(posting_form_details.debit) as debit, SUM(posting_form_details.credit) as credit'))
                ->where('posting_form_details.head_type','L')
                ->whereBetween('posting_forms.posting_date', [$date_from, $date_to])
                ->groupBy('posting_form_details.ledger_id')
                ->groupBy('posting_form_details.ledger_name')
                ->get();

        }


        return view('backend.new-account.equity_view',compact('date_from','date_to'));
    }
}
