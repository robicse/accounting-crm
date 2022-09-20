
<div id="printArea">
    <style>
        /* Styles go here */

        .page-header, .page-header-space {
            height: 150px;
        }

        .page-footer, .page-footer-space {
            height: 100px;

        }

        .page-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            border-top: 1px solid black; /* for demo */
            /*background: yellow;*/ /* for demo */
            /*padding: 5px 20px;*/
        }

        .page-header {
            position: fixed;
            top: 0mm;
            left: 0;
            width: 100%;
            /*height: 100px;*/
            border-bottom: 1px solid black; /* for demo */
            /*background: yellow;*/ /* for demo */
        }

        .page {
            page-break-after: always;
        }

        @page {
            /*margin: 20mm;*/
            /*size: A4;
            margin: 11mm 17mm 17mm 17mm;*/
        }

        @media screen {
            .page-header {display: none;}
            .page-footer {display: none;}
        }

        @media print {
            table { page-break-inside:auto }
            tr    { page-break-inside:auto; page-break-after:auto }
            thead { display:table-header-group }
            tfoot { display:table-footer-group }

            button {display: none;}

            body {margin: 0;}
        }


        /*custom part start*/
        .invoice {
            border-collapse: collapse;
            /*width: 100%;*/
            width: 280mm;
            text-align: center
        }
        .invoice th, .invoice td {
            border: 1px solid #000;
        }
        /*custom part end*/

    </style>
    <main class="app-content">
        <div class="row">
            <div class="col-md-12">

                <div class="col-md-8" style="text-align: center; margin-left: 100px">
                    <h2>Clean Tech Engineering</h2>
                    <p style="margin: 0px">Corporate Office : House-1, Road-16, Section-10, Block-C, Mirpur, Dhaka-1216</p>
                    <p style="margin: 0px"><b>Phone</b>:02-58052342, 01701-666 606, 01701-666 601, 01711-991 851 </p>
                    <p style="margin: 0px"> <b>Email</b>: Cleantechbd17@gmail.com</p>
                    <p style="margin: 0px"> <b>Website</b>:www.cleantech.com.bd</p>
                    <p style="margin: 0px"> Find us on www.facebook.com/cleantechbd</p>
                </div>

{{--                <div class="page-header" style="text-align: center">--}}
{{--                    <img src="{{ asset('header.png') }}" width="100%" height="150px" alt="header img">--}}
{{--                </div>--}}

                <div class="page-footer">
                    <img src="{{ asset('footer.png') }}" width="100%" height="auto" alt="footer img">
                </div>

                <table>

                    <thead>
                    <tr>
                        <td>
                            <!--place holder for the fixed-position header-->
                            <div class="page-header-space"></div>
                        </td>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <!--*** CONTENT GOES HERE ***-->
                            <div class="page" style="padding: 10px;">
                                <h3 style="text-align: center">Month of from {{ $date_from }} to {{ $date_to }}</h3>
                                <table class="invoice">
                                    <tr>
                                        <th width="40%">Accounts Head</th>
                                        <th width="30%">Debit Taka</th>
                                        <th width="30%">Credit Taka</th>
                                    </tr>
                                    @php
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
                                        </tr>
                                    @endif
                                    @if(count($oResultAssets) > 0)
                                        <tr>
                                            <th colspan="3" style="background-color: #dddddd;">Assets</th>
                                        </tr>
                                        @foreach($oResultAssets as $oResultAsset)
                                            @php
                                                $sum_assets_debit += $oResultAsset->debit;
                                                $sum_assets_credit += $oResultAsset->credit;
                                            @endphp
                                            <tr>
                                                <td>{{ $oResultAsset->HeadName }}</td>
                                                <td>{{ $oResultAsset->debit }}</td>
                                                <td>{{ $oResultAsset->credit }}</td>
                                            </tr>
                                        @endforeach
                                        <tr style="background-color: pink;">
                                            <th>Total:</th>
                                            <th>Debit: {{ $sum_assets_debit }}</th>
                                            <th>Credit: {{ $sum_assets_credit }}</th>
                                        </tr>
                                    @endif
                                    @php
                                        $sum_income_debit = 0;
                                        $sum_income_credit = 0;
                                    @endphp
                                    @if(count($oResultIncomes) > 0)
                                        <tr>
                                            <th colspan="3" style="background-color: #dddddd;">Income</th>
                                        </tr>
                                        @foreach($oResultIncomes as $oResultIncome)
                                            @php
                                                $sum_income_debit += $oResultIncome->debit;
                                                $sum_income_credit += $oResultIncome->credit;
                                            @endphp
                                            <tr>
                                                <td>{{ $oResultIncome->HeadName }}</td>
                                                <td>{{ $oResultIncome->debit }}</td>
                                                <td>{{ $oResultIncome->credit }}</td>
                                            </tr>
                                        @endforeach
                                        <tr style="background-color: pink;">
                                            <th>Total:</th>
                                            <th>Debit: {{ $sum_income_debit }}</th>
                                            <th>Credit: {{ $sum_income_credit }}</th>
                                        </tr>
                                    @endif
                                    @php
                                        $sum_expense_debit = 0;
                                        $sum_expense_credit = 0;
                                    @endphp
                                    @if(count($oResultExpenses) > 0)
                                        <tr>
                                            <th colspan="3" style="background-color: #dddddd;">Expense</th>
                                        </tr>
                                        @foreach($oResultExpenses as $oResultExpense)
                                            @php
                                                $sum_expense_debit += $oResultExpense->debit;
                                                $sum_expense_credit += $oResultExpense->credit;
                                            @endphp
                                            <tr>
                                                <td>{{ $oResultExpense->HeadName }}</td>
                                                <td>{{ $oResultExpense->debit }}</td>
                                                <td>{{ $oResultExpense->credit }}</td>
                                            </tr>
                                        @endforeach
                                        <tr style="background-color: pink;">
                                            <th>Total:</th>
                                            <th>Debit: {{ $sum_expense_debit }}</th>
                                            <th>Credit: {{ $sum_expense_credit }}</th>
                                        </tr>
                                    @endif
                                    @php
                                        $sum_liability_debit = 0;
                                        $sum_liability_credit = 0;
                                    @endphp
                                    @if(count($oResultLiabilities) > 0)
                                        <tr>
                                            <th colspan="3" style="background-color: #dddddd;">Liability</th>
                                        </tr>
                                        @foreach($oResultLiabilities as $oResultLiabilitie)
                                            @php
                                                $sum_liability_debit += $oResultLiabilitie->debit;
                                                $sum_liability_credit += $oResultLiabilitie->credit;
                                            @endphp
                                            <tr>
                                                <td>{{ $oResultLiabilitie->HeadName }}</td>
                                                <td>{{ $oResultLiabilitie->debit }}</td>
                                                <td>{{ $oResultLiabilitie->credit }}</td>
                                            </tr>
                                        @endforeach
                                        <tr style="background-color: pink;">
                                            <th>Total:</th>
                                            <th>Debit: {{ $sum_liability_debit }}</th>
                                            <th>Credit: {{ $sum_liability_credit }}</th>
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
                                        <th>Debit: {{ $final_debit_credit }}</th>
                                        <th>Credit: {{ $final_debit_credit }}</th>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    </tbody>

                    <tfoot>
                    <tr>
                        <td>
                            <!--place holder for the fixed-position footer-->
                            <div class="page-footer-space"></div>
                        </td>
                    </tr>
                    </tfoot>

                </table>

            </div>
        </div>
    </main>
</div>

    <!-- select2-->
    <script src="{!! asset('backend/js/plugins/select2.min.js') !!}"></script>
    <script src="{!! asset('backend/js/plugins/bootstrap-datepicker.min.js') !!}"></script>
    <script>
        window.print();
    </script>



