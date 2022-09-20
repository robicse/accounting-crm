@extends('backend._partial.dashboard')

<style>
    @media only screen and (max-width: 600px) {
    .mobile{
        margin-top: 10px;
    }
    }
</style>
@section('content')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="">Dashboard</a></li>
            </ul>

        </div>
{{--        @php--}}
{{--            echo '<pre>';--}}
{{--             print_r(Auth::User()->getRoleNames()[0]);--}}
{{--            echo '</pre>';--}}
{{--        @endphp--}}
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Quick Create</h1>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary" style="min-height:95px ">
                                <div class="inner">
                                    <h3 style="text-align: center;padding-top: 30px"><a href="{{route('party.create')}}" style="color: white">Customer</a></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary" style="min-height:95px ">
                                <div class="inner">
                                    <h3 style="text-align: center;padding-top: 30px"><a href="{!! URL::to('/supplier') !!}" style="color: white">Supplier</a></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary mobile" style="min-height:95px ">
                                <div class="inner">
                                    <h3 style="text-align: center;padding-top: 30px"><a href="{{route('productPurchases.create')}}" style="color: white">Stock In</a></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6" >
                            <!-- small box -->
                            <div class="small-box bg-primary mobile" style="min-height:95px ">
                                <div class="inner">
                                    <h3 style="text-align: center;padding-top: 30px"><a href="{{route('productSales.create')}}" style="color: white">Retail Sale</a></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6" style="margin-top:10px">
                            <!-- small box -->
                            <div class="small-box bg-primary mobile" style="min-height:95px ">
                                <div class="inner">
                                    <h3 style="text-align: center;padding-top: 30px"><a href="{{route('productWholeSales.create')}}" style="color: white">Whole Sale</a></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6" style="margin-top:10px" >
                            <!-- small box -->
                            <div class="small-box bg-primary" style="min-height:95px ">
                                <div class="inner">
                                    <h3 style="text-align: center;padding-top: 30px"><a href="{{route('monthly.services')}}" style="color: white">Monthly Service</a></h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6" style="margin-top:10px">
                            <!-- small box -->
                            <div class="small-box bg-primary" style="min-height:95px ">
                                <div class="inner">
                                    <h3 style="text-align: center;padding-top: 30px"><a href="{{route('products.create')}}" style="color: white">Product</a> </h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6" style="margin-top:10px">
                            <!-- small box -->
                            <div class="small-box bg-primary" style="min-height:95px ">
                                <div class="inner">
                                    <h3 style="text-align: center;padding-top: 30px"><a href="{{route('customer_complain.create')}}" style="color: white">Customer Support</a></h3>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-3 col-6" style="margin-top:10px" >
                            <!-- small box -->
                            <div class="small-box bg-primary" style="min-height:95px ">
                                <div class="inner">
                                    <h3 style="text-align: center;padding-top: 30px"><a href="{{route('Ledger.create')}}" style="color: white">Create Ledger</a></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6" style="margin-top:10px">
                            <!-- small box -->
                            <div class="small-box bg-primary" style="min-height:95px ">
                                <div class="inner">
                                    <h3 style="text-align: center;padding-top: 30px"><a href="{{route('postingForm.create')}}" style="color: white">Voucher Posting</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @php
            //echo '<pre>';
            //print_r(Auth::User()->getRoleNames()[0]);
            //echo '</pre>';
            @endphp
            @if(Auth::User()->getRoleNames()[0] == "Admin")
            <div class="col-md-12">
                <h1 class="text-center">All Branch</h1>
            </div>
            @php

                @endphp
            <div class="col-md-6 col-lg-4">
                <div class="widget-small danger coloured-icon" ><i class="icon fa fa-users fa-3x"></i>
                    <div class="info">
                        <h4><a href="{{route('party.index')}}"> Total Customer</a></h4>
                        <p><b>{{$customer}} </b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small danger coloured-icon" ><i class="icon fa fa-users fa-3x"></i>
                    <div class="info">
                        <h4> Total Service Executive</h4>
                        <p><b>{{$servise_executive}}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small danger coloured-icon" ><i class="icon fa fa-users fa-3x"></i>
                    <div class="info">
                        <h4> Total Service Providers</h4>
                        <p><b>{{$service_provider}}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="widget-small danger coloured-icon"><i class="icon fa fa-shopping-basket "></i>
                    <div class="info">
                        <a href="{{route('products.index')}}"><h4>Total Products</h4></a>
                        <p><b>{{$product}}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="widget-small danger coloured-icon"><i class="icon fa fa-shopping-basket "></i>
                    <div class="info">
                        <a href="{{route('service.index')}}"></a><h4>Total Services</h4>
                        <p><b>{{$service}}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="widget-small danger coloured-icon"><i class="icon fa fa-shopping-basket "></i>
                    <div class="info">
                        <a href="{{route('offers.index')}}"><h4>Offers</h4></a>
                        <p><b>{{$offers}}</b></p>
                    </div>
                </div>
            </div>
                <div class="col-md-4">
                <div class="widget-small danger coloured-icon"><i class="icon fa fa-shopping-basket "></i>
                    <div class="info">
                        <a href="{{route('monthly.services')}}"><h4>Total Monthly Service</h4></a>
                        <p style="color: red;font-size: 26px">{{$saleServices}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @if(!empty($stores))
                @foreach($stores as $store)
                    <div class="col-md-12">
                        <h1 class="text-center">{{$store->name}}</h1>
                    </div>

                    @php
                        $sum_purchase_price = 0;
                        $sum_sale_price = 0;
                        $sum_sale_return_price = 0;
                        //$sum_production_price = 0;
                        //$sum_profit_amount = 0;
                        //$sum_loss_amount = 0;
                       // $sum_discount_amount = 0;
                        $sum_loss_or_profit = 0;
                        $current_loss_or_profit = 0;

                    $productPurchaseDetails = DB::table('product_purchase_details')
                                    ->join('product_purchases','product_purchases.id','=','product_purchase_details.product_purchase_id')
                                    ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'), DB::raw('SUM(sub_total) as sub_total'))
                                    ->where('product_purchases.store_id',$store->id)
                                    ->groupBy('product_id')
                                    ->groupBy('product_category_id')
                                    ->groupBy('product_sub_category_id')
                                    ->groupBy('product_brand_id')
                                    ->get();

                                if(!empty($productPurchaseDetails)){
                                    foreach($productPurchaseDetails as $key => $productPurchaseDetail){
                                        $purchase_average_price = $productPurchaseDetail->sub_total/$productPurchaseDetail->qty;
                                        //dd($purchase_average_price);
                                        $sum_purchase_price += $productPurchaseDetail->sub_total;

                                        // sale
                                        $productSaleDetails = DB::table('product_sale_details')
                                            ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'), DB::raw('SUM(sub_total) as sub_total'))
                                            ->where('product_id',$productPurchaseDetail->product_id)
                                            ->where('product_category_id',$productPurchaseDetail->product_category_id)
                                            ->where('product_sub_category_id',$productPurchaseDetail->product_sub_category_id)
                                            ->where('product_brand_id',$productPurchaseDetail->product_brand_id)
                                            ->groupBy('product_id')
                                            ->groupBy('product_category_id')
                                            ->groupBy('product_sub_category_id')
                                            ->groupBy('product_brand_id')
                                            ->first();

                                        if(!empty($productSaleDetails))
                                        {
                                            $sale_total_qty = $productSaleDetails->qty;
                                            $sum_sale_price += $productSaleDetails->sub_total;
                                            $sale_average_price = $productSaleDetails->sub_total/$productSaleDetails->qty;

                                            if($sale_total_qty > 0){
                                                $loss_or_profit = ($sale_average_price*$sale_total_qty) - ($purchase_average_price*$sale_total_qty);
                                                $current_loss_or_profit += $loss_or_profit;
                                                $sum_loss_or_profit += $loss_or_profit;
                                            }
                                        }


                                        // sale return

                                        $productSaleReturnDetails = DB::table('product_sale_return_details')
                                            ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'))
                                            ->where('product_id',$productPurchaseDetail->product_id)
                                            ->where('product_category_id',$productPurchaseDetail->product_category_id)
                                            ->where('product_sub_category_id',$productPurchaseDetail->product_sub_category_id)
                                            ->where('product_brand_id',$productPurchaseDetail->product_brand_id)
                                            ->groupBy('product_id')
                                            ->groupBy('product_category_id')
                                            ->groupBy('product_sub_category_id')
                                            ->groupBy('product_brand_id')
                                            ->first();

                                        if(!empty($productSaleReturnDetails))
                                        {
                                            $sale_return_total_qty = $productSaleReturnDetails->qty;
                                            $sale_return_total_amount = $productSaleReturnDetails->price;
                                            $sum_sale_return_price += $productSaleReturnDetails->price;
                                            $sale_return_average_price = $sale_return_total_amount/$productSaleReturnDetails->qty;

                                            if($sale_return_total_qty > 0){
                                                $amount = $sale_return_average_price - ($purchase_average_price*$sale_return_total_qty);
                                                if($amount > 0){
                                                    $sum_loss_or_profit -= $amount;
                                                }else{
                                                    $sum_loss_or_profit += $amount;
                                                }
                                            }
                                        }


                                    }

                                    $discount= DB::table('product_sales')
                                            ->where('product_sales.store_id',$store->id)
                                            ->select( DB::raw('SUM(discount_amount) as total_discount_amount'))
                                            ->first();
                                    //dd($discount);
                                    if($discount){
                                        $sum_loss_or_profit -=$discount->total_discount_amount;
                                        $discount_amount = $discount->total_discount_amount;
                                        $sum_sale_price_discount = $sum_sale_price-$discount_amount;
                                    }
                                }
                                 $productSale_amount = 0;
                                 $productSaleReturn_amount = 0;
                                 $productPurchaseReturn_amount = 0;


                                 $productSales =DB::table('product_sales')
                                            ->where('store_id',$store->id)
                                            ->select('product_sales.total_amount','product_sales.transport_cost')
                                            ->get();
                                 foreach ($productSales as $productSale)
                                 $productSale_amount += ($productSale->total_amount+$productSale->transport_cost);

                                $productSalesReturns =DB::table('product_sale_returns')
                                            ->where('store_id',$store->id)
                                            ->select('product_sale_returns.total_amount')
                                            ->get();
                                 foreach ($productSalesReturns as $productSalesReturn)
                                 $productSaleReturn_amount += $productSalesReturn->total_amount;

                                 $productPurchaseReturns =DB::table('product_purchase_returns')
                                            ->where('store_id',$store->id)
                                            ->select('product_purchase_returns.total_amount')
                                            ->get();
                                 foreach ($productPurchaseReturns as $productPurchaseReturn)
                                 $productPurchaseReturn_amount += $productPurchaseReturn->total_amount;
    //dd($productPurchaseReturn_amount);

                    @endphp

                    <div class="col-md-4">
                        <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                            <div class="info">
                                <h4>Total Purchase</h4>
                                <p><b>{{number_format($sum_purchase_price, 2, '.', '')}}</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="widget-small danger coloured-icon"><i class="icon fas fa-money-check-alt "></i>
                            <div class="info">
                                <h4>Total Sell</h4>
{{--                                <p><b>{{number_format($sum_sale_price, 2, '.', '')}}</b></p>--}}
                                <p><b>{{number_format($productSale_amount, 2, '.', '')}}</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="widget-small danger coloured-icon"><i class="icon fas fa-money-check-alt "></i>
                            <div class="info">
                                <h4>Total Purchase Return</h4>
{{--                                <p><b>{{number_format($sum_sale_price, 2, '.', '')}}</b></p>--}}
                                <p><b>{{number_format($productPurchaseReturn_amount, 2, '.', '')}}</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="widget-small danger coloured-icon"><i class="icon fas fa-money-check-alt "></i>
                            <div class="info">
                                <h4>Total Sell Return</h4>
{{--                                <p><b>{{number_format($sum_sale_price, 2, '.', '')}}</b></p>--}}
                                <p><b>{{number_format($productSaleReturn_amount, 2, '.', '')}}</b></p>
                            </div>
                        </div>
                    </div>
{{--                    <div class="col-md-3">--}}
{{--                        <div class="widget-small danger coloured-icon"><i class="icon fa fa-sort-amount-asc"></i>--}}
{{--                            <div class="info">--}}
{{--                                <h4>FINAL LOSS/PROFIT</h4>--}}
{{--                                <p><b>{{number_format($sum_sale_price, 2, '.', '')}}</b></p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                @endforeach
            @endif
        </div>

        @else
            <h1>
                Only Admin can show At a Glance! User can only Sale permission.
                <a href="{!! route('productSales.create') !!}" class="btn btn-sm btn-primary" type="button">Add Product Sales</a>
            </h1>
        @endif
    </main>
@endsection


@section('footer')

@endsection
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    // Swal.fire({
    //     title: 'Custom animation with Animate.css',
    //     showClass: {
    //         popup: 'animate__animated animate__fadeInDown'
    //     },
    //     hideClass: {
    //         popup: 'animate__animated animate__fadeOutUp'
    //     }
    // })
    //sweet alert
    function deletePost() {
        swal("Here's the title!", "...and here's the text!");
    }
</script>
