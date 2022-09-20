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
                                <h2 style="font-size:20px" >{{$store->name}}</h2>
                                <p style="margin: 0px;font-size: 16px">Corporate Office :{{$store->address}}</p>
                                <p style="margin: 0px;font-size: 16px"><b>Phone</b>: {{$store->phone}} </p>
                                <p style="margin: 0px;font-size: 16px"> <b>Email</b>: {{$store->email}}</p>
                                <p style="margin: 0px;font-size: 16px"> <b>Website</b>:{{$store->website}}</p>
                                <p style="margin: 0px;font-size: 16px"> Find us on {{$store->page}}</p>
                            </div>
                            <!-- Main content -->
                            <div class="invoice p-3 mb-3">
                                <div class=" callout-info">
                                    <h5 style="text-align: center;padding: 20px;width: 100%;background-color: grey"> INVOICE / BILL</h5>
                                </div>
                                <!-- info row -->
                                <div class="row invoice-info">
                                    <div class="col-md-8 invoice-col">
                                        <address>
                                            <strong>Customer ID:</strong>
                                            <strong>CTE0{{$party->id}}</strong>
                                        </address>
                                        <address>
                                            <strong>Customer Name:</strong>
                                            <strong>{{$party->name}}</strong>
                                        </address>
                                        <address>
                                            <strong>Address:</strong>
                                            <strong>{{$party->address}}</strong><br>
                                        </address>
                                        <address>
                                            <strong>Contact No:</strong>
                                            <strong>{{$party->phone}}</strong><br>
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-4 invoice-col">
                                        <div class="invoice-to">
                                            <table>
                                                <tr>
                                                    <td style="text-align: right;font-size: 16px;">Invoice No :</td>
                                                    <td style="text-align: right;font-size: 16px; font-weight: bold">{{$productSale->invoice_no}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right;font-size: 16px;">Sale Date:</td>
                                                    <td style="text-align: right;font-size: 14px;">{{$productSale->date}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right;font-size: 16px;">Served By:</td>
                                                        <td style="text-align: right;font-size: 16px;">{{$productSale->user->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right;font-size: 14px;"><b>Reference:</b></td>
                                                    <td style="text-align: right;font-size: 14px;">{{$productSale->reference_name}}</td>
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
                                                <th>Product Information</th>
                                                <th>Qty</th>
                                                <th>Unit Price BDT</th>
                                                <th>Amount BDT</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $sum_sub_total = 0;
                                            @endphp
                                            @foreach($productSaleDetails as $key => $productSaleDetail)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$productSaleDetail->product->name}}</td>
                                                    <td>{{$productSaleDetail->qty}}</td>
                                                    <td>{{$productSaleDetail->price}}</td>
                                                    <td>
                                                        @php
                                                            $sub_total=$productSaleDetail->qty*$productSaleDetail->price;
                                                            $sum_sub_total += $sub_total;
                                                            $vatAmount = ($sum_sub_total*$productSale->vat_amount)/100;
                                                            $total_discount = (($sum_sub_total+$vatAmount+$productSale->transport_cost)*$productSale->discount_amount)/100;
                                                            //dd($total_discount);
                                                        @endphp
                                                        {{$sub_total}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="4">&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <th colspan="3">&nbsp;</th>
                                                <th>Subtotal:</th>
                                                <th>{{$sum_sub_total}}</th>
                                            </tr>
                                            <tr>
                                                <th colspan="3">&nbsp;</th>
                                                <th>Vat :</th>
{{--                                                <td>{{$productSale->vat_amount}}</td>--}}
                                                <td>{{$vatAmount}}</td>
                                            </tr>
                                            <tr>
                                                <th colspan="3">&nbsp;</th>
                                                <th>Transport/Labour :</th>
                                                <td>{{$productSale->transport_cost}}</td>
                                            </tr>
                                            <tr>
                                                <th colspan="3">&nbsp;</th>
                                                <th>Discount:</th>
{{--                                                @dd($productSale->discount_amount);--}}
                                                @if($productSale->discount_type == 'flat' )

                                                    <td style="border: none">- {{$productSale->discount_amount}}</td>
                                                @else
                                                    <td style="border: none">-{{number_format($total_discount, 2, '.', '')}}</td>
                                                @endif
                                            </tr>
                                            @php
                                                $totalAmount =(($productSale->total_amount ));
                                                  //$DueAmount =( $productSale->due_amount +$productSale->transport_cost);
                                                  $paid_amount =( $productSale->paid_amount );
                                            @endphp
                                            <tr>
                                                <th colspan="3">&nbsp;</th>
                                                <th>Total Amount</th>
{{--                                                <th>{{number_format($totalAmount,2,',',',')}}</th>--}}
                                                <th>{{number_format($totalAmount,2,".",",")}}</th>

                                            </tr>
                                            <tr>
                                                <th colspan="3">&nbsp;</th>
                                                <th>Paid Amount:</th>
                                                <th>{{number_format($paid_amount,2,".",",")}}</th>
                                            </tr>
                                            <tr>
                                                <th colspan="3">&nbsp;</th>
                                                <th>Due Amount:</th>
                                                <th>{{number_format($productSale->due_amount,2,".",",")}}</th>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-striped" style="width: 40%">
                                            <thead>
                                            <tr style="background-color: #dddddd " >
                                                <th>SL NO.</th>
                                                <th>Product</th>
                                            </tr>
                                            </thead>
                                            <tbody>
{{--                                            @if(count($free_products > 0))--}}
                                                @if(!empty($free_products->free_product_id))
                                                @foreach($free_products as $key => $free_product)
                                                    <tr>
                                                        <td>{{$key+1}}</td>
{{--                                                        @php--}}
{{--                                                        $fee_product_name = \Illuminate\Support\Facades\DB::table('free_product_sale_details')--}}
{{--                                                        ->join('free_products','free_products.id','=','free_product_sale_details.free_product_id')--}}
{{--                                                        ->where('free_product_sale_details.product_sale_id',$productSale->id)--}}
{{--                                                        ->select('free_products.name')--}}
{{--                                                        ->get();--}}
{{--                                                       // dd($fee_product_name);--}}

{{--                                                        @endphp--}}
                                                        <td width="50%"> {{$free_product->freeProduct->name}}</td>
                                                    </tr>

                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                <div class="write">
                                    <p class="lead"><b>In Word : {{ucwords($digit->format($totalAmount))}} Only</b></p>
                                </div>
{{--                                <div class="row">--}}
{{--                                    <!-- accepted payments column -->--}}
{{--                                    <div class="col-6">--}}
{{--                                        <p class="lead">Payment Type:</p>--}}
{{--                                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">--}}
{{--                                        @if(!empty($transactions))--}}
{{--                                            <ul>--}}
{{--                                                <td>{{$transactions->payment_type ? 'cash' : 'check' }}</td>--}}
{{--                                                @foreach($transactions as $transaction)--}}
{{--                                                    <li>--}}
{{--                                                        {{$transaction->payment_type}}--}}
{{--                                                        @if($transaction->payment_type == 'Check')--}}
{{--                                                            ( Check Number: {{$transaction->check_number}} )--}}
{{--                                                        @endif--}}
{{--                                                        :--}}
{{--                                                        Tk.{{$transaction->amount}} ({{$transaction->created_at}})--}}
{{--                                                    </li>--}}
{{--                                                @endforeach--}}
{{--                                            </ul>--}}

{{--                                            @endif--}}
{{--                                            </p>--}}
{{--                                    </div>--}}
{{--                                <!-- /.col -->--}}
{{--                                </div>--}}
                                <!-- /.row -->
                                <!-- this row will not appear when printing -->
                                <div class="row no-print">
                                    <div class="col-12">
                                        <a href="{{route('productSales-invoice-print',$productSale->id)}}" target="_blank" class="btn btn-success float-right"><i class="fas fa-print"></i> Print</a>
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


