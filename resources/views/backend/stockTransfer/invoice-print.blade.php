<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<!-- Printable area end -->
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4></h4>
                </div>
            </div>
            <div id="printArea">
                <style>
                    .panel-body {
                        min-height: 1000px !important;
                        font-size: 16px !important;
                        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
                        font-weight: inherit;
                    }
                    .panel-body p {
                        font-size: 14px !important;

                    }
                    .invoice {
                        border-collapse: collapse;
                        width: 100%;
                    }

                    .invoice th {
                        /*border-top: 1px solid #000;*/
                        /*border-bottom: 1px solid #000;*/
                        border: 1px solid #000;
                    }

                    .invoice td {
                        text-align: center;
                        font-size: 16px;
                        border: 1px solid #000;
                    }

                    .invoice-logo{
                        margin-right: 0;
                    }

                    .invoice-logo > img, .invoice-logo > span {
                        float: right !important;
                    }

                    .invoice-to{
                        /*border: 1px solid black;*/
                        margin: 0;
                    }

                    .footer_div {
                        position:absolute;
                        bottom: 0 !important;
                        /*border-top: 1px solid #000000;*/
                        width:100%;
                        font-size: 10px !important;
                        padding-bottom: 20px;
                    }

                    .header-border {
                        /*position: fixed;*/
                        /*top: 0mm;*/
                        /*left: 0;*/
                        width: 100%;
                        height: 160px!important;
                        margin-top: 18px;
                        border-bottom: 5px solid black; /* for demo */
                        /*background: yellow;*/ /* for demo */
                    }
                    /* default settings */
                    /*.page {*/
                    /*    page-break-after: always;*/
                    /*}*/

                    @page {
                        size: A4;
                        /*size: Letter;*/
                        /*margin: 0px !important;*/
                        /*margin: 16px 100px !important;*/
                        margin: 16px 50px !important;
                    }


                    /*@media print {*/
                    /*    table { page-break-inside:auto }*/
                    /*    tr    { page-break-inside:auto; page-break-after:auto }*/
                    /*    thead { display:table-header-group }*/
                    /*    tfoot { display:table-footer-group }*/
                    /*    button {display: none;}*/
                    /*    body {margin: 0;}*/
                    /*}*/
                    /* default settings */

                </style>
                <div class="panel-body">
                    <div class="row  header-border" >
                        {{--                        <div class="page-header col-md-4" style="text-align: left">--}}
                        {{--                            <img src="{{ asset('uploads/invoice.png') }}" width="180px" height="150px" alt="header img">--}}
                        {{--                        </div>--}}
                        <div class="col-md-12" style="text-align: left;">
                            <h2 style="font-size:20px" >CleanTech Engineering</h2>
                            <p style="margin: 0px;font-size: 16px">Corporate Office ::Corporate Office : House-1, Road-16, Section-10, Block-C, Mirpur, Dhaka-1216</p>
                            <p style="margin: 0px;font-size: 16px"><b>Phone</b>:  01701-666 606 </p>
                            <p style="margin: 0px;font-size: 16px"> <b>Email</b>: </p>
                            <p style="margin: 0px;font-size: 16px"> <b>Website</b>:</p>

                        </div>
                    </div>
                    <div>&nbsp;
                        <div class=" callout-info" style="">
                            <h3 style="text-align: center;padding: 12px;width: 96%;background-color: #d2d2d2;border-width:1px; border-style:dotted"> Stock Transfer Invoice</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="width: 60%; float: left;display: inline-block">
                            <strong style="font-size: 15px">From Store:</strong>
                            <strong style="font-size: 15px">{{$stockTransfer->from_store->name}}</strong><br>
                            <strong style="font-size: 15px">To Store:</strong>
                            <strong style="font-size: 15px">{{$stockTransfer->to_store->name}}</strong><br>
                            <strong style="font-size: 15px">Remarks:</strong>
                            <strong style="font-size: 15px">{{$stockTransfer->send_remarks}}</strong><br>
                        </div>
                        <div class="col-md-6" style="text-align: right; width: 40%; display: inline-block">
                            <div class="invoice-to"  style="float: right;">
                                <table>
                                    <tr>
                                        <td style="text-align: left;font-size: 16px;"><b>Invoice:</b></td>
                                        <td style="text-align: right;font-size: 16px;">{{$stockTransfer->invoice_no}}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;font-size: 16px;"><b>Served By:</b></td>
                                        <td style="text-align: right;font-size: 16px;">{{\Illuminate\Support\Facades\Auth::user()->name}}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;font-size: 16px;"><b>Date:</b></td>
                                        <td style="text-align: right;font-size: 16px;">{{$stockTransfer->receive_date}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <br/>
                    <br/>
                    <table class="invoice">
                        <thead>
                        <tr style="background-color: #dddddd">
                            <th style="font-size: 18px">SL NO.</th>
                            <th style="font-size: 18px">Product Information</th>
                            <th style="font-size: 18px">Qty</th>
                            <th style="font-size: 18px">Brand</th>
                            <th style="font-size: 18px">Unit Price BDT</th>
                            <th style="font-size: 18px">Amount BDT</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $sum_sub_total = 0;
                        @endphp
                        @foreach($stockTransferDetails as $key =>$stockTransferDetail)
                            <tr>
                                <td style="font-size: 16px">{{$key+1}}</td>
                                <td>{{$stockTransferDetail->product->name}}</td>
                                <td>{{$stockTransferDetail->qty}}</td>
                                <td>{{$stockTransferDetail->product->product_brand->name}}</td>
                                <td>{{$stockTransferDetail->price}}</td>
                                <td>
                                    @php
                                        $sub_total=$stockTransferDetail->qty*$stockTransferDetail->price;
                                        $sum_sub_total += $sub_total;

                                    @endphp
                                    {{$stockTransferDetail->sub_total}}
                                </td>
                            </tr>
                            </tr>
                        @endforeach

                        <tr >
                            <td colspan="3" style="border: none">&nbsp;</td>
                            <td style="border: none">&nbsp;</td>
                            <td style="border: none">&nbsp;</td>
                        </tr>
                        <tr >
                            <th colspan="4"  style="border: none">&nbsp;</th>
                            <th  style="border: none;text-align: right;font-size: 16px">Subtotal:</th>
                            <th  style="border: none"> {{$sum_sub_total}}</th>
                        </tr>

                        </tbody>
                    </table>
                    <div class="write">
                        <p class="lead"><b>In Word : {{ucwords($digit->format($sum_sub_total))}} Only </b></p>
                    </div>
                    <div class="row" style="margin-top: 150px">
                        <!-- accepted payments column -->
                        <div class="col-md-6">
                            <table width="70%">
                                <tr>
                                    <td style="font-size: 18px;"><b>Notes</b>*</td>
                                    <td style="font-size: 16px;"></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 18px;"> {{$stockTransfer->note}}</td>
                                    <td style="font-size: 16px;"></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 18px;"></td>
                                    <td style="font-size: 16px;"> </td>
                                </tr>


                            </table>

                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row footer_div" style="margin-top: 210px;display: block" >
                        <div class="row">
                            <div class="col-md-6" style="width: 50%; float: left;display: inline-block;">
                                <strong style="border-top: solid 1px #000;text-align: center;width:400px;margin-top: -42px;font-size: 16px">Customer signature</strong><br>
                            </div>
                            <div class="col-md-6" style="text-align:right;float: right;width: 30%;margin-right: 10px; display: inline-block;">
                                <strong style="border-top: solid 1px #000;font-size: 16px">Authorize Signature</strong><br>
                            </div>
                        </div>
                        <hr style="border-top:1px dotted black;width: 100%;height:1px;">
                        <div class="row" >
                            <div class="col-md-6" style="text-align:right;float:right;margin-right: 10px;">
                                <span>Print Date: {{$stockTransfer->created_at}} Computer Generated Invoice</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    window.addEventListener("load", window.print());
</script>


