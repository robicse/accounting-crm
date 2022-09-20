@extends('backend._partial.dashboard')

@section('content')
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
                        <img src="{{ asset('uploads/invoice.png') }}" width="200px" height="150px" alt="header img">
                    </div>
                    <div class="col-md-10" style="text-align: center; margin-left: 100px">
                        <h2>CleanTech Engineering</h2>
                        <p style="margin: 0px">Corporate Office : House-1, Road-16, Section-10, Block-C, Mirpur, Dhaka-1216</p>
                        <p style="margin: 0px"><b>Phone</b>: 02-58052342, 01701-666 606, 01701-666 601, 01711-991 851. </p>
                        <p style="margin: 0px"> <b>Email</b>: Cleantechbd17@gmail.com</p>
                        <p style="margin: 0px"> <b>Website</b>:www.cleantech.com.bd</p>
                        <p style="margin: 0px"> Find us on www.facebook.com/cleantechbd</p>
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
                                    <h3 style="text-align: center;"><strong>@php
                                                echo \App\VoucherType::where('id',$postingForms[0]->voucher_type_id)->pluck('name')->first();
                                            @endphp</strong> Voucher</h3>
                                    <div style="clear: both">&nbsp;</div>
                                    <div style="clear: both">&nbsp;</div>
{{--                                    <div class="col-md-6 text-left"><strong>Transaction No:</strong> {{$postingForms[0]->id}}</div>--}}
                                    <div class="row">
                                        <div class="col-md-6"><strong> Voucher NO:</strong>
                                            @php
                                                echo \App\VoucherType::where('id',$postingForms[0]->voucher_type_id)->pluck('name')->first();
                                            @endphp - {{$postingForms[0]->voucher_no}}
                                        </div>
                                        <div class="col-md-6 text-right"><strong>Date:</strong> {{$postingForms[0]->posting_date}}</div>
                                    </div>
                                    <div style="clear: both">&nbsp;</div>
                                    <div style="clear: both">&nbsp;</div>
                                    <table class="invoice">
                                        <tr>
                                            <th width="60%">Head Of Account </th>
                                            <th width="60%">Ladger</th>
                                            <th  width="20%">Debit Amount</th>
                                            <th  width="20%">Credit Amount</th>
                                        </tr>
                                        @php
                                            $sum_debit = 0;
                                            $sum_credit = 0;
                                        @endphp
                                        @if(!empty($postingFormsDetails))
                                            @foreach($postingFormsDetails as $transaction_info)
                                                @php
                                                    $sum_debit += $transaction_info->debit ? $transaction_info->debit : 0;
                                                    $sum_credit += $transaction_info->credit ? $transaction_info->credit : 0;
                                                @endphp
                                                <tr>
{{--                                                    <th>{{$transaction_info->group_1}}</th>--}}
                                                    <th>{{$transaction_info->group_3}}.{{$transaction_info->group_4}}</th>
                                                    <th>{{$transaction_info->ledger_name}}</th>
                                                    <th>{{$transaction_info->debit ? number_format( $transaction_info->debit,2,'.',',') : ''}}</th>
                                                    <th>{{$transaction_info->credit ? number_format( $transaction_info->credit,2,'.',',')  : ''}}</th>
                                                </tr>
                                            @endforeach
                                        @endif
                                        <tr>
                                            <th colspan="2">{{$postingFormsId->description}}</th>

                                            <th></th>
                                            <th>Total Amount: {{number_format($sum_credit,2,'.',',')}}</th>
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
                    <div style="width: 100%;padding-top: 80px;padding-bottom: 80px;">
                        <div class="row">
                            <div class="col-md-4">
                                <p  width="20%" style="border-top: solid 1px #000;" align="center"> Prepared By</p>


                            </div>
                            <div class="col-md-4">
                                <p  width="20%" style="border-top: solid 1px #000;" align="center"> Authorised By</p>
                            </div>
                            <div class="col-md-4">
                                <p  width="20%" style="border-top: solid 1px #000;" align="center"> Approved By</p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </main>
    </div>
    <div class="text-center" id="print" style="margin: 20px">
        <input type="button" class="btn btn-warning" name="btnPrint" id="btnPrint" value="Print" onclick="printDiv();"/>
    </div>

    <script type="text/javascript">
        function printDiv() {
            var divName = "printArea";
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            // document.body.style.marginTop="-45px";
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>

@endsection



