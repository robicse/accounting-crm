<?php

use Illuminate\Support\Facades\DB;

function purchase_account1_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit', 'SUM(credit) as credit'))
        //->where('posting_date', '<=',$date_from)
            ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->where('debit', '>',0)
        ->where('group_3','Purchase Account')
        ->groupBy('group_3')
        ->first();

if (!empty($gl_pre_valance_data))

return $gl_pre_valance_data;

}

function sales_income_statement_for_equity($date_from, $date_to){

   // dd($date_from);
    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Received againts Sales')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Received againts Sales')
        ->where('posting_date', '<=',$date_from)
        //->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


        $data['PreBalance'] = $PreBalance;
        $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function service_income_statement_for_equity($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Received againts Services')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Received againts Services')
        ->where('posting_date', '<=',$date_from)
       //->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

            // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


        $data['PreBalance'] = $PreBalance;
        $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function purchase_account_statement_for_equity($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Purchase Account')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Purchase Account')
        ->where('posting_date', '<=',$date_from)
       //->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

            // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


        $data['PreBalance'] = $PreBalance;
        $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function purchase_installation_statement_for_equity($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Product Installation')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Product Installation')
        ->where('posting_date', '<=',$date_from)
        //->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

            // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


        $data['PreBalance'] = $PreBalance;
        $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function service_expense_statement_for_equity($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Service Expenses')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Service Expenses')
        ->where('posting_date', '<=',$date_from)
        //->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

            // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


        $data['PreBalance'] = $PreBalance;
        $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function carrying_expense_statement_for_equity($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Carrying Expenses')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Carrying Expenses')
        ->where('posting_date', '<=',$date_from)
        //->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

            // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


        $data['PreBalance'] = $PreBalance;
        $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function godwon_storage_statement_for_equity($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Godwon & Storage')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Godwon & Storage')
        ->where('posting_date', '<=',$date_from)
        //->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

            // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


        $data['PreBalance'] = $PreBalance;
        $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function admin_expense_statement_for_equity($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Admin Expense')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Admin Expense')
        ->where('posting_date', '<=',$date_from)
       // ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

            // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


        $data['PreBalance'] = $PreBalance;
        $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function selling_MKT_Expense1_statement_for_equity($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Selling & MKT Expense(Com/Ins)')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Selling & MKT Expense(Com/Ins)')
        ->where('posting_date', '<=',$date_from)
        //->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

            // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


        $data['PreBalance'] = $PreBalance;
        $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function selling_MKT_Expense_statement_for_equity($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Selling & MKT Expense')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Selling & MKT Expense')
        ->where('posting_date', '<=',$date_from)
        //->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

            // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


        $data['PreBalance'] = $PreBalance;
        $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function finance_charges_statement_for_equity($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Finance Charges')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Finance Charges')
        ->where('posting_date', '<=',$date_from)
        //->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

            // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


        $data['PreBalance'] = $PreBalance;
        $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function finance_expense_statement_for_equity($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Finance Expenses')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Finance Expenses')
        ->where('posting_date', '<=',$date_from)
        //->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

            // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


        $data['PreBalance'] = $PreBalance;
        $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}

?>
