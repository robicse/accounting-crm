@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Product Purchases And Details</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('productPurchases.index') !!}" class="btn btn-sm btn-primary" type="button">Back</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                {{--<ul class="app-breadcrumb breadcrumb">
                    <li class="breadcrumb-item" style="margin-left: 90%"> <a href="{!! route('productPurchases-invoice') !!}" class="btn btn-sm btn-primary"  type="button">Download Page</a></li>
                </ul>--}}
                <h3 class="tile-title">Product Purchases</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>User</th>
                            <td>{{$productPurchase->user->name}}</td>
                        </tr>
                        <tr>
                            <th>Store</th>
                            <td>{{$productPurchase->store->name}}</td>
                        </tr>
                        <tr>
                            <th>Party</th>
                            <td>{{$productPurchase->party->name}}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{$productPurchase->date}}</td>
                        </tr>
                        <tr>
                            <th>Payment Type</th>
                            <td>{{$transaction->payment_type}}</td>
                        </tr>
                        @if($transaction->payment_type == 'Check')
                            <tr>
                                <th>Check Number</th>
                                <td>{{$transaction->check_number}}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Amount</th>
                            <td>{{$productPurchase->total_amount}}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="tile-footer">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Product Purchases Details</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Category</th>
{{--                        <th>Sub Category</th>--}}
                        <th>Brand</th>
                        <th>Product Image</th>
                        <th>Product</th>
                        <th>Qty</th>
{{--                        <th>Production</th>--}}
                        <th>Price</th>
                        <th>Sub Total</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($productPurchaseDetails as $productPurchaseDetail)
                            <tr>
                                <td>{{$productPurchaseDetail->product->product_category->name}}</td>
{{--                                <td>--}}
{{--                                    {{$productPurchaseDetail->product->product_sub_category ? $productPurchaseDetail->product->product_sub_category->name : ''}}--}}
{{--                                </td>--}}
                                <td>{{$productPurchaseDetail->product->product_brand->name}}</td>
                                <td>
                                    <img src="{{asset('uploads/product/'.$productPurchaseDetail->product->image)}}" width="50" height="50" />
                                </td>
                                <td>{{$productPurchaseDetail->product->name}}</td>
                                <td>{{$productPurchaseDetail->qty}}</td>
{{--                                <td>{{$productPurchaseDetail->production}}</td>--}}
                                <td>{{$productPurchaseDetail->price}}</td>
                                <td>{{$productPurchaseDetail->sub_total}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="tile-footer">
                </div>
            </div>
        </div>
    </main>
@endsection


