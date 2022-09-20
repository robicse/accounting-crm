@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Product Sales Return And Details</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('productSaleReturns.index') !!}" class="btn btn-sm btn-primary" type="button">Back</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Product Sales Returns</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>Invoice NO</th>
                            <td>{{$productSaleReturn->invoice_no}}</td>
                        </tr>
                        <tr>
                            <th>User</th>
                            <td>{{$productSaleReturn->user->name}}</td>
                        </tr>
                        <tr>
                            <th>Store</th>
                            <td>{{$productSaleReturn->store->name}}</td>
                        </tr>
                        <tr>
                            <th>Party</th>
                            <td>{{$productSaleReturn->party->name}}</td>
                        </tr>
                        <tr>
                            <th>Payment Type</th>
                            <td>
                                @php
                                    echo $payment_type = \Illuminate\Support\Facades\DB::table('transactions')
                                  ->where('ref_id',$productSaleReturn->id)->pluck('payment_type')->first();
                                @endphp
                            </td>
                        </tr>
                        <tr>
                            <th>Discount Type</th>
                            <td>{{$productSaleReturn->discount_type}}</td>
                        </tr>
                        <tr>
                            <th>Discount Amount</th>
                            <td>{{$productSaleReturn->discount_amount}}</td>
                        </tr>
                        <tr>
                            <th>Amount</th>
                            <td>{{$productSaleReturn->total_amount}}</td>
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
                <h3 class="tile-title">Product Sales Details</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Category</th>
{{--                        <th>Sub Category</th>--}}
                        <th>Brand</th>
{{--                        <th>Return Condition</th>--}}
                        <th>Reason</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($productSaleReturnDetails as $productSaleReturnDetail)
                        <tr>
                            <td>{{$productSaleReturnDetail->product->product_category->name}}</td>
{{--                            <td>--}}
{{--                                {{$productSaleReturnDetail->product->product_sub_category ? $productSaleReturnDetail->product->product_sub_category->name : ''}}--}}
{{--                            </td>--}}
                            <td>{{$productSaleReturnDetail->product->product_brand->name}}</td>
{{--                            <td>{{$productSaleReturnDetail->return_type}}</td>--}}
                            <td>{{$productSaleReturnDetail->reason}}</td>
{{--                            <td>--}}
{{--                                <img src="{{asset('uploads/product/'.$productSaleReturnDetail->product->image)}}" width="50" height="50" />--}}
{{--                            </td>--}}
                            <td>{{$productSaleReturnDetail->product->name}}</td>
                            <td>{{$productSaleReturnDetail->qty}}</td>
                            <td>{{$productSaleReturnDetail->price}}</td>
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


