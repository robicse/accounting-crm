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
                <h3 class="tile-title">Stock Details</h3>
                    <form class="form-inline" action="{{ url('stock-details/'.$store_id) }}" style="margin-bottom: 20px">
                        <div class="form-group col-md-4">
                            <label for="start_date">Start Date:</label>
                            <input type="date" name="start_date" class="form-control" value="{{$start_date}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="end_date">End Date:</label>
                            <input type="date" name="end_date" class="form-control" value="{{$end_date}}">
                        </div>
                        <div class="form-group col-md-4">
                            <button type="submit" class="btn btn-success">Advanced Search</button>
                            <a href="{{ url('stock-details/'.$store_id) }}" class="btn btn-primary" type="button">Reset</a>
                        </div>
                    </form>
                <div class="col-md-12"></div>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="5%">#Id</th>
                        <th width="10%">Store</th>
                        <th width="15%">Stock Type</th>
                        <th width="15%">Product</th>
                        <th width="15%">Previous Stock</th>
                        <th width="15%">Stock In</th>
                        <th width="15%">Stock Out</th>
                        <th width="15%">Current Stock</th>
                        <th width="15%">date</th>
                        {{--                                    <th>SL NO</th>--}}
                        {{--                                    <th>Product Type</th>--}}
                        {{--                                    <th>Brand</th>--}}
                        {{--                                    <th>Product</th>--}}
                        {{--                                    <th>Party</th>--}}
                        {{--                                    <th>Stock Type</th>--}}
                        {{--                                    <th>Previous Stock</th>--}}
                        {{--                                    <th>Stock In</th>--}}
                        {{--                                    <th>Stock Out</th>--}}
                        {{--                                    <th>Current Stock</th>--}}
                        {{--                                    <th style="width: 15%">Date</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($stocks as $key => $stock)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $stock->store->name}}</td>
                            @if( $stock->stock_type == 'sale')
                            <td>{{ $stock->stock_type}}.{{ $stock->sale_type}}</td>
                            @else
                                <td>{{ $stock->stock_type}}</td>
                            @endif
                            <td>{{ $stock->product->name}}</td>
                            <td>{{ $stock->previous_stock}}</td>
                            <td>{{ $stock->stock_in}}</td>
                            <td>{{ $stock->stock_out}}</td>
                            <td>{{ $stock->current_stock}}</td>
                            <td>{{ $stock->date}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                    <div class="tile-footer">
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection


