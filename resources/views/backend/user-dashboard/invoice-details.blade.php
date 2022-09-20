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
                <div class="">
                    <h1 class="c-font-uppercase c-font-sbold c" style="text-align: center;color: white">Order Tracking</h1>
                </div>
            </div>
        </div><!-- END: LAYOUT/BREADCRUMBS/BREADCRUMBS-2 -->
        <div class="container">
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
                                <tr>
                                    <th>Id</th>
                                    <th>Invoice Number</th>
                                    <th>Product Name</th>
                                    <th>Brand Name</th>
                                    <th>QTY</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                    <th>Services</th>
                                </tr>
                                @foreach($productSales as $key => $productdetail)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$productdetail->invoice_no}}</td>
{{--                                        <td>{{$productdetail->total_amount}}</td>--}}
                                        <td>@php
                                            $products = DB::table('product_sales')
                                                ->join('product_sale_details', 'product_sales.id', '=', 'product_sale_details.product_sale_id')
                                                ->join('products', 'products.id', '=', 'product_sale_details.product_id')
                                                ->join('product_brands', 'product_brands.id', '=', 'product_sale_details.product_brand_id')
                                                ->where('product_sale_details.product_sale_id', $productdetail->id)
                                                ->select('products.id','products.name')
                                                ->first();
                                        @endphp
                                        {{$products->name}}</td>
                                      <td>@php
                                              $brands = DB::table('product_sales')
                                                  ->join('product_sale_details', 'product_sales.id', '=', 'product_sale_details.product_sale_id')
                                                  ->join('product_brands', 'product_brands.id', '=', 'product_sale_details.product_brand_id')
                                                  ->where('product_sale_details.product_sale_id', $productdetail->id)
                                                  ->select('product_brands.name')
                                                  ->first();
//dd($brands)
                                          @endphp
                                          {{$brands->name}}</td>
                                        @php
                                            $productdetails = DB::table('product_sales')
                                                ->join('product_sale_details', 'product_sales.id', '=', 'product_sale_details.product_sale_id')
                                                ->where('product_sale_details.product_sale_id', $productdetail->id)
                                                ->select('product_sale_details.qty','product_sale_details.price','product_sale_details.sub_total')
                                                ->first();
//dd($productdetail)
                                        @endphp
                                        <td>{{$productdetails->qty}}</td>
                                        <td>{{$productdetails->price}}</td>
                                        <td>{{$productdetails->sub_total}}</td>
                                        <td>@php
                                                //$saleService =  DB::table('product_sales')
                                                  //->join('product_sale_details', 'product_sales.id', '=', 'product_sale_details.product_sale_id')
                                                  //->join('sale_services', 'sale_services.product_sale_detail_id', '=', 'product_sale_details.id')
                                                 //->where('product_sale_details.product_sale_id', $productdetail->id)
                                                 // ->select('product_brands.name')
                                                  //->get();
                                        $Services = DB::table('services')
                                                     ->join('sale_services','sale_services.service_id','=','services.id')
                                                     ->join('product_sale_details','product_sale_details.id','=','sale_services.product_sale_detail_id')
                                                     //->join('product_sales','product_sale_details.product_sale_id','=','product_sales.id')
                                                    ->where('product_sale_details.product_sale_id', $productdetail->id)
                                                   //->select('services.id','services.name')
                                                    ->get();
   // dd(Services)
                                            @endphp
                                       @foreach($Services as $service)
                                           <ul>
                                               <li>  {{$service->name}}</li>
                                           </ul>

                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
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
