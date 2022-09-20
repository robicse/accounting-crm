@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Stock</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><a class="btn btn-warning" href="{{ route('stock.export') }}">Export Data</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <form class="form-inline" action="{{ url('stock-summary/'.$store_id) }}">
                    @csrf
                    <div class="form-group col-md-3">
                        <label for="start_date">Start Date:</label>
                        <input type="date" name="start_date" class=" form-control" value="{{$start_date}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="end_date">End Date:</label>
                        <input type="date" name="end_date" class=" form-control" value="{{$end_date}}">
                    </div>

                    <div class="form-group col-md-3 text-center">
                        <button type="submit" class="btn btn-success mr-2">Submit</button>
                        <a href="{{ url('stock-summary/'.$store_id) }}" class="btn btn-primary" type="button">Reset</a>
                    </div>
                    <div class="form-group col-md-3">
                        <a href="{!! route('stock-summary-invoice',$store_id) !!}" target="__blank" class="btn btn-sm btn-warning" type="button">Invoice Print</a><br>
                    </div>
                </form>
                <h3 class="tile-title mt-4">Stock Detail</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th width="5%">#Id</th>
                            <th width="10%">Store</th>
                            <th width="15%">date</th>
                            <th width="12%">Brand</th>
                            <th width="12%">Product</th>
                            <th width="12%">Current Stock</th>
                            {{--                            <th width="12%"> Individual Price</th>--}}
                            {{--                            <th width="12%"> Price</th>--}}
                            <th width="12%">Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $total_price = 0;
                        @endphp
                        @foreach($stocks as $key => $stock)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $stock->store->name}}</td>
                                <td>{{ $stock->date}}</td>
                                <td>{{ $stock->product->product_brand->name}}</td>
                                <td>{{ $stock->product->name}}</td>
                                @php

                                    $productPurchaseDetails = DB::table('product_purchase_details')
                                                    //->join('product_purchases','product_purchases.id','=','product_purchase_details.product_purchase_id')
                                                    ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'), DB::raw('SUM(sub_total) as sub_total'))
                                                    ->where('product_purchase_details.product_id',$stock->product_id)
                                                    ->groupBy('product_id')
                                                    ->groupBy('product_category_id')
                                                    ->groupBy('product_sub_category_id')
                                                    ->groupBy('product_brand_id')
                                                    ->get();

                                        if(!empty($productPurchaseDetails)){
                                            foreach($productPurchaseDetails as $key => $productPurchaseDetail){

                                                $product_avrg_price = $productPurchaseDetail->sub_total/$productPurchaseDetail->qty;
                                                $sum_price = $stock->current_stock*$product_avrg_price;
                                        }
                                            }
                                         $total_price += $sum_price;
                                @endphp
                                <td>{{ $stock->current_stock}}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary float-left" data-toggle="modal" data-target="#exampleModal_{{$stock->id}}">Price</a>
                                </td>
                                {{--                                <td>{{$stock->current_stock*$product_avrg_price}}</td>--}}
                                {{--                                <td>{{number_format($product_avrg_price,2,".",",")}}</td>--}}
                                {{--                                <td>{{number_format($stock->current_stock*$product_avrg_price,2,".",",")}}</td>--}}
                            </tr>
                            <div class="modal fade" id="exampleModal_{{$stock->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Price</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div >
                                                <ul>
                                                    <li>Product Name: <b>{{ $stock->product->name}}</b></li>
                                                    <li>Individual Price: <b>{{number_format($product_avrg_price,2,".",",")}}</b></li>
                                                    <li>Price: <b>{{number_format($stock->current_stock*$product_avrg_price,2,".",",")}}</b></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        </tbody>
                        <div class="tile-footer">
                            <tr style="color: red">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>total</td>
                                {{--                                @dd($total_price);--}}
                                {{--                                <td>{{$total_price}}</td>--}}
                                <td>{{number_format($total_price,2,".",",")}}</td>
                            </tr>
                        </div>
                    </table>

                </div>
            </div>

        </div>
    </main>
@endsection


