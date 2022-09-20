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
            tr td{
                width: 30%!important;
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
                            <table class="table table-bordered table-condensed table-hover  table-striped" style="width: 100%">
                                <tr style="background-color: grey">
                                    <th>Id</th>
                                    <th>Product Name</th>
                                    <th>Product Brand</th>
                                    <th width="30%">Warranty</th>
                                    <th>QTY</th>
{{--                                    <th> Price</th>--}}
{{--                                    <th> Total Amount</th>--}}
                                    <th> Services</th>
                                </tr>


                                @foreach($productHistory->productsaledetails()->get() as $key => $productdetail)
                                    <tr style="background-color: papayawhip">
                                       <td>{{$key+1}}</td>
                                       <td>{{$productdetail->product->name}}</td>
                                       <td>{{$productdetail->product_brand->name}}</td>
                                       <td width="30%">{{$productdetail->product->warranty}}</td>
                                       <td>{{$productdetail->qty}}</td>
{{--                                       <td>{{$productdetail->price}}</td>--}}
{{--                                       <td>{{$productdetail->sub_total}}</td>--}}
                                       <td width="20%"> <a href="{{route('service.list',$productdetail->id)}}" class="btn btn-sm btn-primary float-left" style="margin-left: 5px">service list</a></td>
                                   </tr>
                                @endforeach

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
