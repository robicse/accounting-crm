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
                <h1><i class=""></i> Income Statement</h1>
            </div>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <div class="col-sm-4" style="width: 33.33333333%;height:180px; float: left;">
                    <h2>Clean Tech Engineering</h2>
                    <p style="margin: 0px">Corporate Office : House-1, Road-16, Section-10, Block-C, Mirpur, Dhaka-1216</p>
                    <p style="margin: 0px"><b>Phone</b>:02-58052342, 01701-666 606, 01701-666 601, 01711-991 851 </p>
                    <p style="margin: 0px"> <b>Email</b>: Cleantechbd17@gmail.com</p>
                </div>
                <div class="col-sm-4" style="text-align: center; width: 33.33333333%; float: left;">
                    <h1>Income Statement</h1>
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
                        <th width="40%">Revenue</th>
                        <th width="30%">Amount</th>
                        <th width="30%">Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                    $income_sale =0;
                    $income_service =0;

                    $inventory =0;
                    $purchase_account =0;
                    $closing_inventory =0;
                    $purchase_installation =0;
                    $service_expense =0;
                    $carrying_expense =0;
                    $godwon_storage =0;
                    $miscellaneous_expense =0;
                    $admin_expense =0;
                    $selling_MKT_Expense1 =0;
                    $selling_MKT_Expense =0;
                    $finance_charges =0;
                    $finance_expense =0;
                    @endphp
                    <tr>
                        <td>Received againts Sales</td>
                        <td>
                            @php
                                $get_data = sales_income_statement($date_from,$date_to);
                                //dd($get_data);

                            @endphp
{{--                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}--}}
                        </td>
                        <td>      {{number_format($get_data['PreBalance'],2,'.',',')}}{{$get_data['preDebCre']}}
                            @php
                                $income_sale +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Received againts Services</td>
                        <td> @php
                                $get_data = service_income_statement($date_from,$date_to);
                                //dd($get_data);

                            @endphp</td>
                        <td>      {{number_format($get_data['PreBalance'],2,'.',',')}} {{$get_data['preDebCre']}}
                            @php
                                $income_service +=$get_data['PreBalance'];
                            @endphp</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>  @php   $income =$income_service+$income_sale;
                              echo    number_format($income,2,'.',',');
                            @endphp</td>

                    </tr>
                    <tr>
                        <td>Direct expense</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Opening Inventory</td>
                             @php

                                $get_data = inventory_statement($date_from,$date_to);
                                //dd($get_data);

                            @endphp
                        <td> {{number_format($get_data['PreBalance'],2,'.',',')}}  {{$get_data['preDebCre']}}
                            @php
                                $inventory +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td> Purchase Account</td>
                             @php

                                $get_data = purchase_account1_statement($date_from,$date_to);
                               // dd($get_data->debit);

                            @endphp
                        <td>@if(!empty($get_data))
                          {{number_format($get_data->debit,2,'.',',')}}De
                            @php
                                $purchase_account +=$get_data->debit;
                            @endphp
                                @endif
                        </td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td> Closing Inventory</td>
                             @php

                                $get_data = closing_inventory_statement($date_from,$date_to);
                                //dd($get_data);

                            @endphp
                        <td> {{number_format($get_data['PreBalance'],2,'.',',')}}  {{$get_data['preDebCre']}}
                            @php
                                $closing_inventory +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    @php
                    $inventory_purchase = $inventory + $purchase_account;
                    $closing =  $inventory_purchase - $closing_inventory;
                    @endphp
                    <tr>
                        <td> Cost Of Good Sold</td>
                        @php

                            $get_data = closing_inventory_statement($date_from,$date_to);
                            //dd($get_data);

                        @endphp
                        <td>
                            @php
                                $closing =  $inventory_purchase - $closing_inventory;
                                 echo  number_format($closing,2,'.',',');
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td> Product Installation</td>
                        @php
                            $get_data = purchase_installation_statement($date_from,$date_to);

                        @endphp
                        <td> {{number_format($get_data['PreBalance'],2,'.',',')}}  {{$get_data['preDebCre']}}
                            @php
                                $purchase_installation +=$get_data['PreBalance'];
                            @endphp</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td> Service Expenses</td>
                        @php
                            $get_data = service_expense_statement($date_from,$date_to);
                        @endphp
                        <td> {{number_format($get_data['PreBalance'],2,'.',',')}}  {{$get_data['preDebCre']}}
                            @php
                                $service_expense +=$get_data['PreBalance'];
                            @endphp</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td> Carrying Expenses</td>
                        @php
                            $get_data = carrying_expense_statement($date_from,$date_to);
                        @endphp
                        <td> {{number_format($get_data['PreBalance'],2,'.',',')}}  {{$get_data['preDebCre']}}
                            @php
                                $carrying_expense +=$get_data['PreBalance'];
                            @endphp
                            </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Godwon & Storage</td>
                        @php
                            $get_data = godwon_storage_statement($date_from,$date_to);
                        @endphp
                        <td> {{number_format($get_data['PreBalance'],2,'.',',')}}  {{$get_data['preDebCre']}}
                            @php
                                $godwon_storage +=$get_data['PreBalance'];
                            @endphp</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Miscellaneous Expense / Damage Goods</td>
                        @php
                            $get_data = miscellaneous_expense($date_from,$date_to);
                        @endphp
                        <td> {{number_format($get_data['PreBalance'],2,'.',',')}}  {{$get_data['preDebCre']}}
                            @php
                                $miscellaneous_expense +=$get_data['PreBalance'];
                            @endphp</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Total : @php   $expense =$closing+$purchase_installation+$service_expense+$carrying_expense+$godwon_storage+$miscellaneous_expense;

                            echo number_format($expense,2,'.',',');
                            @endphp  </td>
                        <td>@php   $expense =$closing+$purchase_installation+$service_expense+$carrying_expense+$godwon_storage+$miscellaneous_expense;
                                   echo number_format($expense,2,'.',',');
                            @endphp </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Gross Profit</td>
                        <td>@php   $gross_profit =$income-$expense;
                                    echo number_format($gross_profit,2,'.',',');
                            @endphp</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Indirect expense</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td> Admin Expense</td>
                        @php
                            $get_data = admin_expense_statement($date_from,$date_to);
                        @endphp
                        <td>{{number_format($get_data['PreBalance'],2,'.',',')}} {{$get_data['preDebCre']}}
                            @php
                                $admin_expense +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>

                    </tr>
                    <tr>
                        <td> Selling & MKT Expense(Commission/Incentive)</td>
                        @php
                            $get_data = selling_MKT_Expense1_statement($date_from,$date_to);
                        @endphp
                        <td>{{number_format($get_data['PreBalance'],2,'.',',')}} {{$get_data['preDebCre']}}
                            @php
                                $selling_MKT_Expense1 +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td> Selling & MKT Expense</td>
                        @php
                            $get_data = selling_MKT_Expense_statement($date_from,$date_to);
                        @endphp
                        <td>{{number_format($get_data['PreBalance'],2,'.',',')}} {{$get_data['preDebCre']}}
                            @php
                                $selling_MKT_Expense +=$get_data['PreBalance'];
                            @endphp
                        </td>

                        <td></td>
                    </tr>
                    <tr>
                        <td> Finance Charges</td>
                        @php
                            $get_data = finance_charges_statement($date_from,$date_to);
                        @endphp
                        <td>{{number_format($get_data['PreBalance'],2,'.',',')}} {{$get_data['preDebCre']}}
                            @php
                                $finance_charges +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td> Finance Expenses</td>
                        @php
                            $get_data = finance_expense_statement($date_from,$date_to);
                        @endphp
                        <td>{{number_format($get_data['PreBalance'],2,'.',',')}} {{$get_data['preDebCre']}}
                            @php
                                $finance_expense +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Total : @php  $indirecExpense = $admin_expense+$selling_MKT_Expense1+$selling_MKT_Expense+$finance_charges+$finance_expense;
                                           echo  number_format($indirecExpense,2,'.',',');
                            @endphp  </td>
                        <td>@php   $indirecExpense =  $admin_expense+$selling_MKT_Expense1+$selling_MKT_Expense+$finance_charges+$finance_expense;
                              echo  number_format($indirecExpense,2,'.',',');
                            @endphp </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Net Profit/Loss</td>
                        <td>@php  $net_profit =$gross_profit-$indirecExpense;
                                     echo  number_format($net_profit,2,'.',',');
                            @endphp</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
                </div>
                <div class="tile-footer">
                </div>
            </div>
            <div class="text-center">
                <button onclick="window.print()" target="_blank"  id="printPageButton" class=" btn btn-sm btn-primary float-left">Print</button>
{{--                <a href="{{ url('account/trial-balance-print/'.$date_from.'/'.$date_to) }}" target="_blank" class="btn btn-sm btn-primary float-left">Print</a>--}}
            </div>
        </div>
    </main>
@endsection


