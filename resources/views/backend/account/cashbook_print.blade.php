
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

                <div class="page-header" style="text-align: left">
                    <img src="{{ asset('backend/2020-11-21.png') }}" width="200px" height="150px" alt="header img">
                </div>
                <div class="col-md-8" style="text-align: center; margin-left: 100px">
                    <h2>StarIT LTD</h2>
                    <p style="margin: 0px">BBTOA Building,4th Floor,Road no:9 ,South Kallyanpur, Mirpur,Dhaka-1207</p>
                    <p style="margin: 0px"><b>Phone</b>:+88028091125 <span>, <b>Email</b>:info@123@starit.com, </span> <span><b>Web</b> :www.123starir.com</span> </p>
                </div>

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
                                <h5 align="center">Cash Book Report from date {{ $date_from }} to date {{ $date_to }}</h5>
                                <table class="invoice">
                                    <tr>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
                                    </tr>
                                    @php
                                        $sum_debit = 0;
                                        $sum_credit = 0;
                                        $final_debit_credit = 0;
                                        $flag = 0;
                                        $first_day = date('Y-m-01',strtotime($date_from));
                                        $last_day = date('Y-m-t',strtotime($date_from));
                                    @endphp
                                    @if($PreBalance > 0)
                                        @php
                                            if( ($PreBalance > 0) && ($preDebCre == 'De') )
                                            {
                                                $pre_particulars = "To balance b/d";
                                                $sum_debit += $PreBalance;
                                            }else{
                                                $pre_particulars = "By balance b/d";
                                                $sum_credit += $PreBalance;
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $first_day }}</td>
                                            <td>{{ $pre_particulars }}</td>
                                            <td>{{ $preDebCre == 'De' ? number_format($PreBalance,2,'.',',') : '' }}</td>
                                            <td>{{ $preDebCre == 'Cr' ? number_format($PreBalance,2,'.',',') : '' }}</td>
                                            <td>{{ number_format($PreBalance,2,'.',',') }} {{ $preDebCre }}</td>
                                        </tr>
                                    @endif

                                    @if(!empty($cash_data_results))
                                        @foreach($cash_data_results as $key => $cash_data_result)
                                            @php
                                                $debit  = $cash_data_result->debit;
                                                $credit = $cash_data_result->credit;

                                                $sum_debit  += $debit;
                                                $sum_credit += $credit;



                                                if($debit > $credit)
                                                    $curRowDebCre = 'De';
                                                else
                                                    $curRowDebCre = 'Cr';

                                                //dd($preDebCre);

                                                if($preDebCre == 'De/Cr' && $flag == 0)
                                                {
                                                    $preDebCre = $curRowDebCre;
                                                    $flag = 1;
                                                }

                                                if($preDebCre == 'De' && $curRowDebCre == 'De')
                                                {
                                                    /*if($PreBalance > $debit)
                                                    {
                                                        $PreBalance = $PreBalance - $debit;
                                                    }else{
                                                        $PreBalance = $debit - $PreBalance;
                                                    }*/
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
                                                    /*if($PreBalance > $credit)
                                                    {
                                                        $PreBalance = $PreBalance - $credit;
                                                    }else{
                                                        $PreBalance = $credit - $PreBalance;
                                                    }*/
                                                    $PreBalance += $credit;
                                                    $preDebCre = 'Cr';
                                                }else{

                                                }

                                            @endphp

                                            <tr>
                                                <td>{{ $cash_data_result->date }}</td>
                                                <td>{{ $cash_data_result->transaction_description }}</td>
                                                <td>{{ number_format($debit,2,'.',',') }}</td>
                                                <td>{{ number_format($credit,2,'.',',') }}</td>
                                                <td>
                                                    {{ number_format($PreBalance,2,'.',',') }} {{ $preDebCre }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                    @if($sum_debit !=$sum_credit)
                                        @php
                                            if($sum_debit > $sum_credit)
                                            {
                                                $final_debit_credit = $sum_debit;
                                                $particulars = "By balance c/d";
                                            }else{
                                                $final_debit_credit = $sum_credit;
                                                $particulars = "To balance c/d";
                                            }

                                        @endphp
                                        <tr>
                                            <td>{{ $last_day }}</td>
                                            <td>{{ $particulars }}</td>
                                            <td>{{ $sum_credit > $sum_debit ? number_format($PreBalance,2,'.',',') : '' }}</td>
                                            <td>{{ $sum_debit > $sum_credit ? number_format($PreBalance,2,'.',',') : '' }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>Total</td>
                                        <td>{{ number_format($final_debit_credit,2,'.',',') }}</td>
                                        <td>{{ number_format($final_debit_credit,2,'.',',') }}</td>
                                        <td>&nbsp;</td>
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



