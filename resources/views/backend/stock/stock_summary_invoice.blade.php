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
                        font-size: 13px !important;
                        font-family:"Times New Roman";
                        font-weight: inherit;
                    }
                    .panel-body p {
                        font-size: 13px !important;

                    }
                    .invoice {
                        border-collapse: collapse;
                        width: 100%;
                    }

                    .invoice th {
                        border: 1px solid #000;
                        font-size: 13px;
                    }

                    .invoice td {
                        text-align: center;
                        font-size: 12px;
                        border: 1px solid #000;
                    }

                    .invoice-logo{
                        margin-right: 0;
                    }

                    .invoice-logo > img, .invoice-logo > span {
                        float: right !important;
                    }

                    .invoice-to{
                        margin: 0;
                    }

                    .footer_div {
                        position:absolute;
                        bottom: 0 !important;
                        width:100%;
                        font-size: 10px !important;
                        padding-bottom: 20px;
                    }

                    .header-border {
                        width: 100%;
                        height: 160px!important;
                        margin-top: 18px;
                        border-bottom: 3px solid black; /* for demo */
                    }
                    @page {
                        size: A4;
                        margin: 16px 50px !important;
                    }

                </style>
                <div class="panel-body">
                    <div class="row  header-border" >

                        <div class="col-9" style="text-align: left;">
                            <h2 style="font-size:20px" >{{$store->name}}</h2>
                            <p style="margin: 0px;font-size: 16px">Corporate Office :{{$store->address}}</p>
                            <p style="margin: 0px;font-size: 16px"><b>Phone</b>: {{$store->phone}} </p>
                            <p style="margin: 0px;font-size: 16px"> <b>Email</b>: {{$store->email}}</p>
                            <p style="margin: 0px;font-size: 16px"> <b>Website</b>:{{$store->website}}</p>
                            <p style="margin: 0px;font-size: 16px"> Find us on {{$store->page}}</p>
                        </div>
                        <div class="col-2" >
{{--                            <b>Serial No: {{$productSale->invoice_count}}</b>--}}
                        </div>
                    </div>
                    <div>&nbsp;
                        <div class=" callout-info" style="">
                            <h3 style="text-align: center;padding: 12px;width: 96%;background-color: #d2d2d2;border-width:1px; border-style:dotted"> STOCK LIST</h3>
                        </div>
                    </div>

                    <br/>
                    <br/>
                    <br/>
                    <table class="invoice" style="margin-top: -20px">
                        <thead>
                        <tr style="background-color: #dddddd">
                            <th>SL NO.</th>
                            <th>Product Information</th>
                            <th>Current Stock</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($stocks as $key => $stock)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$stock->product->name}}</td>
                                <td>{{$stock->current_stock}}</td>
                            </tr>
                        @endforeach
                        <tr >
                            <td colspan="3" style="border: none">&nbsp;</td>
                            <td style="border: none">&nbsp;</td>
                            <td style="border: none">&nbsp;</td>
                        </tr>
                        <tr >
                            <th colspan="2"  style="border: none">&nbsp;</th>
                            <th  style="border: none;text-align: right">Total Product: {{$stocks->count()}}</th>
                            <td  style="border: none"></td>
                        </tr>
                        @php
                        $totalStock = \App\Stock::where('store_id',$store->id)->sum('current_stock');
                        @endphp
                        <tr >
                            <th colspan="2"  style="border: none">&nbsp;</th>
                            <th  style="border: none;text-align: right">Total Stock: {{$totalStock}}</th>
                            <td  style="border: none"></td>
                        </tr>
                        </tbody>
                    </table>
                    <div style="margin-top: 20px; ">
                        <span style="float: right">Print Date: {{date('d-m-Y')}}  Computer Generated Invoice</span>
                    </div>
{{--                    <div class="row footer_div" style="margin-top: 210px;display: block" >--}}
{{--                        <hr style="border-top:1px dotted black;width: 100%;height:1px;">--}}
{{--                        <div class="row" >--}}
{{--                            <div class="col-md-6" style="text-align:right;float:right;margin-right: 10px;">--}}
{{--                                <span>Print Date: {{date('d-m-Y')}}  Computer Generated Invoice</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

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


