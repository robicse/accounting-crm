@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Trial Balance</h1>
            </div>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title text-center">Month of from {{ $date_from }} to {{ $date_to }}</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="40%">Accounts Head</th>
                        <th width="30%">Debit</th>
                        <th width="30%">Credit</th>
                        <th width="30%">Balance</th>
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
                        <tr>
                            <th colspan="4" style="background-color: #dddddd;">Assets</th>
                        </tr>
                        @foreach($oResultAssets as $oResultAsset)
                            @php
                                $sum_assets_debit += $oResultAsset->debit;
                                $sum_assets_credit += $oResultAsset->credit;

                                $sum_debit += $oResultAsset->debit;
                                $sum_credit += $oResultAsset->credit;
                            @endphp
                            <tr>
                                <td>{{ $oResultAsset->HeadName }}</td>
                                <td>{{ $oResultAsset->debit }}</td>
                                <td>{{ $oResultAsset->credit }}</td>
                                <td>
                                    @php
                                        if($sum_debit > $sum_credit){
                                            echo $sum_debit - $sum_credit;
                                            echo 'De';
                                        }else{
                                            echo $sum_credit - $sum_debit;
                                            echo 'Cr';
                                        }
                                    @endphp
                                </td>
                            </tr>
                        @endforeach
                        <tr style="background-color: pink;">
                            <th>Total:</th>
                            <th>Debit: {{ $sum_assets_debit }}</th>
                            <th>Credit: {{ $sum_assets_credit }}</th>
                            <th>&nbsp;</th>
                        </tr>
                    @endif
                    @php
                        $sum_income_debit = 0;
                        $sum_income_credit = 0;
                    @endphp
                    @if(count($oResultIncomes) > 0)
                        <tr>
                            <th colspan="4" style="background-color: #dddddd;">Income</th>
                        </tr>
                        @foreach($oResultIncomes as $oResultIncome)
                            @php
                                $sum_income_debit += $oResultIncome->debit;
                                $sum_income_credit += $oResultIncome->credit;

                                $sum_debit += $oResultIncome->debit;
                                $sum_credit += $oResultIncome->credit;
                            @endphp
                            <tr>
                                <td>{{ $oResultIncome->HeadName }}</td>
                                <td>{{ $oResultIncome->debit }}</td>
                                <td>{{ $oResultIncome->credit }}</td>
                                <td>
                                    @php
                                        if($sum_debit > $sum_credit){
                                            echo $sum_debit - $sum_credit;
                                            echo 'De';
                                        }else{
                                            echo $sum_credit - $sum_debit;
                                            echo 'Cr';
                                        }
                                    @endphp
                                </td>
                            </tr>
                        @endforeach
                        <tr style="background-color: pink;">
                            <th>Total:</th>
                            <th>Debit: {{ $sum_income_debit }}</th>
                            <th>Credit: {{ $sum_income_credit }}</th>
                            <th>&nbsp;</th>
                        </tr>
                    @endif
                    @php
                        $sum_expense_debit = 0;
                        $sum_expense_credit = 0;
                    @endphp
                    @if(count($oResultExpenses) > 0)
                        <tr>
                            <th colspan="4" style="background-color: #dddddd;">Expense</th>
                        </tr>
                        @foreach($oResultExpenses as $oResultExpense)
                            @php
                                $sum_expense_debit += $oResultExpense->debit;
                                $sum_expense_credit += $oResultExpense->credit;

                                $sum_debit += $oResultExpense->debit;
                                $sum_credit += $oResultExpense->credit;
                            @endphp
                            <tr>
                                <td>{{ $oResultExpense->HeadName }}</td>
                                <td>{{ $oResultExpense->debit }}</td>
                                <td>{{ $oResultExpense->credit }}</td>
                                <td>
                                    @php
                                        if($sum_debit > $sum_credit){
                                            echo $sum_debit - $sum_credit;
                                            echo 'De';
                                        }else{
                                            echo $sum_credit - $sum_debit;
                                            echo 'Cr';
                                        }
                                    @endphp
                                </td>
                            </tr>
                        @endforeach
                        <tr style="background-color: pink;">
                            <th>Total:</th>
                            <th>Debit: {{ $sum_expense_debit }}</th>
                            <th>Credit: {{ $sum_expense_credit }}</th>
                            <th>&nbsp;</th>
                        </tr>
                    @endif
                    @php
                        $sum_liability_debit = 0;
                        $sum_liability_credit = 0;
                    @endphp
                    @if(count($oResultLiabilities) > 0)
                        <tr>
                            <th colspan="4" style="background-color: #dddddd;">Liability</th>
                        </tr>
                        @foreach($oResultLiabilities as $oResultLiabilitie)
                            @php
                                $sum_liability_debit += $oResultLiabilitie->debit;
                                $sum_liability_credit += $oResultLiabilitie->credit;

                                $sum_debit += $oResultLiabilitie->debit;
                                $sum_credit += $oResultLiabilitie->credit;
                            @endphp
                            <tr>
                                <td>{{ $oResultLiabilitie->HeadName }}</td>
                                <td>{{ $oResultLiabilitie->debit }}</td>
                                <td>{{ $oResultLiabilitie->credit }}</td>
                                <td>
                                    @php
                                        if($sum_debit > $sum_credit){
                                            echo $sum_debit - $sum_credit;
                                            echo 'De';
                                        }else{
                                            echo $sum_credit - $sum_debit;
                                            echo 'Cr';
                                        }
                                    @endphp
                                </td>
                            </tr>
                        @endforeach
                        <tr style="background-color: pink;">
                            <th>Total:</th>
                            <th>Debit: {{ $sum_liability_debit }}</th>
                            <th>Credit: {{ $sum_liability_credit }}</th>
                            <th>&nbsp;</th>
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
                            <td>{{ $final_sum_credit > $final_sum_debit ? $number_format_balance : '' }}</td>
                            <td>{{ $final_sum_debit > $final_sum_credit ? $number_format_balance : '' }}</td>
                            <td>&nbsp;</td>
                        </tr>
                    @endif
                    <tr style="background-color: green;">
                        <th>Final Total:</th>
                        <th>Debit: {{ $final_sum_credit }}</th>
                        <th>Credit: {{ $final_sum_debit }}</th>
                        <th>&nbsp;</th>
                    </tr>
                    </tbody>
                </table>
                </div>
                <div class="tile-footer">
                </div>
            </div>
            <div class="text-center">
                <a href="{{ url('account/trial-balance-print/'.$date_from.'/'.$date_to) }}" target="_blank" class="btn btn-sm btn-primary float-left">Print</a>
            </div>
        </div>
    </main>
@endsection


