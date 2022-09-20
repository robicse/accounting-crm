@extends('backend._partial.dashboard')
<style>
    .btn .fa{font-size: 18px!important;

        margin-right: 0px!important;
        margin-top: 2px!important;
    }
</style>
@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Product Sales And Details</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('productSales.index') !!}" class="btn btn-sm btn-primary" type="button">Back</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
{{--                <ul class="app-breadcrumb breadcrumb">--}}
{{--                    <li class="breadcrumb-item" style="margin-left: 88%"> <a href="{!! route('productSales-invoice',$productSale->id) !!}" class="btn btn-sm btn-primary"  type="button">Print Invoice Page</a></li>--}}
{{--                </ul>--}}
                <h3 class="tile-title">Product Sales</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>User</th>
                            <td>{{$productSale->user->name}}</td>
                        </tr>
                        <tr>
                            <th>Store</th>
                            <td>{{$productSale->store->name}}</td>
                        </tr>
                        <tr>
                            <th>Party</th>
                            <td>{{$productSale->party->name}}</td>
                        </tr>

                        <tr>
                            <th>Date</th>
                            <td>{{$productSale->date}}</td>
                        </tr>
                        <tr>
                            <th>Invoice No</th>
                            <td>{{$productSale->invoice_no}}</td>
                        </tr>
{{--                        <tr>--}}
{{--                            <th>Payment Type</th>--}}
{{--                            <td>--}}
{{--                                @if(!empty($transactions))--}}
{{--                                    <ul>--}}
{{--                                        @foreach($transactions as $transaction)--}}
{{--                                            <li>--}}
{{--                                                {{$transaction->payment_type}}--}}
{{--                                                @if($transaction->payment_type == 'Check')--}}
{{--                                                    ( Check Number: {{$transaction->check_number}} )--}}
{{--                                                @endif--}}
{{--                                                :--}}
{{--                                                Tk.{{$transaction->amount}} ({{$transaction->created_at}})--}}
{{--                                            </li>--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}

{{--                                @endif--}}
{{--                            </td>--}}

{{--                        </tr>--}}

{{--                            <tr>--}}
{{--                                <th>Payment Type</th>--}}
{{--                                @foreach($transactions as $transaction)--}}
{{--                                    <td>{{$transaction->payment_type }} -{{$transaction->amount }} <span style="font-size: 22px;font-weight: 33">৳</span></td>--}}

{{--                                @endforeach--}}
{{--                            </tr>--}}

                        <tr>
                            <th>Delivery Service Cost</th>
                            <td>{{$productSale->transport_cost}}</td>
                        </tr>
                        <tr>
                            <th>Discount Type</th>
                            <td>{{$productSale->discount_type}}</td>
                        </tr>
                        <tr>
                            <th>Payment Type</th>
                            <td>{{$transactions->payment_type ? 'cash' : 'check' }}</td>
                        </tr>
                        <tr>
                            <th>Discount Amount</th>
                            <td>{{$productSale->discount_amount}}</td>
                        </tr>
                        <tr>
                            <th>Total Amount</th>
                            <td>{{$productSale->total_amount}}</td>
                        </tr>
                        <tr>
                            <th>Paid Amount</th>
                            <td>{{$productSale->paid_amount}}</td>
                        </tr>
                        <tr>
                            <th>Due Amount</th>
                            <td>{{$productSale->due_amount}}</td>
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
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>

                            <th>id</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Product Image</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Sub Total</th>
                            <th>Services Action</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($productSaleDetails as $productSaleDetail)
                            <tr>
                                <td>{{$productSaleDetail->id}}</td>
                                <td>{{$productSaleDetail->product->product_category->name}}</td>
                                <td>{{$productSaleDetail->product->product_brand->name}}</td>
                                <td>
                                    <img src="{{asset('uploads/product/'.$productSaleDetail->product->image)}}" width="50" height="50" />
                                </td>
                                <td>{{$productSaleDetail->product->name}}</td>
                                <td>{{$productSaleDetail->qty}}</td>
                                <td>{{$productSaleDetail->price}}</td>
                                <td>{{$productSaleDetail->sub_total}}</td>
                                <td class="d-inline-flex">
                                    <a type="button" class="test btn btn-primary btn-sm" href="{{route('productSales-addServices',$productSaleDetail->id)}}"><i class="fa fa-plus"></i></a>
{{--                                    <a href="{{route('productSales-showServices',$productSaleDetail->id)}}" class="btn btn-sm btn-primary float-left" style="margin-left: 5px"><i class="fa fa-eye"></i></a>--}}
                                    <a href="{{route('productSales-editServices',$productSaleDetail->id)}}" class="btn btn-sm btn-primary float-left" style="margin-left: 5px"><i class="fa fa-edit"></i></a>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="tile-footer" style="display: none">
                        <ul class="app-breadcrumb breadcrumb">
                            <li class="breadcrumb-item" style="margin-left: 83%"> <a href="{!! route('productSales-invoice-edit',$productSale->id) !!}" class="btn btn-sm btn-success"  type="button">Print Invoice Edit Page</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection

@push('js')

@endpush
