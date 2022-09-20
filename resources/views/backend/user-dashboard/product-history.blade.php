@extends('backend.user-dashboard.master')
@section('title','Product History')
@push('css')

    <style>
        .cards{
            /*border-radius: 21%;*/
            padding: 3%;
            width: 22%;
        }
        .row{
            border-radius: 14px;
        }
        .text-white{
            color: #FFFFFF!important;
        }
        .bg-dark{
            background-color: #1c2d3f;
        }
        .bg-primary{
            background-color: #0f3e68;
        }
        .bg-warning{
            background-color: #8d2d5e;
        }
        @media only screen and (min-width: 992px) {
            .c-layout-header-fixed .c-layout-page{
                margin-top: 0px!important;
            }
        }
        @media only screen and (max-width: 700px) {
            .cards{
                margin-left:20px!important;
            }
            .c-layout-header-fixed .c-layout-page{
                margin-top: 0px!important;
            }
        }
        .table td {
            font-size: 20px!important;
            font-weight: 400!important;
        }
        .table th {
            font-size: 20px!important;
            //font-weight: 500!important;
        }
    </style>
@endpush
@section('content')
    <!-- BEGIN: PAGE CONTAINER -->
    <div class="c-layout-page">
        <!-- BEGIN: LAYOUT/BREADCRUMBS/BREADCRUMBS-2 -->
        <div class="c-layout-breadcrumbs-1 c-subtitle c-fonts-uppercase c-fonts-bold c-bordered c-bordered-both">
            <div class="container">
                <div class="c-page-title c-pull-left">
                    <h3 class="c-font-uppercase c-font-sbold">Order History</h3>
                </div>
                <ul class="c-page-breadcrumbs c-theme-nav c-pull-right c-fonts-regular">
                    <li>Order History</li>
                </ul>
            </div>
        </div><!-- END: LAYOUT/BREADCRUMBS/BREADCRUMBS-2 -->
        <div class="container">
            <div class="c-layout-sidebar-menu c-theme ">
                <!-- BEGIN: LAYOUT/SIDEBARS/SHOP-SIDEBAR-DASHBOARD -->
                <div class="c-sidebar-menu-toggler">
                    <h3 class="c-title c-font-uppercase c-font-bold">My Profile</h3>
                    <a href="javascript:;" class="c-content-toggler" data-toggle="collapse" data-target="#sidebar-menu-1">
                        <span class="c-line"></span> <span class="c-line"></span> <span class="c-line"></span>
                    </a>
                </div>

                @include('backend.user-dashboard.sidebar')
            </div>
            <div class="c-layout-sidebar-content ">
                <!-- BEGIN: PAGE CONTENT -->
                <!-- BEGIN: CONTENT/SHOPS/SHOP-ORDER-HISTORY -->
                <div class="c-content-title-1">
                    <h3 class="c-font-uppercase c-font-bold">Product Order History</h3>
                    <div class="c-line-left"></div>
                </div>
                <div class="row c-margin-b-40">
                    <div class="c-content-product-2 c-bg-white">
                        <div class="c-content-product c-bg-gray table-responsive">
                            <table class="table table-bordered table-condensed table-hover  table-striped" style="width: 98%">
                                <tr style="background-color: grey">
                                    <th>Id</th>
                                    <th>Invoice No</th>
                                    <th>Date & Time</th>
{{--                                    <th>Product Name</th>--}}
{{--                                    <th>QTY</th>--}}
{{--                                    <th> Unit Price BDT</th>--}}
{{--                                    <th> Total Amount</th>--}}
{{--                                    <th> Vat</th>--}}
{{--                                    <th> Discount</th>--}}
{{--                                    <th> Final Amount</th>--}}
{{--                                    <th> Paid Amount</th>--}}
{{--                                    <th> Due Amount</th>--}}
                                    <th> Details</th>
                                </tr>
                                @forelse($productHistory as $key => $productHist)
                                    <tr style="background-color: papayawhip">
                                        <td>{{$key + 1}}</td>
                                        <td>{{$productHist->invoice_no}}</td>
                                        <td>{{$productHist->created_at}}</td>

{{--                                        <td> @php--}}
{{--                                                $product_sub_total = DB::table('product_sale_details')--}}
{{--                                                   ->join('product_sales', 'product_sales.id', '=', 'product_sale_details.product_sale_id')--}}
{{--                                                   //->join('products', 'products.id', '=', 'product_sale_details.product_id')--}}
{{--                                                   ->where('product_sale_details.product_sale_id', $productHist->id)--}}
{{--                                                   ->select('product_sale_details.sub_total')--}}
{{--                                                   ->get();--}}
{{--//$sub_total = $product_sub_total->sub_total;--}}
{{--                                       //dd($details);--}}
{{--                                            @endphp--}}
{{--                                            @foreach($product_sub_total as $key => $sub_total)<ul style="list-style: none">--}}
{{--                                                <li>{{$sub_total->sub_total}}</li>--}}
{{--                                            </ul>--}}
{{--                                            @endforeach</td>--}}
{{--                                        <td>{{$productHist->vat_amount}}%</td>--}}
{{--                                        <td>{{$productHist->total_amount}}</td>--}}
{{--                                        <td>{{$productHist->paid_amount}}</td>--}}
{{--                                        <td>{{$productHist->due_amount}}</td>--}}
                                        <td> <a href="{{route('product.details',$productHist->id)}}">
                                                <i class="fa fa-shopping-cart"></i>
                                            </a></td>

                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <h1 class="text-danger">Empty Order History!</h1>
                                        </td>
                                    </tr>
                                @endforelse
                            </table>
{{--                            <table class="table table-bordered table-condensed table-hover  table-striped" style="width: 60%">--}}
{{--                                <tr>--}}
{{--                                    <th style="text-align: center">Date</th>--}}
{{--                                    <th style="text-align: center">Service name</th>--}}
{{--                                    <th style="text-align: center">Product name</th>--}}
{{--                                </tr>--}}
{{--                                    <tr>--}}
{{--                                        @php--}}
{{--                                            $saleServices = DB::table('services')--}}
{{--                                            ->join('sale_services','sale_services.service_id','=','services.id')--}}
{{--                                            ->join('product_sale_details','product_sale_details.id','=','sale_services.product_sale_detail_id')--}}
{{--                                            ->where('product_sale_details.product_sale_id', $productHist->id)--}}
{{--                                            ->select('services.id','services.name')--}}
{{--                                            ->get();--}}

{{--                                            $saleServiceDates = DB::table('sale_services')--}}
{{--                                            //->join('sale_services','sale_services.service_id','=','services.id')--}}
{{--                                            ->join('product_sale_details','product_sale_details.id','=','sale_services.product_sale_detail_id')--}}
{{--                                            ->where('product_sale_details.product_sale_id', $productHist->id)--}}
{{--                                            ->select('sale_services.date')--}}
{{--                                            ->orderBy('sale_services.date','ASC')--}}
{{--                                            ->get();--}}
{{--                                            //dd($saleServiceDates);--}}
{{--                                        @endphp--}}
{{--                                        <td>@foreach($saleServiceDates as $key => $date)--}}
{{--                                            <ul >--}}

{{--                                                <li> {{$date->date}}</li>--}}
{{--                                            </ul>--}}
{{--                                            @endforeach--}}
{{--                                        </td>--}}
{{--                                        <td>  @foreach($saleServices as $key => $saleService)<ul >--}}
{{--                                                <li>{{$saleService->name}}</li>--}}
{{--                                            </ul>--}}
{{--                                            @endforeach</td>--}}

{{--                                            @php--}}
{{--                                        $products = DB::table('product_sales')--}}
{{--                                        ->join('product_sale_details', 'product_sales.id', '=', 'product_sale_details.product_sale_id')--}}
{{--                                        ->join('products', 'products.id', '=', 'product_sale_details.product_id')--}}
{{--                                        ->where('product_sale_details.product_sale_id', $productHist->id)--}}
{{--                                        ->select('products.id','products.name')--}}
{{--                                        ->get();--}}
{{--                                        //$products_name = $products->name;--}}
{{--                                        //dd($products_name);--}}
{{--                                            @endphp--}}
{{--                                        <td> @foreach($products as $key => $product)<ul >--}}
{{--                                                <li>{{$product->name}}</li>--}}
{{--                                            </ul>--}}
{{--                                            @endforeach</td>--}}

{{--                                    </tr>--}}

{{--                            </table>--}}
                        </div>
                    </div>
                </div>

                <!-- END: CONTENT/SHOPS/SHOP-ORDER-HISTORY -->
                <!-- END: PAGE CONTENT -->
            </div>
        </div>
    </div>

@stop
@push('js')

@endpush
