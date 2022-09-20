@extends('backend._partial.dashboard')

@section('content')
    <style>
        @media print {
            #printPageButton {
                display: none;
            }
        }
    </style>
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Cash Flow</h1>
            </div>
        </div>
    <div id="printArea">
        <div class="col-md-12">
            <div class="tile">
                <div class="col-sm-4" style="width: 33.33333333%;height:180px; float: left;">
                    <h2>Clean Tech Engineering</h2>
                    <p style="margin: 0px">Corporate Office :Corporate Office :Corporate Office : House-1, Road-16, Section-10, Block-C, Mirpur, Dhaka-1216</p>
                    <p style="margin: 0px"><b>Phone</b>:02-58052342, 01701-666 606, 01701-666 601, 01711-991 851 </p>
                    <p style="margin: 0px"> <b>Email</b>: Cleantechbd17@gmail.com</p>
                </div>
                <div class="col-sm-4" style="text-align: center; width: 33.33333333%; float: left;">
                    <h1>Cash Flow </h1>
                    <h4>For The Period Of {{ $date_from }} to {{ $date_to }}</h4>
                </div>
                <div class="col-sm-4" style="text-align: right; width: 33.33333333%; float: left;">
                    From Date : {{ $date_from }}
                    <br/>
                    To Date : {{ $date_to }}
                    <br>
                </div>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="60%">Particulars</th>
                        <th width="20%">Amount</th>
                        <th width="20%">Balance</th>

                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $sales_income_for_cashFlow_statement = 0;
                        $service_income_for_cashFlow_statement = 0;
                        $advancedReceivedAgaintsSales_for_cashFlow_statement = 0;
                        $account_receivable_for_cashFlow_statement = 0;


                        $loan_and_advances_AOR_for_cashFlow_statement = 0;
                        $loan_and_advances_AAP_for_cashFlow_statement = 0;
                        $purchase_account_for_cashFlow_statement = 0;
                        $account_payable_for_cashFlow_statement = 0;
                        $purchase_installation_for_cashFlow_statement = 0;
                        $service_expense_for_cashFlow_statement = 0;
                        $carrying_expense_statement_for_cashFlow_statement = 0;
                        $godwon_storage_statement_for_cashFlow_statement = 0;
                        $loans_and_advances_statement_for_cashFlow_statement = 0;


                    @endphp
                    <tr style="display: none">
                        <td>Received Against Sale</td>
                        <td> @php
                                $get_data = sales_income_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{number_format($get_data['PreBalance'],2,'.',',')}} {{$get_data['preDebCre']}}
                            @php
                                $sales_income_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>

                    </tr>
                    <tr style="display: none">
                        <td>Accounts Receivale</td>
                        <td> @php
                                $get_data = account_receivable_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{number_format($get_data['PreBalance'],2,'.',',')}} {{$get_data['preDebCre']}}
                            @php
                                $account_receivable_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>

                    </tr>
                    <tr>
                        <td>Recipt Against Sale</td>
                        <td> @php
                                $total_receipt =  $sales_income_for_cashFlow_statement - $account_receivable_for_cashFlow_statement;
                                  echo  number_format($total_receipt,2,'.',',')
                            @endphp
                        </td>
                        <td></td>
                        <td></td>

                    </tr>
                    <tr>
                        <td>Received Against Service</td>
                        <td>@php
                                $get_data = service_income_for_cashFlow_statement($date_from,$date_to);

                            @endphp
                        {{number_format($get_data['PreBalance'],2,'.',',')}} {{$get_data['preDebCre']}}
                            @php
                                $service_income_for_cashFlow_statement +=$get_data['PreBalance'];

                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Advanced Received Against Sales</td>
                        <td> @php
                                $get_data = advancedReceivedAgaintsSales_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                           {{number_format($get_data['PreBalance'],2,'.',',')}} {{$get_data['preDebCre']}}
                            @php
                                $advancedReceivedAgaintsSales_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr class="table-secondary" style="font-size: 20px;font-style: italic" >
                        <td>Cash Received From Customer</td>
                        <td>
                            @php
                            $cash_receive_from_customer =  $total_receipt+$service_income_for_cashFlow_statement+$advancedReceivedAgaintsSales_for_cashFlow_statement;
                               echo number_format($cash_receive_from_customer,2,'.',',');
                            @endphp
                          </td>
                        <td> @php
                            $cash_receive_from_customer =  $total_receipt+$service_income_for_cashFlow_statement+$advancedReceivedAgaintsSales_for_cashFlow_statement;

                            echo number_format($cash_receive_from_customer,2,'.',',');


                            @endphp</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Advanced Office Rent</td>
                        <td>@php
                                $get_data = loan_and_advances_AOR_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                                {{number_format($get_data['PreBalance'],2,'.',',')}} {{$get_data['preDebCre']}}
                            @php
                                $loan_and_advances_AOR_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Advanced Againts Purchase</td>
                        <td>@php
                                $get_data = loan_and_advances_AAP_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{number_format($get_data['PreBalance'],2,'.',',')}}  {{$get_data['preDebCre']}}
                            @php
                                $loan_and_advances_AAP_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="display: none">

                        <td>Purchase Account</td>
                        <td>@php
                                $get_data = purchase_account_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            @if(!empty($get_data))
                               {{number_format($get_data->debit,2,'.',',')}} De
                                @php
                                    $purchase_account_for_cashFlow_statement +=$get_data->debit;
                                @endphp
                            @endif
{{--                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}--}}
                            @php
                               //$purchase_account_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr style="display: none">
                        <td> Accounts Payable</td>
                        <td>@php
                                $get_data = account_payable_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{number_format($get_data['PreBalance'],2,'.',',')}}  {{$get_data['preDebCre']}}
                            @php
                                $account_payable_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr >
                        <td>Paid Against Purchase</td>
                        <td>
                        @php
                        $total_paid_against_purchase =$purchase_account_for_cashFlow_statement - $account_payable_for_cashFlow_statement;
                            echo number_format($total_paid_against_purchase,2,'.',',');
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Product Installation</td>
                        <td>@php
                                $get_data = purchase_installation_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{number_format($get_data['PreBalance'],2,'.',',')}} {{$get_data['preDebCre']}}
                            @php
                                $purchase_installation_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Service Expenses</td>
                        <td>@php
                                $get_data = service_expense_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{number_format($get_data['PreBalance'],2,'.',',')}} {{$get_data['preDebCre']}}
                            @php
                                $service_expense_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Carrying Expenses</td>
                        <td>@php
                                $get_data = carrying_expense_statement_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{number_format($get_data['PreBalance'],2,'.',',')}}  {{$get_data['preDebCre']}}
                            @php
                                $carrying_expense_statement_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Godwon & Storage</td>
                        <td>@php
                                $get_data = godwon_storage_statement_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{number_format($get_data['PreBalance'],2,'.',',')}}  {{$get_data['preDebCre']}}
                            @php
                                $godwon_storage_statement_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Loans & Advances(AAS)</td>
                        <td>@php
                                $get_data = loans_and_advances_statement_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{number_format($get_data['PreBalance'],2,'.',',')}}  {{$get_data['preDebCre']}}
                            @php
                                $loans_and_advances_statement_for_cashFlow_statement +=$get_data['PreBalance'];

                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="table-secondary" style="color: black;font-size: 17px;" >
                        <td>Cash Paid To Supplier</td>
                        <td>
                            @php

                            - $total_cash_paid_to_supplier =
                             $loan_and_advances_AOR_for_cashFlow_statement + $loan_and_advances_AAP_for_cashFlow_statement +$total_paid_against_purchase +$purchase_installation_for_cashFlow_statement +
                        $service_expense_for_cashFlow_statement + $carrying_expense_statement_for_cashFlow_statement +$godwon_storage_statement_for_cashFlow_statement+$loans_and_advances_statement_for_cashFlow_statement;
                            echo    number_format(- $total_cash_paid_to_supplier,2,'.',',');
                            @endphp

                          </td>
                        <td> @php

                               - $total_cash_paid_to_supplier =
                                 $loan_and_advances_AOR_for_cashFlow_statement + $loan_and_advances_AAP_for_cashFlow_statement +$total_paid_against_purchase +$purchase_installation_for_cashFlow_statement +
                            $service_expense_for_cashFlow_statement + $carrying_expense_statement_for_cashFlow_statement +$godwon_storage_statement_for_cashFlow_statement+$loans_and_advances_statement_for_cashFlow_statement;
                             echo    number_format(- $total_cash_paid_to_supplier,2,'.',',');
                            @endphp</td>
                        <td></td>
                    </tr>
                    @php
                        $admin_expense_for_cashFlow_statement = 0;
                        $selling_MKT_Expense1_for_cashFlow_statement = 0;
                        $selling_MKT_Expense_for_cashFlow_statement = 0;


                        $tangible_assets_plant_and_machinery_for_cashFlow_statement = 0;
                        $tangible_assets_furniture_and_fixture_for_cashFlow_statement = 0;
                        $tangible_assets_vehicle_for_cashFlow_statement = 0;
                        $tangible_assets_for_cashFlow_statement = 0;
                        $intangible_assets_for_cashFlow_statement = 0;

                        $sum_cash_paid_on = 0;
                        $sum_financing_paid_on = 0;
                    @endphp
                    @php
                        $total_cash = $cash_receive_from_customer - $total_cash_paid_to_supplier
                    @endphp
                    <tr>
                        <td>Admin Expense</td>
                        <td>@php
                                $get_data = admin_expense_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{number_format($get_data['PreBalance'],2,'.',',')}} {{$get_data['preDebCre']}}
                            @php
                                $admin_expense_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Selling & MKT Expense(Sales Commission / incentive Expenses)</td>
                        <td>@php
                                $get_data = selling_MKT_Expense1_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{number_format($get_data['PreBalance'],2,'.',',')}}  {{$get_data['preDebCre']}}
                            @php
                                $selling_MKT_Expense1_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Selling & MKT Expense</td>
                        <td>@php
                                $get_data = selling_MKT_Expense_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{number_format($get_data['PreBalance'],2,'.',',')}}  {{$get_data['preDebCre']}}
                            @php
                                $selling_MKT_Expense_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="table-secondary" style="color: black;font-size: 17px;" >
                        <td>Cash Paid For Others Operating Expenses</td>
                        <td>
                            @php

                               - $total_cash_paid_for_expense =
                                  $admin_expense_for_cashFlow_statement + $selling_MKT_Expense1_for_cashFlow_statement + $selling_MKT_Expense_for_cashFlow_statement;
                                     echo    number_format(- $total_cash_paid_for_expense,2,'.',',');
                            @endphp
                          </td>
                        <td> @php
                               - $total_cash_paid_for_expense =
                                  $admin_expense_for_cashFlow_statement + $selling_MKT_Expense1_for_cashFlow_statement + $selling_MKT_Expense_for_cashFlow_statement;
                                echo    number_format(- $total_cash_paid_for_expense,2,'.',',');
                            @endphp</td>
                        <td></td>
                    </tr>
                    <tr class="table-secondary" style="color: black;font-size: 20px;font-style: italic" >
                        <td><b>Cashflow from  Operating Activities: </b></td>
                        <td>
                            @php

                            $cashflow_from_operating = $total_cash - $total_cash_paid_for_expense;
                            echo    number_format( $cashflow_from_operating,2,'.',',');
                            @endphp
                            </td>
                        <td>
                            @php

                                $cashflow_from_operating = $total_cash - $total_cash_paid_for_expense;
                            echo    number_format( $cashflow_from_operating,2,'.',',');
                            @endphp
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tangible Assets(Plant & Machinery)</td>
                        <td>
                            @php
                                $get_data = tangible_assets_plant_and_machinery_for_cashFlow_statement($date_from,$date_to);
                                $cash_paid_on_plus_minus = "";
                                if($get_data['preDebCre'] == "De"){
                                    $sign = "-";
                                    $sum_cash_paid_on -= $get_data['PreBalance'];
                                    if($sum_cash_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }elseif($get_data['preDebCre'] == "Cr"){
                                    $sign = "+";
                                    $sum_cash_paid_on += $get_data['PreBalance'];
                                    if($sum_cash_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }else{
                                $sign = '';
                                }
                                echo $sign . number_format( $get_data['PreBalance'],2,'.',',')." ".$get_data['preDebCre'];

                                //$tangible_assets_plant_and_machinery_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tangible Assets(Furniture & Fixture)</td>
                        <td>
                            @php
                                $get_data = tangible_assets_furniture_and_fixture_for_cashFlow_statement($date_from,$date_to);
$cash_paid_on_plus_minus = "";
                                if($get_data['preDebCre'] == "De"){
                                    $sign = "-";
                                    $sum_cash_paid_on -= $get_data['PreBalance'];
                                    if($sum_cash_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }elseif($get_data['preDebCre'] == "Cr"){
                                    $sign = "+";
                                    $sum_cash_paid_on += $get_data['PreBalance'];
                                    if($sum_cash_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }else{
                                $sign = '';
                                }
                                echo $sign . number_format( $get_data['PreBalance'],2,'.',',')." ".$get_data['preDebCre'];

                                //$tangible_assets_furniture_and_fixture_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tangible Assets(Vehicle)</td>
                        <td>@php
                                $get_data = tangible_assets_vehicle_for_cashFlow_statement($date_from,$date_to);
$cash_paid_on_plus_minus = "";
                                if($get_data['preDebCre'] == "De"){
                                    $sign = "-";
                                    $sum_cash_paid_on -= $get_data['PreBalance'];
                                    if($sum_cash_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }elseif($get_data['preDebCre'] == "Cr"){
                                    $sign = "+";
                                    $sum_cash_paid_on += $get_data['PreBalance'];
                                    if($sum_cash_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }else{
                                $sign = '';
                                }
                                echo $sign . number_format( $get_data['PreBalance'],2,'.',',')." ".$get_data['preDebCre'];
                                //$tangible_assets_vehicle_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tangible Assets</td>
                        <td>
                            @php
                                $get_data = tangible_assets_for_cashFlow_statement($date_from,$date_to);
$cash_paid_on_plus_minus = "";
                                if($get_data['preDebCre'] == "De"){
                                    $sign = "-";
                                    $sum_cash_paid_on -= $get_data['PreBalance'];
                                    if($sum_cash_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }elseif($get_data['preDebCre'] == "Cr"){
                                    $sign = "+";
                                    $sum_cash_paid_on += $get_data['PreBalance'];
                                    if($sum_cash_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }else{
                                $sign = '';
                                }
                                echo $sign . number_format( $get_data['PreBalance'],2,'.',',')." ".$get_data['preDebCre'];
                                //$tangible_assets_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Intangible Assets</td>
                        <td>@php
                                $get_data = intangible_assets_for_cashFlow_statement($date_from,$date_to);
$cash_paid_on_plus_minus = "";
                                if($get_data['preDebCre'] == "De"){
                                    $sign = "-";
                                    $sum_cash_paid_on -= $get_data['PreBalance'];
                                    if($sum_cash_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }elseif($get_data['preDebCre'] == "Cr"){
                                    $sign = "+";
                                    $sum_cash_paid_on += $get_data['PreBalance'];
                                    if($sum_cash_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }else{
                                $sign = '';
                                }
                                echo $sign . number_format( $get_data['PreBalance'],2,'.',',')." ".$get_data['preDebCre'];
                                //$intangible_assets_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="table-secondary" style="color: black;font-size: 20px;font-style: italic" >
                        <td><b>Cashflow from Investment Activities: </b></td>
                        <td>@php  $cash_from_invest= $cash_paid_on_plus_minus.$sum_cash_paid_on;
                            echo number_format( $cash_from_invest,2,'.',',');
                            @endphp
                        </td>
                        <td>@php  $cash_from_invest= $cash_paid_on_plus_minus.$sum_cash_paid_on;
                            echo number_format( $cash_from_invest,2,'.',',');
                            @endphp</td>
{{--                        <td>{{$cash_paid_on_plus_minus}}{{$sum_cash_paid_on}}</td>--}}
                        <td></td>
                    </tr>

                    <tr>
                        <td>Finance Charges</td>
                        <td>@php
                                $get_data = final_charges_for_cashFlow_statement($date_from,$date_to);
                                $cash_paid_on_plus_minus = "";
                                if($get_data['preDebCre'] == "De"){
                                    $sign = "-";
                                    $sum_financing_paid_on -= $get_data['PreBalance'];
                                    if($sum_financing_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }elseif($get_data['preDebCre'] == "Cr"){
                                    $sign = "+";
                                    $sum_financing_paid_on += $get_data['PreBalance'];
                                    if($sum_financing_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }else{
                                $sign = '';
                                }
                                echo $sign . number_format( $get_data['PreBalance'],2,'.',',')." ".$get_data['preDebCre']
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Finance Expenses</td>
                        <td>@php
                                $get_data = final_expense_for_cashFlow_statement($date_from,$date_to);
                                $cash_paid_on_plus_minus = "";
                                if($get_data['preDebCre'] == "De"){
                                    $sign = "-";
                                    $sum_financing_paid_on -= $get_data['PreBalance'];
                                    if($sum_financing_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }elseif($get_data['preDebCre'] == "Cr"){
                                    $sign = "+";
                                    $sum_financing_paid_on += $get_data['PreBalance'];
                                    if($sum_financing_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }else{
                                $sign = '';
                                }
                                echo $sign .number_format( $get_data['PreBalance'],2,'.',',')." ".$get_data['preDebCre'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Loan From Owner</td>
                        <td>@php
                                $get_data = loan_from_owner_for_cashFlow_statement($date_from,$date_to);
                                $cash_paid_on_plus_minus = "";
                                if($get_data['preDebCre'] == "De"){
                                    $sign = "-";
                                    $sum_financing_paid_on -= $get_data['PreBalance'];
                                    if($sum_financing_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }elseif($get_data['preDebCre'] == "Cr"){
                                    $sign = "+";
                                    $sum_financing_paid_on += $get_data['PreBalance'];
                                    if($sum_financing_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }else{
                                $sign = '';
                                }
                                echo $sign . number_format( $get_data['PreBalance'],2,'.',',')." ".$get_data['preDebCre']
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Loan From Owner(L-t)</td>
                        <td>@php
                                $get_data = loan_from_owner_lt_for_cashFlow_statement($date_from,$date_to);
                                $cash_paid_on_plus_minus = "";
                                if($get_data['preDebCre'] == "De"){
                                    $sign = "-";
                                    $sum_financing_paid_on -= $get_data['PreBalance'];
                                    if($sum_financing_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }elseif($get_data['preDebCre'] == "Cr"){
                                    $sign = "+";
                                    $sum_financing_paid_on += $get_data['PreBalance'];
                                    if($sum_financing_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }else{
                                $sign = '';
                                }
                                echo $sign . number_format( $get_data['PreBalance'],2,'.',',')." ".$get_data['preDebCre']
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Loan From Other</td>
                        <td>@php
                                $get_data = loan_from_other_for_cashFlow_statement($date_from,$date_to);
                                $cash_paid_on_plus_minus = "";
                                if($get_data['preDebCre'] == "De"){
                                    $sign = "-";
                                    $sum_financing_paid_on -= $get_data['PreBalance'];
                                    if($sum_financing_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }elseif($get_data['preDebCre'] == "Cr"){
                                    $sign = "+";
                                    $sum_financing_paid_on += $get_data['PreBalance'];
                                    if($sum_financing_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }else{
                                $sign = '';
                                }
                                echo $sign . number_format( $get_data['PreBalance'],2,'.',',')." ".$get_data['preDebCre']
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Capital Account</td>
                        <td>@php
                                $get_data = capital_account_for_cashFlow_statement($date_from,$date_to);
                                $cash_paid_on_plus_minus = "";
                                if($get_data['preDebCre'] == "De"){
                                    $sign = "-";
                                    $sum_financing_paid_on -= $get_data['PreBalance'];
                                    if($sum_financing_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }elseif($get_data['preDebCre'] == "Cr"){
                                    $sign = "+";
                                    $sum_financing_paid_on += $get_data['PreBalance'];
                                    if($sum_financing_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }else{
                                $sign = '';
                                }
                                echo $sign . number_format( $get_data['PreBalance'],2,'.',',')." ".$get_data['preDebCre']
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Drawings Account</td>
                        <td>@php
                                $get_data = drawings_account_for_cashFlow_statement($date_from,$date_to);
                                $cash_paid_on_plus_minus = "";
                                if($get_data['preDebCre'] == "De"){
                                    $sign = "-";
                                    $sum_financing_paid_on -= $get_data['PreBalance'];
                                    if($sum_financing_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }elseif($get_data['preDebCre'] == "Cr"){
                                    $sign = "+";
                                    $sum_financing_paid_on += $get_data['PreBalance'];
                                    if($sum_financing_paid_on < 0){
                                        $cash_paid_on_plus_minus = "-";
                                    }else{
                                        $cash_paid_on_plus_minus = "+";
                                    }
                                }else{
                                $sign = '';
                                }
                                echo $sign . number_format( $get_data['PreBalance'],2,'.',',')." ".$get_data['preDebCre']
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr class="table-secondary" style="color: black;font-size: 20px;font-style: italic" >
                        <td><b>Cashflow from Financing Activities: </b></td>
                        <td>@php  //$cash_from_finance= $cash_paid_on_plus_minus.$sum_financing_paid_on;
                                    $cash_from_finance= $sum_financing_paid_on;

                                   echo number_format($cash_from_finance,2,'.',',');
                            @endphp</td>
                        <td>@php  //$cash_from_finance= $cash_paid_on_plus_minus.$sum_financing_paid_on;
                                    $cash_from_finance= $sum_financing_paid_on;
                             echo number_format($cash_from_finance,2,'.',',');
                             @endphp</td>


{{--                        <td>{{$cash_paid_on_plus_minus}}{{$sum_financing_paid_on}}</td>--}}
{{--                        <td>{{$cash_paid_on_plus_minus}}{{$sum_financing_paid_on}}</td>--}}
                        <td></td>
                    </tr>

                    <tr class="table-secondary" style="color: black;font-size: 22px;" >
                        <td><b>Net Cash Increase/Decrease : </b></td>
                        <td></td>
                        <td>
                            @php

                              $net_cash = $cashflow_from_operating+$cash_from_invest+$cash_from_finance;
                              echo number_format($net_cash,2,'.',',');

                            @endphp

                        </td>
                        <td></td>
                    </tr>
                    @php
                        $cash_in_hands_for_cashFlow_statement = 0;
                        $cash_at_bank_for_cashFlow_statement = 0;

                    @endphp
                    <tr>
                        <td>Cash in Hand</td>
                        <td>@php
                                $get_data = cash_in_hands_for_cashFlow_statement($date_from);
                            @endphp
                            {{number_format($get_data['PreBalance'],2,'.',',')}} {{$get_data['preDebCre']}}
                            @php
                                $cash_in_hands_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Cash at Bank</td>
                        <td>@php
                                $get_data = cash_at_bank_for_cashFlow_statement($date_from);
                            @endphp
                            {{number_format($get_data['PreBalance'],2,'.',',')}}   {{$get_data['preDebCre']}}
                            @php
                                $cash_at_bank_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="table-secondary" style="color: black;font-size: 20px;font-style: italic" >
                        <td><b>Beginning Cash And Cash Equivalent: </b></td>
                        <td>    @php

                                $closing =$cash_in_hands_for_cashFlow_statement+$cash_at_bank_for_cashFlow_statement;
                                echo   number_format($closing,2,'.',',');
                            @endphp</td>
                        <td>    @php
                            echo
                                $closing =$cash_in_hands_for_cashFlow_statement+$cash_at_bank_for_cashFlow_statement;
                            echo   number_format($closing,2,'.',',');
                            @endphp</td>
                        <td></td>
                    </tr>
                    <tr class="table-secondary" style="color: black;font-size: 20px;font-style: italic" >
                        <td><b>Closing Cash And Cash Equivalent: </b></td>
                        <td>    @php

                                $finalClosing =$closing+$net_cash;
                             echo   number_format($finalClosing,2,'.',',');
                            @endphp</td>
                        <td>
                            @php

                                $finalClosing =$closing+$net_cash;
                             echo   number_format($finalClosing,2,'.',',');
                            @endphp
                        </td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
                </div>
                <div class="tile-footer">
                </div>
            </div>
            <div class="text-center" id="print" style="margin: 20px">
                <button onclick="window.print()" target="_blank" id="printPageButton" class=" btn btn-sm btn-primary float-left">Print</button>
{{--                <input type="button" class="btn btn-warning" name="btnPrint" id="btnPrint" value="Print" onclick="printDiv();"/>--}}
{{--                <a href="{{ url('account/trial-balance-print/'.$date_from.'/'.$date_to) }}" target="_blank" class="btn btn-sm btn-primary float-left">Print</a>--}}
            </div>
        </div>
        </div>
    </main>
    <script type="text/javascript">
        function printDiv() {
            var divName = "printArea";
           // document.getElementById("myH2").style.color = "#d21616";
           var printContents = document.getElementById(divName).innerHTML;
            // var originalContents = document.body.innerHTML;
            console.log("myH2");
            document.body.innerHTML = printContents;
            // document.body.style.marginTop="-45px";
            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endsection




