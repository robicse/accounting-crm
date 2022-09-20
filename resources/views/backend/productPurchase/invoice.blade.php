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
<link rel="stylesheet" href="{{asset('backend/plugins/fontawesome-free/css/all.min.css')}}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('backend/dist/css/adminlte.min.css')}}">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@section('content')

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
                                <h2>{{$store->name}}</h2>
                                <p style="margin: 0px">Corporate Office :{{$store->address}}</p>
                                <p style="margin: 0px"><b>Phone</b>: {{$store->phone}} </p>
                                <p style="margin: 0px"> <b>Email</b>: info@cleantech.com.bd</p>
                                <p style="margin: 0px"> <b>Website</b>:www.cleantech.com.bd</p>
                                <p style="margin: 0px"> Find us on www.facebook.com/cleantechbd</p>
                            </div>
                            <!-- Main content -->
                            <div class="invoice p-3 mb-3">
                                <div class=" callout-info">
                                    <h5 style="text-align: center;padding: 20px;width: 100%;background-color: grey">Purchase Invoice</h5>
                                </div>
                                <!-- info row -->
                                <div class="row invoice-info">
                                    <div class="col-md-8 invoice-col">
                                        <address>
                                            <strong>Supplier Name:</strong>
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
                                                    <td style="text-align: right;font-size: 16px;">{{$productPurchase->invoice_no}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right;font-size: 16px;">Sale Date:</td>
                                                    <td style="text-align: right;font-size: 16px;">{{$party->created_at->format('d/m/Y')}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right;font-size: 16px;">Served By:</td>
                                                    <td style="text-align: right;font-size: 16px;">{{$productPurchase->user->name}}</td>
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
                                                <th>Unit</th>
                                                <th>Unit Price BDT</th>
                                                <th>Amount BDT</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $sum_sub_total = 0;
                                            @endphp
                                            @foreach($productPurchaseDetails as $key =>$productPurchaseDetail)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$productPurchaseDetail->product->name}}</td>
                                                    <td>{{$productPurchaseDetail->qty}}</td>
                                                    <td>{{$productPurchaseDetail->product_unit->name}}</td>
                                                    <td>{{$productPurchaseDetail->price}}</td>
                                                    <td>
                                                        @php
                                                            $sub_total=$productPurchaseDetail->qty*$productPurchaseDetail->price;
                                                            $sum_sub_total += $sub_total;
                                                            $total_discount = (($sum_sub_total+$productPurchase->transport_cost)*$productPurchase->discount_amount)/100;
                                                          //  dd($sum_sub_total);
                                                        @endphp
                                                        {{$sub_total}}
                                                    </td>
                                                </tr>

                                            @endforeach
                                            <tr>
                                                <th colspan="4">&nbsp;</th>
                                                <th>Subtotal:</th>
                                                <th>{{$sum_sub_total}}</th>
                                            </tr>


                                            <tr>
                                                <th colspan="4">&nbsp;</th>
                                                <th>Transport/Labour :</th>
                                                <th>{{$productPurchase->transport_cost}}</th>
                                            </tr>
                                            <tr>
                                                <th colspan="4">&nbsp;</th>
                                                <th>Discount:</th>
                                                @if($productPurchase->discount_type == 'flat' )

                                                    <td style="border: none">- {{$productPurchase->discount_amount}}</td>
                                                @else
                                                    <td style="border: none">-{{number_format($total_discount, 2, '.', '')}}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th colspan="4">&nbsp;</th>
                                                <th>Total Amount</th>
                                                <th>{{$productPurchase->total_amount}}</th>
                                            </tr>
                                            <tr>
                                                <th colspan="4">&nbsp;</th>
                                                <th>Paid Amount:</th>
                                                <th>{{$productPurchase->paid_amount}}</th>
                                            </tr>
                                            <tr>
                                                <th colspan="4">&nbsp;</th>
                                                <th>Due Amount:</th>
                                                <th>{{$productPurchase->due_amount}}</th>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                <div class="write">
                                    @php
                                        $get_amount= numberTowords($productPurchase->total_amount);
                                           // echo "<p align='center' class='text-danger'>".$get_amount."</p>";
                                                echo   "<p class='lead'>" ."In Word :" .$get_amount. "Only" ."</p>";
                                    @endphp
{{--                                    <p class="lead"><b>In Word : {{ucwords($digit->format($productPurchase->total_amount))}} Only</b></p>--}}
                                    <?php
                                    // Create a function for converting the amount in words
                                    function numberTowords(float $amount)
                                    {
                                        $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
                                        // Check if there is any number after decimal
                                        $amt_hundred = null;
                                        $count_length = strlen($num);
                                        $x = 0;
                                        $string = array();
                                        $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
                                            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
                                            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
                                            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
                                            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
                                            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
                                            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
                                            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
                                            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
                                        $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
                                        while( $x < $count_length ) {
                                            $get_divider = ($x == 2) ? 10 : 100;
                                            $amount = floor($num % $get_divider);
                                            $num = floor($num / $get_divider);
                                            $x += $get_divider == 10 ? 1 : 2;
                                            if ($amount) {
                                                $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
                                                $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
                                                $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.'
         '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. '
         '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
                                            }else $string[] = null;
                                        }
                                        $implode_to_Rupees = implode('', array_reverse($string));
                                        $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . "
   " . $change_words[$amount_after_decimal % 10]) . ' Paisa' : '';
                                        return ($implode_to_Rupees ? $implode_to_Rupees . 'Taka ' : '') . $get_paise;
                                    }

                                    ?>
                                </div>


                            </div>
                            <!-- /.row -->
                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-12">
                                    <a href="{{route('productPurchases-invoice-print',$productPurchase->id)}}" target="_blank" class="btn btn-success float-right"><i class="fas fa-print"></i> Print</a>

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


