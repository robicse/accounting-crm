@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Stock Transfer Details</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('stockTransfers.index') !!}" class="btn btn-sm btn-primary" type="button">Back</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
{{--                <ul class="app-breadcrumb breadcrumb">--}}
{{--                    <li class="breadcrumb-item" style="margin-left: 90%"> <a href="{!! route('stockTransfers-invoice',$stockTransfer->id) !!}" class="btn btn-sm btn-primary"  type="button">Print Page</a></li>--}}
{{--                </ul>--}}
                <h3 class="tile-title">Stock Transfer</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>Invoice NO</th>
                        <td>{{$stockTransfer->invoice_no}}</td>
                    </tr>
                    <tr>
                        <th>User</th>
                        <td>{{$stockTransfer->user->name}}</td>
                    </tr>
                    <tr>
                        <th>From Store</th>
                        <td>{{$stockTransfer->from_store->name}}</td>
                    </tr>
                    <tr>
                        <th>To Store</th>
                        <td>{{$stockTransfer->to_store->name}}</td>
                    </tr>
                    <tr>
                        <th>Remarks</th>
                        <td>{{$stockTransfer->send_remarks}}</td>
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
                <h3 class="tile-title">Stock Transfer Details</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Category</th>
                        <th>Brand</th>
{{--                        <th>Product Image</th>--}}
{{--                        <th>Barcode</th>--}}
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Sub Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $sum_total_qty = 0;
                        $sum_total_price = 0;
                    @endphp
                    @foreach($stockTransferDetails as $stockTransferDetail)
                        @php
                            $sum_total_qty += $stockTransferDetail->qty;
                            $sum_total_price += $stockTransferDetail->sub_total;
                        @endphp
                        <tr>
                            <td>{{$stockTransferDetail->product->product_category->name}}</td>
                            <td>{{$stockTransferDetail->product->product_brand->name}}</td>
{{--                            <td>--}}
{{--                                <img src="{{asset('uploads/product/'.$stockTransferDetail->product->image)}}" width="50" height="50" />--}}
{{--                            </td>--}}
{{--                            <td>{{$stockTransferDetail->product->barcode}}</td>--}}
                            <td>{{$stockTransferDetail->product->name}}</td>
                            <td>{{$stockTransferDetail->qty}}</td>
                            <td>{{$stockTransferDetail->price}}</td>
                            <td>{{$stockTransferDetail->sub_total}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3"></td>
                        <td style="text-align: right">Total:</td>
                        <td>{{$sum_total_qty}}</td>
                        <td style="text-align: right">Total:</td>
                        <td>{{$sum_total_price}}</td>
                    </tr>
                    </tbody>
                </table>
                <div class="tile-footer">
                </div>
            </div>
        </div>
    </main>
@endsection


