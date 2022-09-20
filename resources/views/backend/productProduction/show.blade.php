@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Product Productions And Details</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('productProductions.index') !!}" class="btn btn-sm btn-primary" type="button">Back</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
{{--                <ul class="app-breadcrumb breadcrumb">--}}
{{--                    <li class="breadcrumb-item" style="margin-left: 88%"> <a href="{!! route('productProductions-invoice',$productProduction->id) !!}" class="btn btn-sm btn-primary"  type="button">Print Invoice Page</a></li>--}}
{{--                </ul>--}}
                <h3 class="tile-title">Product Productions</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>User</th>
                            <td>{{$productProduction->user->name}}</td>
                        </tr>
                        <tr>
                            <th>Store</th>
                            <td>{{$productProduction->store->name}}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{$productProduction->date}}</td>
                        </tr>
                        <tr>
                            <th>Total Costing Amount</th>
                            <td>{{$productProduction->total_amount}}</td>
                        </tr>
    {{--                    <tr>--}}
    {{--                        <th>Paid Amount</th>--}}
    {{--                        <td>{{$productProduction->paid_amount}}</td>--}}
    {{--                    </tr>--}}
    {{--                    <tr>--}}
    {{--                        <th>Due Amount</th>--}}
    {{--                        <td>{{$productProduction->due_amount}}</td>--}}
    {{--                    </tr>--}}
                        </tbody>
                    </table>
                    <div class="tile-footer">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Product Productions Details</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Category</th>
{{--                        <th>Sub Category</th>--}}
                        <th>Brand</th>
                        <th>Product Image</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Costing Price</th>
                        <th>Sub Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($productProductionDetails as $productProductionDetail)
                        <tr>
                            <td>{{$productProductionDetail->product->product_category->name}}</td>
{{--                            <td>--}}
{{--                                {{$productProductionDetail->product->product_sub_category ? $productProductionDetail->product->product_sub_category->name : ''}}--}}
{{--                            </td>--}}
                            <td>{{$productProductionDetail->product->product_brand->name}}</td>
                            <td>
                                <img src="{{asset('uploads/product/'.$productProductionDetail->product->image)}}" width="50" height="50" />
                            </td>
                            <td>{{$productProductionDetail->product->name}}</td>
                            <td>{{$productProductionDetail->qty}}</td>
                            <td>{{$productProductionDetail->price}}</td>
                            <td>{{$productProductionDetail->sub_total}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
{{--                <div class="tile-footer">--}}
{{--                    <ul class="app-breadcrumb breadcrumb">--}}
{{--                        <li class="breadcrumb-item" style="margin-left: 83%"> <a href="{!! route('productProductions-invoice-edit',$productProduction->id) !!}" class="btn btn-sm btn-success"  type="button">Print Invoice Edit Page</a></li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
            </div>
        </div>

        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Product Finish Good Details</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Product Image</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>M.R.P Price</th>
                        <th>Sub Total</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$productPurchaseDetail->product->product_category->name}}</td>
                            <td>{{$productPurchaseDetail->product->product_brand->name}}</td>
                            <td>
                                <img src="{{asset('uploads/product/'.$productPurchaseDetail->product->image)}}" width="50" height="50" />
                            </td>
                            <td>{{$productPurchaseDetail->product->name}}</td>
                            <td>{{$productPurchaseDetail->qty}}</td>
                            <td>{{$productPurchaseDetail->price}}</td>
                            <td>{{$productPurchaseDetail->mrp_price}}</td>
                            <td>{{$productPurchaseDetail->sub_total}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection


