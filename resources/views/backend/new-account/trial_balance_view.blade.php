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
                <h1><i class=""></i> Trial Balance</h1>
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
                    <h1>Trial Blanace</h1>
                    <h4 >For The Period Of {{ $date_from }} to {{ $date_to }}</h4>
                </div>
                <div class="col-sm-4" style="text-align: right; width: 33.33333333%; float: left;">
                    From Date : {{ $date_from }}
                    <br/>
                    To Date : {{ $date_to }}
                    <br>
                </div>
{{--                <h3 class="tile-title text-center">Month of from {{ $date_from }} to {{ $date_to }}</h3>--}}
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="50%">Accounts Head</th>
                        <th width="16%">Debit</th>
                        <th width="16%">Credit</th>
                        <th width="16%">Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $sum_debit = 0;
                        $sum_credit = 0;

                        $sum_assets_debit = 0;
                        $sum_assets_credit = 0;

                        $pre_sum_debit = 0;
                        $pre_sum_credit = 0;
                        $first_day = date('Y-m-01',strtotime($date_from));
                    @endphp
                    @if($PreBalance > 0)
                        @php
                            if( ($PreBalance > 0) && ($preDebCre == 'De') )
                            {
                                $pre_particulars = "To balance b/d";
                                $pre_sum_debit += $PreBalance;
                                $number_format_balance = number_format($PreBalance,2,'.',',');
                            }else{
                                $pre_particulars = "By balance b/d";
                                $pre_sum_credit += $PreBalance;
                                $number_format_balance = number_format($PreBalance,2,'.',',');
                            }
                        @endphp
                        <tr>
                            <td>{{ $pre_particulars }}</td>
                            <td>{{ $preDebCre == 'De' ? $number_format_balance : '' }}</td>
                            <td>{{ $preDebCre == 'Cr' ? $number_format_balance : '' }}</td>
                            <td></td>
                        </tr>
                    @endif
                    @if(count($oResultAssets) > 0)
                        <tr >
                            <th class="table-secondary" colspan="4" style="color: black;font-size: 20px;font-style: italic">Assets</th>
                        </tr>
                        @foreach($oResultAssets as $oResultAsset)
                            @php
                                $sum_assets_debit += $oResultAsset->debit;
                                $sum_assets_credit += $oResultAsset->credit;

                                $sum_debit += $oResultAsset->debit;
                                $sum_credit += $oResultAsset->credit;

                                $oResultAssetDebit = $oResultAsset->debit;
                                $oResultAssetCredit = $oResultAsset->credit;
                            @endphp
                            <tr>
                                <td>{{ $oResultAsset->ledger_name }}</td>
                                <td>{{ number_format($oResultAsset->debit ,2,'.',',')}}  </td>
                                <td>{{number_format( $oResultAsset->credit  ,2,'.',',')}}</td>
                                <td>
                                    @php
                                        if($oResultAssetDebit > $oResultAssetCredit){
                                            echo number_format($oResultAssetDebit - $oResultAssetCredit  ,2,'.',',') ;
                                            echo 'De';
                                        }else{
                                            echo number_format($oResultAssetCredit - $oResultAssetDebit,2,'.',',') ;
                                            echo 'Cr';
                                        }
                                    @endphp
                                </td>
                            </tr>
                        @endforeach
                        <tr class="table-secondary">
                            <th>Total:</th>
                            <th>Debit: {{   number_format($sum_assets_debit,2,'.',',') }}</th>
                            <th>Credit: {{   number_format($sum_assets_credit,2,'.',',') }}</th>
                            <th>
                                @php
                                    if($sum_assets_debit > $sum_assets_credit){
                                        echo  number_format($sum_assets_debit - $sum_assets_credit,2,'.',',');
                                        echo 'De';
                                    }else{
                                        echo  number_format( $sum_assets_credit - $sum_assets_debit,2,'.',',');
                                        echo 'Cr';
                                    }
                                @endphp
                            </th>
                        </tr>
                    @endif
                    @php
                        $sum_income_debit = 0;
                        $sum_income_credit = 0;
                    @endphp
                    @if(count($oResultIncomes) > 0)
                        <tr>
                            <th colspan="4" class="table-secondary" style="color: black;font-size: 20px;font-style: italic">Income</th>
                        </tr>
                        @foreach($oResultIncomes as $oResultIncome)
                            @php
                                $sum_income_debit += $oResultIncome->debit;
                                $sum_income_credit += $oResultIncome->credit;

                                $sum_debit += $oResultIncome->debit;
                                $sum_credit += $oResultIncome->credit;

                                $oResultIncomeDebit = $oResultIncome->debit;
                                $oResultIncomeCredit = $oResultIncome->credit;
                            @endphp
                            <tr>
                                <td>{{ $oResultIncome->ledger_name}}</td>
                                <td>{{ number_format($oResultIncome->debit,2,'.',',') }} </td>
                                <td>{{ number_format($oResultIncome->credit,2,'.',',') }} </td>
                                <td>
                                    @php
                                        if($oResultIncomeDebit > $oResultIncomeCredit){
                                            echo  number_format($oResultIncomeDebit - $oResultIncomeCredit,2,'.',',');
                                            echo 'De';
                                        }else{
                                            echo  number_format($oResultIncomeCredit - $oResultIncomeDebit,2,'.',',');
                                            echo 'Cr';
                                        }
                                    @endphp
                                </td>
                            </tr>
                        @endforeach
                        <tr class="table-secondary">
                            <th>Total:</th>
                            <th>Debit: {{ number_format($sum_income_debit,2,'.',',') }}  </th>
                            <th>Credit: {{ number_format($sum_income_credit,2,'.',',') }}  </th>
                            <th>
                                @php
                                    if($sum_income_debit > $sum_income_credit){
                                        echo  number_format($sum_income_debit - $sum_income_credit,2,'.',',');
                                        echo 'De';
                                    }else{
                                        echo  number_format($sum_income_credit - $sum_income_debit,2,'.',',');
                                        echo 'Cr';
                                    }
                                @endphp
                            </th>
                        </tr>
                    @endif
                    @php
                        $sum_expense_debit = 0;
                        $sum_expense_credit = 0;
                    @endphp
                    @if(count($oResultExpenses) > 0)
                        <tr>
                            <th class="table-secondary" colspan="4" style="color: black;font-size: 20px;font-style: italic">Expense</th>
                        </tr>
                        @foreach($oResultExpenses as $oResultExpense)
                            @php
                                $sum_expense_debit += $oResultExpense->debit;
                                $sum_expense_credit += $oResultExpense->credit;

                                $sum_debit += $oResultExpense->debit;
                                $sum_credit += $oResultExpense->credit;

                                $oResultExpenseDebit = $oResultExpense->debit;
                                $oResultExpenseCredit = $oResultExpense->credit;
                            @endphp
                            <tr>
                                <td>{{ $oResultExpense->ledger_name }}</td>
                                <td>{{ number_format($oResultExpense->debit,2,'.',',') }}</td>
                                <td>{{ number_format($oResultExpense->credit,2,'.',',') }}  </td>
                                <td>
                                    @php
                                        if($oResultExpenseDebit > $oResultExpenseCredit){
                                            echo  number_format($oResultExpenseDebit - $oResultExpenseCredit,2,'.',',');
                                            echo 'De';
                                        }else{
                                            echo  number_format($oResultExpenseCredit - $oResultExpenseDebit,2,'.',',');
                                            echo 'Cr';
                                        }
                                    @endphp
                                </td>
                            </tr>
                        @endforeach
                        <tr class="table-secondary">
                            <th>Total:</th>
                            <th>Debit: {{ number_format($sum_expense_debit,2,'.',',') }}</th>
                            <th>Credit: {{ number_format($sum_expense_credit,2,'.',',') }}</th>
                            <th>
                                @php
                                    if($sum_expense_debit > $sum_expense_credit){
                                        echo  number_format($sum_expense_debit - $sum_expense_credit,2,'.',','); ;
                                        echo 'De';
                                    }else{
                                        echo  number_format( $sum_expense_credit - $sum_expense_debit,2,'.',',');;
                                        echo 'Cr';
                                    }
                                @endphp
                            </th>
                        </tr>
                    @endif
                    @php
                        $sum_equity_debit = 0;
                        $sum_equity_credit = 0;
                    @endphp
                    @if(count($oResultEquities) > 0)
                        <tr>
                            <th colspan="4"  class="table-secondary"  style="color: black;font-size: 20px;font-style: italic">Equity</th>
                        </tr>
                        @foreach($oResultEquities as $oResultEquity)
                            @php
                                $sum_equity_debit += $oResultEquity->debit;
                                $sum_equity_credit += $oResultEquity->credit;

                                $sum_debit += $oResultEquity->debit;
                                $sum_credit += $oResultEquity->credit;

                                $oResultEquityDebit = $oResultEquity->debit;
                                $oResultEquityCredit = $oResultEquity->credit;
                            @endphp
                            <tr>
                                <td>{{ $oResultEquity->ledger_name }}</td>
                                <td>{{ number_format($oResultEquity->debit,2,'.',',') }}</td>
                                <td>{{ number_format($oResultEquity->credit,2,'.',',') }}</td>
                                <td>
                                    @php
                                        if($oResultEquityDebit > $oResultEquityCredit){
                                            echo  number_format( $oResultEquityDebit - $oResultEquityCredit,2,'.',',');;
                                            echo 'De';
                                        }else{
                                            echo  number_format($oResultEquityCredit - $oResultEquityDebit,2,'.',','); ;
                                            echo 'Cr';
                                        }
                                    @endphp
                                </td>
                            </tr>
                        @endforeach
                        <tr  class="table-secondary">
                            <th>Total:</th>
                            <th>Debit: {{ number_format($sum_equity_debit,2,'.',',') }}</th>
                            <th>Credit: {{ number_format($sum_equity_credit,2,'.',',') }}</th>
                            <th>
                                @php
                                    if($sum_equity_debit > $sum_equity_credit){
                                        echo  number_format($sum_equity_debit - $sum_equity_credit,2,'.',',');
                                        echo 'De';
                                    }else{
                                        echo  number_format($sum_equity_credit - $sum_equity_debit,2,'.',',');
                                        echo 'Cr';
                                    }
                                @endphp
                            </th>
                        </tr>
                    @endif
                    @php
                        $sum_liability_debit = 0;
                        $sum_liability_credit = 0;
                    @endphp
                    @if(count($oResultLiabilities) > 0)
                        <tr>
                            <th colspan="4"  class="table-secondary"  style="color: black;font-size: 20px;font-style: italic">Liability</th>
                        </tr>
                        @foreach($oResultLiabilities as $oResultLiabilitie)
                            @php
                                $sum_liability_debit += $oResultLiabilitie->debit;
                                $sum_liability_credit += $oResultLiabilitie->credit;

                                $sum_debit += $oResultLiabilitie->debit;
                                $sum_credit += $oResultLiabilitie->credit;

                                $oResultLiabilitieDebit = $oResultLiabilitie->debit;
                                $oResultLiabilitieCredit = $oResultLiabilitie->credit;
                            @endphp
                            <tr>
                                <td>{{ $oResultLiabilitie->ledger_name }}</td>
                                <td>{{ number_format($oResultLiabilitie->debit,2,'.',',') }}  </td>
                                <td>{{  number_format($oResultLiabilitie->credit,2,'.',',') }} </td>
                                <td>
                                    @php
                                        if($oResultLiabilitieDebit > $oResultLiabilitieCredit){
                                            echo  number_format($oResultLiabilitieDebit - $oResultLiabilitieCredit,2,'.',',');
                                            echo 'De';
                                        }else{
                                            echo  number_format($oResultLiabilitieCredit - $oResultLiabilitieDebit,2,'.',',');
                                            echo 'Cr';
                                        }
                                    @endphp
                                </td>
                            </tr>
                        @endforeach
                        <tr  class="table-secondary" >
                            <th>Total:</th>
                            <th>Debit: {{  number_format($sum_liability_debit,2,'.',',') }} </th>
                            <th>Credit: {{  number_format($sum_liability_credit,2,'.',',') }} </th>
                            <th>
                                @php
                                    if($sum_liability_debit > $sum_liability_credit){
                                        echo  number_format($sum_liability_debit - $sum_liability_credit,2,'.',',');
                                        echo 'De';
                                    }else{
                                        echo  number_format($sum_liability_credit - $sum_liability_debit,2,'.',',');
                                        echo 'Cr';
                                    }
                                @endphp
                            </th>
                        </tr>
                    @endif
                    @php
                        $final_debit_credit = 0;
                        $final_sum_debit = $pre_sum_debit + $sum_liability_debit + $sum_expense_debit + $sum_income_debit + $sum_assets_debit;
                        $final_sum_credit = $pre_sum_credit + $sum_liability_credit + $sum_expense_credit + $sum_income_credit + $sum_assets_credit;
                    @endphp
                    @if($final_sum_debit !=$final_sum_credit)
                        @php
                            if($final_sum_debit > $final_sum_credit)
                            {
                                $final_debit_credit = $final_sum_debit;
                                $balance = $final_sum_debit - $final_sum_credit;
                                $number_format_balance = number_format($balance,2,'.',',');
                                $particulars = "By balance c/d";
                            }else{
                                $final_debit_credit = $final_sum_credit;
                                $balance = $final_sum_credit - $final_sum_debit;
                                $number_format_balance = number_format($balance,2,'.',',');
                                $particulars = "To balance c/d";
                            }

                        @endphp
                        <tr>
                            <td>{{ $particulars }}</td>
                            <td>{{ $final_sum_credit > $final_sum_debit ? $number_format_balance : '' }}  </td>
                            <td>{{ $final_sum_debit > $final_sum_credit ? $number_format_balance : '' }}  </td>
                            <td>&nbsp;</td>
                        </tr>
                    @endif
                    <tr  class="table-secondary" >
                        <th>Final Total:</th>
                        <th>Debit: {{ number_format($sum_debit,2,'.',',') }} </th>
                        <th>Credit: {{ number_format($sum_credit,2,'.',',')}} </th>
                        <th>&nbsp;</th>
                    </tr>
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


