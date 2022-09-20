@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                {{--<h1><i class=""></i> Accounts</h1>--}}
            </div>
        </div>
        <div class="col-md-12">

            @if(session('response'))
                <div class="alert alert-success">
                    {{ session('response') }}
                </div>
            @endif


            <div class="tile">
                {{--<h3 class="tile-title">Accounts</h3>--}}
                <div class="col-sm-12" style="text-align: center;">
                    Max Enterprise Ltd.
                    <br />
                    Company was Incorporate on 21.June.2017
                    <br/>
                    Statement of Financial Positions
                    <br/>
                    As at 01.10.2017 to {{ date('d.m.Y') }}
                </div>

                @php
                    // non current assets
                    $non_current_assets = 0;

                    // fixed assets
                    $fixed_assets_amount = DB::table('transactions')
                        ->select('account_no', DB::raw('SUM(debit) as total_debit_amount, SUM(credit) as total_credit_amount'))
                        ->where('is_approved','approved')
                        ->where(function ($query) {
                            $query->where('account_no','=','40301')  // fixed assets
                                ->orWhere('account_no','LIKE','10101%'); // accumulated depreciation
                        })
                        ->groupBy('account_no')
                        ->get();

                    $total_fixed_assets_amount = 0;
                    $fixed_assets_amount_flug = 1; // plus
                    if(!empty($fixed_assets_amount))
                    {

                        $sum_debit_amount = 0;
                        $sum_credit_amount = 0;
                        foreach($fixed_assets_amount as $key => $value)
                        {
                            $sum_debit_amount += $value->total_debit_amount;
                            $sum_credit_amount += $value->total_credit_amount;
                        }
                        if($sum_debit_amount > $sum_credit_amount)
                        {
                            $total_fixed_assets_amount = $sum_debit_amount - $sum_credit_amount;

                            // calculate non current assets
                            $non_current_assets += $total_fixed_assets_amount;
                        }else{
                            $total_fixed_assets_amount = $sum_credit_amount - $sum_debit_amount;
                            $receivable_amount_flug = 2; // minus

                            // calculate non current assets
                            $non_current_assets -= $total_fixed_assets_amount;
                        }
                    }

                    // final fixed assets amount
                    $total_fixed_assets_amount_number_format = number_format($total_fixed_assets_amount,2,'.',',');
                    if($fixed_assets_amount_flug == 2)
                    {
                        $final_fixed_assets_amount = "(".$total_fixed_assets_amount_number_format.")";
                    }else{
                        $final_fixed_assets_amount = $total_fixed_assets_amount_number_format;
                    }

                    // final non current assets
                    $final_non_current_assets = number_format($non_current_assets,2,'.',',');



                    // current assets
                    $total_current_assets = 0;


                    // inventories
                    $inventories_amount = DB::table('transactions')
                        ->select('account_no', DB::raw('SUM(debit) as total_debit_amount, SUM(credit) as total_credit_amount'))
                        ->where('is_approved','approved')
                        ->where('account_no','=','10204')
                        ->groupBy('account_no')
                        ->first();

                    $total_inventories_amount = 0;
                    $inventories_amount_flug = 1; // plus
                    if(!empty($inventories_amount))
                    {
                        $debit_amount = $inventories_amount->total_debit_amount;
                        $credit_amount = $inventories_amount->total_credit_amount;
                        if($debit_amount > $credit_amount)
                        {
                            $total_inventories_amount = $debit_amount - $credit_amount;

                            // calculate current assets
                            $total_current_assets += $total_inventories_amount;
                        }else{
                            $total_inventories_amount = $credit_amount - $debit_amount;
                            $inventories_amount_flug = 2; // minus

                            // calculate current assets
                            $total_current_assets -= $total_inventories_amount;
                        }
                    }

                    // final inventories amount
                    $total_inventories_amount_number_format = number_format($total_inventories_amount,2,'.',',');
                    if($inventories_amount_flug == 2)
                    {
                        $final_inventories_amount = "(".$total_inventories_amount_number_format.")";
                    }else{
                        $final_inventories_amount = $total_inventories_amount_number_format;
                    }





                    // Advances, Deposits & Prepayments
                    $advances_deposits_prepayments_amount = DB::table('transactions')
                        ->select('account_no', DB::raw('SUM(debit) as total_debit_amount, SUM(credit) as total_credit_amount'))
                        ->where('is_approved','approved')
                        ->where(function ($query) {
                            $query->where('account_no','=','1020202')
                                ->orWhere('account_no','LIKE','1020201%')
                                ->orWhere('account_no','LIKE','1020203%');
                        })
                        ->groupBy('account_no')
                        ->first();

                    $total_deposit_advance_prepayment_amount = 0;
                    $deposit_advance_prepayment_amount_flug = 1; // plus
                    if(!empty($advances_deposits_prepayments_amount))
                    {
                        $debit_amount = $advances_deposits_prepayments_amount->total_debit_amount;
                        $credit_amount = $advances_deposits_prepayments_amount->total_credit_amount;
                        if($debit_amount > $credit_amount)
                        {
                            $total_deposit_advance_prepayment_amount = $debit_amount - $credit_amount;

                            // calculate current assets
                            $total_current_assets += $total_deposit_advance_prepayment_amount;
                        }else{
                            $total_deposit_advance_prepayment_amount = $credit_amount - $debit_amount;
                            $deposit_advance_prepayment_amount_flug = 2; // minus

                            // calculate current assets
                            $total_current_assets -= $total_deposit_advance_prepayment_amount;
                        }
                    }

                    // final deposit advance prepayment amount
                    $total_deposit_advance_prepayment_amount_number_format = number_format($total_deposit_advance_prepayment_amount,2,'.',',');
                    if($inventories_amount_flug == 2)
                    {
                        $final_deposit_advance_prepayment_amount = "(".$total_deposit_advance_prepayment_amount_number_format.")";
                    }else{
                        $final_deposit_advance_prepayment_amount = $total_deposit_advance_prepayment_amount_number_format;
                    }




                    // account receivable amount
                    $account_receivable_amounts = DB::table('transactions')
                        ->select('account_no', DB::raw('SUM(debit) as total_debit_amount, SUM(credit) as total_credit_amount'))
                        ->where('is_approved','=','approved')
                        ->where(function ($query) {
                            $query->where('account_no','=','10103')
                                ->orWhere('account_no','LIKE','10103%');
                        })
                        ->groupBy('account_no')
                        ->first();

                    $total_receivable_amount = 0;
                    $receivable_amount_flug = 1; // plus
                    if(!empty($account_receivable_amounts))
                    {
                        $sum_debit_amount = 0;
                        $sum_credit_amount = 0;
                        foreach($account_receivable_amounts as $key => $value)
                        {
                            $sum_debit_amount = $account_receivable_amounts->total_debit_amount;
                            $sum_credit_amount = $account_receivable_amounts->total_credit_amount;
                        }
                        if($sum_debit_amount > $sum_credit_amount)
                        {
                            $total_receivable_amount = $sum_debit_amount - $sum_credit_amount;

                            // calculate current assets
                            $total_current_assets += $total_receivable_amount;
                        }else{
                            $total_receivable_amount = $sum_credit_amount - $sum_debit_amount;
                            $receivable_amount_flug = 2; // minus

                            // calculate current assets
                            $total_current_assets -= $total_receivable_amount;
                        }
                    }

                    // final account receivable amount
                    $total_receivable_amount_number_format = number_format($total_receivable_amount,2,'.',',');
                    if($receivable_amount_flug == 2)
                    {
                        $final_receivable_amount = "(".$total_receivable_amount_number_format.")";
                    }else{
                        $final_receivable_amount = $total_receivable_amount_number_format;
                    }








                    // cash and bank balance
                    $cash_and_bank_amount = DB::table('transactions')
                        ->select('account_no', DB::raw('SUM(debit) as total_debit_amount, SUM(credit) as total_credit_amount'))
                        ->where('is_approved','approved')
                        ->where(function ($query) {
                            $query->where('account_no','=','10101')
                                ->orWhere('account_no','LIKE','10201%');
                        })
                        ->groupBy('account_no')
                        ->first();

                    $total_cash_and_bank_amount = 0;
                    $cash_and_bank_amount_flug = 1; // plus
                    if(!empty($cash_and_bank_amount))
                    {
                        $debit_amount = $cash_and_bank_amount->total_debit_amount;
                        $credit_amount = $cash_and_bank_amount->total_credit_amount;
                        if($debit_amount > $credit_amount)
                        {
                            $total_cash_and_bank_amount = $debit_amount - $credit_amount;

                            // calculate current assets
                            $total_current_assets += $total_cash_and_bank_amount;
                        }else{
                            $total_cash_and_bank_amount = $credit_amount - $debit_amount;
                            $cash_and_bank_amount_flug = 2; // minus

                            // calculate current assets
                            $total_current_assets -= $total_cash_and_bank_amount;
                        }
                    }

                    // final cash and bank amount
                    $total_cash_and_bank_amount_number_format = number_format($total_cash_and_bank_amount,2,'.',',');
                    if($cash_and_bank_amount_flug == 2)
                    {
                        $final_cash_and_bank_amount = "(".$total_cash_and_bank_amount_number_format.")";
                    }else{
                        $final_cash_and_bank_amount = $total_cash_and_bank_amount_number_format;
                    }


                    // final current assets
                    if($total_current_assets < 0)
                    {
                        $remove_minus_sign_total_current_assets = abs($total_current_assets);
                        $current_assets_number_format = number_format($remove_minus_sign_total_current_assets,2,'.',',');
                        $final_total_current_assets = "(".$current_assets_number_format.")";
                    }else{
                        $final_total_current_assets = number_format($total_current_assets,2,'.',',');
                    }




                    // final assets

                    $assets_sum = $non_current_assets + $total_current_assets;
                    if($assets_sum < 0)
                    {
                        $remove_minus_sign_assets_sum = abs($assets_sum);
                        $assets_sum_number_format = number_format($remove_minus_sign_assets_sum,2,'.',',');
                        $final_assets = "(".$assets_sum_number_format.")";
                    }else{
                        $final_assets = number_format($assets_sum,2,'.',',');
                    }






                    // EQUITY AND LIABILITYS
                    // Authorized Capital 100000 Ordinary Share of 100 taka each
                    $authorized_capital_amount = DB::table('transactions')
                        ->select('account_no', DB::raw('SUM(credit) as total_credit_amount, SUM(debit) as total_debit_amount'))
                        ->where('is_approved','approved')
                        ->where('account_no','=','202')
                        ->groupBy('account_no')
                        ->first();

                    $total_authorized_capital_amount = 0;
                    $authorized_capital_amount_flug = 1; // plus
                    if(!empty($authorized_capital_amount))
                    {
                        $debit_amount = $authorized_capital_amount->total_debit_amount;
                        $credit_amount = $authorized_capital_amount->total_credit_amount;
                        if($debit_amount > $credit_amount)
                        {
                            $total_authorized_capital_amount = $debit_amount - $credit_amount;
                            $authorized_capital_amount_flug = 2; // minus
                        }else{
                            $total_authorized_capital_amount = $credit_amount - $debit_amount;
                        }
                    }

                    // final authorized capital amount
                    $total_authorized_capital_amount_number_format = number_format($total_authorized_capital_amount,2,'.',',');
                    if($authorized_capital_amount_flug == 2)
                    {
                        $final_authorized_capital_amount = "(".$total_authorized_capital_amount_number_format.")";
                    }else{
                        $final_authorized_capital_amount = $total_authorized_capital_amount_number_format;
                    }



                    // 40000 ordinary share of Tk each Paid Up Capital
                    $ordinary_share_amount = DB::table('transactions')
                        ->select('account_no', DB::raw('SUM(credit) as total_credit_amount, SUM(debit) as total_debit_amount'))
                        ->where('is_approved','approved')
                        ->where('account_no','=','20101')
                        ->groupBy('account_no')
                        ->first();

                    $total_ordinary_share_amount = 0;
                    $ordinary_share_amount_flug = 1; // plus
                    if(!empty($ordinary_share_amount))
                    {
                        $debit_amount = $ordinary_share_amount->total_debit_amount;
                        $credit_amount = $ordinary_share_amount->total_credit_amount;
                        if($debit_amount > $credit_amount)
                        {
                            $total_ordinary_share_amount = $debit_amount - $credit_amount;
                            $ordinary_share_amount_flug = 2; // minus
                        }else{
                            $total_ordinary_share_amount = $credit_amount - $debit_amount;
                        }
                    }

                    // final ordinary share amount
                    $total_ordinary_share_amount_number_format = number_format($total_ordinary_share_amount,2,'.',',');
                    if($ordinary_share_amount_flug == 2)
                    {
                        $final_ordinary_share_amount = "(".$total_ordinary_share_amount_number_format.")";
                    }else{
                        $final_ordinary_share_amount = $total_ordinary_share_amount_number_format;
                    }





                    // Retained Earnings
                    $retained_earnings_amount = DB::table('transactions')
                        ->select('account_no', DB::raw('SUM(credit) as total_credit_amount, SUM(debit) as total_debit_amount'))
                        ->where('is_approved','approved')
                        ->where('account_no','=','20102')
                        ->groupBy('account_no')
                        ->first();

                    $total_retained_earnings_amount = 0;
                    $retained_earnings_amount_flug = 1; // plus
                    if(!empty($retained_earnings_amount))
                    {
                        $debit_amount = $retained_earnings_amount->total_debit_amount;
                        $credit_amount = $retained_earnings_amount->total_credit_amount;
                        if($debit_amount > $credit_amount)
                        {
                            $total_retained_earnings_amount = $debit_amount - $credit_amount;
                            $retained_earnings_amount_flug = 2; // minus
                        }else{
                            $total_retained_earnings_amount = $credit_amount - $debit_amount;
                        }
                    }

                    // final retained earnings amount
                    $total_retained_earnings_amount_number_format = number_format($total_retained_earnings_amount,2,'.',',');
                    if($retained_earnings_amount_flug == 2)
                    {
                        $final_retained_earnings_amount = "(".$total_retained_earnings_amount_number_format.")";
                    }else{
                        $final_retained_earnings_amount = $total_retained_earnings_amount_number_format;
                    }


                    // Shareholder's Equity
                    $sharholders_equity_sum = $total_ordinary_share_amount + $total_retained_earnings_amount;
                    if($sharholders_equity_sum < 0)
                    {
                        $remove_minus_sign_sharholders_equity_sum = abs($sharholders_equity_sum);
                        $sharholders_equity_sum_number_format = number_format($remove_minus_sign_sharholders_equity_sum,2,'.',',');
                        $final_sharholders_equity = "(".$sharholders_equity_sum_number_format.")";
                    }else{
                        $final_sharholders_equity = number_format($sharholders_equity_sum,2,'.',',');
                    }




                    // Loan from Director
                    $loan_from_director = 0;


                    // Short Term Loan
                    $short_term_loan_amount = DB::table('transactions')
                        ->select('account_no', DB::raw('SUM(credit) as total_short_term_loan_amount'))
                        ->where('is_approved','approved')
                        ->where('account_no','=','50302')
                        ->groupBy('account_no')
                        ->first();

                    $total_short_term_loan_amount = 0;
                    $short_term_loan_amount_flug = 1; // plus
                    if(!empty($short_term_loan_amount))
                    {
                        $debit_amount = $short_term_loan_amount->total_debit_amount;
                        $credit_amount = $short_term_loan_amount->total_credit_amount;
                        if($debit_amount > $credit_amount)
                        {
                            $total_short_term_loan_amount = $debit_amount - $credit_amount;
                            $short_term_loan_amount_flug = 2; // minus
                        }else{
                            $total_short_term_loan_amount = $credit_amount - $debit_amount;
                        }
                    }

                    // final short term loan amount
                    $total_short_term_loan_amount_number_format = number_format($total_short_term_loan_amount,2,'.',',');
                    if($short_term_loan_amount_flug == 2)
                    {
                        $final_short_term_loan_amount = "(".$total_short_term_loan_amount_number_format.")";
                    }else{
                        $final_short_term_loan_amount = $total_short_term_loan_amount_number_format;
                    }


                    // final loan from director
                    $final_loan_from_director = $final_short_term_loan_amount;






                    $total_current_liabilities = 0;



                    // Advanced Againest Sales
                    // no clear, kothai hobe chart of accounts



                    // account payable amount
                    $account_payable_amounts = DB::table('transactions')
                        ->select('account_no', DB::raw('SUM(debit) as total_debit_amount, SUM(credit) as total_credit_amount'))
                        ->where('is_approved','approved')
                        ->where(function ($query) {
                            $query->where('account_no','=','501')
                                ->orWhere('account_no','LIKE','501%');
                        })
                        ->groupBy('account_no')
                        ->get();

                    //dd($account_payable_amount);

                    $total_payable_amount = 0;
                    $account_payable_amount_flug = 1; // plus
                    if(!empty($account_payable_amounts))
                    {
                        $sum_debit_amount = 0;
                        $sum_credit_amount = 0;
                        foreach($account_payable_amounts as $key => $value)
                        {
                            $sum_debit_amount += $value->total_debit_amount;
                            $sum_credit_amount += $value->total_credit_amount;
                        }


                        if($sum_debit_amount > $sum_credit_amount)
                        {
                            $total_payable_amount = $sum_debit_amount - $sum_credit_amount;
                            $account_payable_amount_flug = 2; // minus

                            // calculate current liabilities
                            $total_current_liabilities -= $total_payable_amount;
                        }else{
                            $total_payable_amount = $sum_credit_amount - $sum_debit_amount;

                            // calculate current liabilities
                            $total_current_liabilities += $total_payable_amount;
                        }
                    }

                    // final account payable amount
                    $total_payable_amount_number_format = number_format($total_payable_amount,2,'.',',');
                    if($account_payable_amount_flug == 2)
                    {
                        $final_account_payable_amount = "(".$total_payable_amount_number_format.")";
                    }else{
                        $final_account_payable_amount = $total_payable_amount_number_format;
                    }




                     // Liabilities for Expenses
                    $liabilities_for_expenses = DB::table('transactions')
                        ->select('account_no', DB::raw('SUM(debit) as total_debit_amount, SUM(credit) as total_credit_amount'))
                        ->where('is_approved','approved')
                        //->where('account_no','like','5020302%')
                        ->where(function ($query) {
                            $query->where('account_no','LIKE','5020302')
                                ->orWhere('account_no','LIKE','4020%')
                                ->orWhere('account_no','LIKE','4010%');
                        })
                        ->groupBy('account_no')
                        ->get();

                    $total_liabilities_for_expense_amount = 0;
                    $liabilities_for_expense_amount_flug = 1; // plus
                    if(!empty($liabilities_for_expenses))
                    {
                        $sum_debit_amount = 0;
                        $sum_credit_amount = 0;
                        foreach($liabilities_for_expenses as $key => $value)
                        {
                            $sum_debit_amount += $value->total_debit_amount;
                            $sum_credit_amount += $value->total_credit_amount;
                        }
                        if($sum_debit_amount > $sum_credit_amount)
                        {
                            $total_liabilities_for_expense_amount = $sum_debit_amount - $sum_credit_amount;
                            $liabilities_for_expense_amount_flug = 2; // minus

                            // calculate current liabilities
                            $total_current_liabilities -= $total_liabilities_for_expense_amount;
                        }else{
                            $total_liabilities_for_expense_amount = $sum_credit_amount - $sum_debit_amount;

                            // calculate current liabilities
                            $total_current_liabilities += $total_liabilities_for_expense_amount;
                        }
                    }

                    // final liabilities for expense amount
                    $total_liabilities_for_expense_amount_number_format = number_format($total_liabilities_for_expense_amount,2,'.',',');
                    if($liabilities_for_expense_amount_flug == 2)
                    {
                        $final_liabilities_for_expense_amount = "(".$total_liabilities_for_expense_amount_number_format.")";
                    }else{
                        $final_liabilities_for_expense_amount = $total_liabilities_for_expense_amount_number_format;
                    }



                    // Current Liabilities
                    if($total_current_liabilities < 0)
                    {
                        $remove_minus_sign_current_liabilities_sum = abs($total_current_liabilities);
                        $current_liabilities_sum_number_format = number_format($remove_minus_sign_current_liabilities_sum,2,'.',',');
                        $current_liabilities = "(".$current_liabilities_sum_number_format.")";
                    }else{
                        $current_liabilities = number_format($total_current_liabilities,2,'.',',');
                    }




                    // Total Equity & Liabilities
                    $total_equity_liabilities_sum = $total_current_liabilities + $total_short_term_loan_amount + $total_authorized_capital_amount;
                    if($total_equity_liabilities_sum < 0)
                    {
                        $remove_minus_sign_total_equity_liabilities_sum = abs($total_equity_liabilities_sum);
                        $total_equity_liabilities_sum_number_format = number_format($remove_minus_sign_total_equity_liabilities_sum,2,'.',',');
                        $total_equity_liabilities = "(".$total_equity_liabilities_sum_number_format.")";
                    }else{
                        $total_equity_liabilities = number_format($total_equity_liabilities_sum,2,'.',',');
                    }



                    //dd($total_payable_amount);





                @endphp





                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Particulars</th>
                            <th style="text-align: right">Amount in Taka ({{ date('d-m-Y') }})</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                </div>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <td colspan="2"><h6><strong>ASSETS</strong></h6></td>
                    </tr>

                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Non Current Assets:</strong></td>
                            <td><strong>{{ $final_non_current_assets }}</strong></td>
                        </tr>
                        <tr>
                            <td>Fixed Assets</td>
                            <td><span>{{ $final_fixed_assets_amount }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td><strong>Current Assets:</strong></td>
                            <td><strong>{{ $final_total_current_assets }}</strong></td>
                        </tr>
                        <tr>
                            <td>Inventories</td>
                            <td><span>{{ $final_inventories_amount }}</span></td>
                        </tr>
                        <tr>
                            <td>Advances, Deposits & Prepayments</td>
                            <td><span>{{ $final_deposit_advance_prepayment_amount }}</span></td>
                        </tr>
                        <tr>
                            <td>Account Receivable</td>
                            <td><span>{{ $final_receivable_amount }}</span></td>
                        </tr>
                        <tr>
                            <td>Cash and Bank Balance</td>
                            <td><span>{{ $final_cash_and_bank_amount }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td><strong>Total Assets:</strong></td>
                            <td><strong>{{ $final_assets }}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2"><h6><strong>EQUITY AND LIABILITYS</strong></h6></td>
                        </tr>
                        <tr>
                            <td><strong>Authorized Capital 100000 Ordinary Share of 100 taka each</strong></td>
                            <td><strong>{{ $final_authorized_capital_amount }}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td><strong>Shareholder's Equity</strong></td>
                            <td><strong>{{ $final_sharholders_equity }}</strong></td>
                        </tr>
                        <tr>
                            <td>40000 ordinary share of Tk each Paid Up Capital</td>
                            <td><span>{{ $final_ordinary_share_amount }}</span></td>
                        </tr>
                        <tr>
                            <td>Retained Earnings</td>
                            <td><span>{{ $final_retained_earnings_amount }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td><strong>Loan from Director</strong></td>
                            <td><strong>{{ $final_loan_from_director }}</strong></td>
                        </tr>
                        <tr>
                            <td>Short Term Loan</td>
                            <td><span>{{ $final_short_term_loan_amount }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Current Liabilities</strong></td>
                            <td><strong>{{ $current_liabilities }}</strong></td>
                        </tr>
                        <tr>
                            <td>Advanced Againest Sales</td>
                            <td><span>0.00</span></td>
                        </tr>
                        <tr>
                            <td>Accounts Payable</td>
                            <td><span>{{ $final_account_payable_amount }}</span></td>
                        </tr>
                        <tr>
                            <td>Liability for Expense</td>
                            <td><span>{{ $final_liabilities_for_expense_amount }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td><strong>Total Equity & Liabilities</strong></td>
                            <td><strong>{{ $total_equity_liabilities }}</strong></td>
                        </tr>
                    </tbody>
                </table>
                    <div style="text-align: center">The annexed notes form a: integral part of these financial statements.</div>
                    <div style="width: 100%;padding-top: 80px;padding-bottom: 80px;">
                        <table width="100%" cellpadding="1" cellspacing="20" style="margin-top: 50px">
                            <tr>
                                <td width="20%" style="border-top: solid 1px #000;" align="center">Prepared By</td>
                                <td width="20%" style="border-top: solid 1px #000;" align="center">Accounts</td>
                                <td  width="20%" style="border-top: solid 1px #000;" align='center'>Chairman</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="{{ url('account/balance-sheet-print') }}" target="_blank" class="btn btn-sm btn-primary float-left">Print</a>
            </div>
        </div>
    </main>

@endsection

@section('footer')

@endsection
