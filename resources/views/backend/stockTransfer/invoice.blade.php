@extends('backend._partial.dashboard')
<style>
    .invoice-to{
        /*width: 401px;*/
        padding: 10px;
        /*border: 2px solid black;*/
        margin: 0;
    }
    /*.page-header {*/
    /*    position: fixed;*/
    /*    top: 0mm;*/
    /*    left: 0;*/
    /*    width: 100%;*/
    /*    !*height: 100px;*!*/
    /*    border-bottom: 1px solid black; !* for demo *!*/
    /*    !*background: yellow;*! !* for demo *!*/
    /*}*/
    .header-border {
        /*position: fixed;*/
        /*top: 0mm;*/
        /*left: 0;*/
        width: 100%;
        height: 160px!important;
        margin-top: 8px;
    //border-bottom: 5px solid black; /* for demo */
        /*background: yellow;*/ /* for demo */
    }

</style>
@section('content')
    <link rel="stylesheet" href="{{asset('backend/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('backend/dist/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Invoice</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Invoice</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row header-border">
                        <div class="col-12">
                            <div class="page-header col-md-4" style="text-align: left">
                                <img src="{{ asset('uploads/invoice.png') }}" width="180px" height="150px" alt="header img">
                            </div>
                            <div class="col-md-8" style="text-align: left; margin-left: 180px;margin-top: -150px">
{{--                                <h2>{{$store->name}}</h2>--}}
{{--                                <p style="margin: 0px">Corporate Office :{{$store->address}}</p>--}}
{{--                                <p style="margin: 0px"><b>Phone</b>: {{$store->phone}} </p>--}}
                                <p style="margin: 0px"> <b>Email</b>: info@cleantech.com.bd</p>
                                <p style="margin: 0px"> <b>Website</b>:www.cleantech.com.bd</p>
                                <p style="margin: 0px"> Find us on www.facebook.com/cleantechbd</p>
                            </div>
                            <!-- Main content -->
                            <div class="invoice p-3 mb-3">
                                <div class=" callout-info">
                                    <h5 style="text-align: center;padding: 20px;width: 100%;background-color: grey">Stock Transfer Invoice</h5>
                                </div>
                                <!-- info row -->
                                <div class="row invoice-info">
                                    <div class="col-md-8 invoice-col">

                                        <address>
                                            <strong>From Store:</strong>
                                            <strong>{{$stockTransfer->from_store->name}}</strong>
                                        </address>
                                        <address>
                                            <strong>To Store:</strong>
                                            <strong>{{$stockTransfer->to_store->name}}</strong><br>
                                        </address>
                                        <address>
                                            <strong>Remarks:</strong>
                                            <strong>{{$stockTransfer->send_remarks}}</strong><br>
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-4 invoice-col">
                                        <div class="invoice-to">
                                            <table>
                                                <tr>
                                                    <td style="text-align: right;font-size: 16px;">Invoice No :</td>
                                                    <td style="text-align: right;font-size: 16px;">{{$stockTransfer->invoice_no}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right;font-size: 16px;">Served By:</td>
                                                    <td style="text-align: right;font-size: 16px;">{{\Illuminate\Support\Facades\Auth::user()->name}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.col -->

                                </div>
                                <!-- /.row -->

                                <!-- Table row -->
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr style="background-color: #dddddd">
                                                <th>SL NO.</th>
{{--                                                <th>Reason </th>--}}
                                                <th>Product </th>
                                                <th>Qty</th>
                                                <th>Brand</th>
                                                <th>Unit Price BDT</th>
                                                <th>Amount BDT</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $sum_sub_total = 0;
                                            @endphp
                                            @foreach($stockTransferDetails as $key =>$stockTransferDetail)
                                                <tr>
                                                    <td>{{$key+1}}</td>
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

                                            @endforeach
                                            <tr>
                                                <th colspan="4">&nbsp;</th>
                                                <th>Subtotal:</th>
                                                <th> {{$sum_sub_total}}</th>
                                            </tr>

                                            </tbody>
                                        </table>

                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                <div class="write">
                                    <p class="lead"><b>In Word : {{ucwords($digit->format($sum_sub_total))}} Only</b></p>
                                </div>

                            </div>
                            <!-- /.row -->
                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-12">
                                    <a href="{{route('stock.transfer.invoice.print',$stockTransfer->id)}}" target="_blank" class="btn btn-success float-right"><i class="fas fa-print"></i> Print</a>

                                </div>
                            </div>
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('backend/dist/js/adminlte.min.js')}}"></script>
    <script src="{{asset('backend/dist/js/demo.js')}}"></script>

@endsection


