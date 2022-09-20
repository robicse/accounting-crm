
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

                @if(session('response'))
                    <div class="alert alert-success">
                        {{ session('response') }}
                    </div>
                @endif


                <div class="tile">
                    <div class="col-md-8" style="text-align: center; margin-left: 100px">
                        <h2>StarIT LTD</h2>
                        <p style="margin: 0px">BBTOA Building,4th Floor,Road no:9 ,South Kallyanpur, Mirpur,Dhaka-1207</p>
                        <p style="margin: 0px"><b>Phone</b>:+88028091125 <span>, <b>Email</b>:info@123@starit.com, </span> <span><b>Web</b> :www.123starir.com</span> </p>
                        <h2 id="rcorners2">Debit Voucher</h2>
                    </div>
                    <div class="col-md-4" style="text-align: right; float: right;margin-top: -58px ">
                        Transaction.NO : {{$transaction}}
                        <br/>
                        Date : {{ $date_to }}
                    </div>

                    <div style="margin-top: 30px">
                        <p>Debit A/C: {{$transaction_head}}</p>
                        <p>Head of Account: {{$acc_name}}</p>
                    </div>
                    {{--                <div class="col-md-12" style="text-align: right;">--}}
                    {{--                    Account Name : {{ \App\Account::where('HeadCode', $general_ledger)->pluck('HeadName')->first() }}--}}
                    {{--                </div>--}}
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            {{--                        <th width="10%">Date</th>--}}
                            <th width="70%" style="text-align: center">PARTICULARS</th>
                            {{--                        <th width="12%">Debit</th>--}}
                            <th width="15%">Taka</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $sum_debit = 0;
                           // $sum_credit = 0;
                            $final_debit_credit = 0;
                            $flag = 0;
                            $first_day = date('Y-m-01',strtotime($date_from));
                            $last_day = date('Y-m-t',strtotime($date_from));
                        @endphp

                        @foreach($general_ledger_infos as $key => $general_ledger_info)
                            @php
                                $debit = $general_ledger_info->debit;
                                //$credit = $general_ledger_info->credit;

                                $sum_debit  += $debit;
                                //$sum_credit += $credit;

                            @endphp
                            <tr>
                                {{--                            <td>{{ $general_ledger_info->date }}</td>--}}
                                <td>{{ $general_ledger_info->transaction_description }}</td>
                                <td>{{ number_format($debit,2,'.',',') }}</td>
{{--                                <td>{{ number_format($credit,2,'.',',') }}</td>--}}
{{--                                <td>{{ number_format($PreBalance,2,'.',',') }} {{ $preDebCre }}</td>--}}
                            </tr>
                        @endforeach
                        <tr>
                            {{--                        <td></td>--}}
                            <td align="right">Total</td>
                            <td>{{ number_format($sum_debit,2,'.',',') }}</td>
                            {{--                        <td>&nbsp;</td>--}}
                        </tr>
                        </tbody>
                    </table>
                    {{--<div class="tile-footer">

                    </div>--}}
                    {{--{{ $products->links() }}--}}
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



