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
                <h3 class="tile-title">Stock Table</h3>

                @if(!empty($stores))
                    @foreach($stores as $store)
                        <div class="col-md-12">
                            <h1 class="text-center">{{$store->name}}</h1>
                        </div>
                        <div class="table-responsive">

                            <table id="example1" class="table table-bordered table-striped">
                                <h3 style="text-align: center;margin-top: 30px"> Sale Type - Sale</h3>
                                <thead>
                                <tr>
                                    <th width="5%">SL NO</th>
                                    <th width="12%">Brand</th>
                                    <th width="12%">Product</th>
                                    <th width="12%">Stock Type</th>
                                    <th width="12%">Previous Stock</th>
                                    <th width="12%">Stock In</th>
                                    <th width="12%">Stock Out</th>
                                    <th width="12%">Current Stock</th>
                                    <th width="12%">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $stocks = \App\Stock::where('store_id',$store->id)->where('stock_type','=','sale return')->latest()->get();
                                @endphp
                                @foreach($stocks as $key => $stock)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $stock->product->product_brand->name}}</td>
                                        <td>{{ $stock->product->name}}</td>
                                        <td>{{ $stock->stock_type}}</td>
                                        <td>{{ $stock->previous_stock}}</td>
                                        <td>{{ $stock->stock_in}}</td>
                                        <td>{{ $stock->stock_out}}</td>
                                        <td>{{ $stock->current_stock}}</td>
                                        <td>{{ $stock->created_at}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="tile-footer">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <h3 style="margin-top: 30px;text-align: center">Sale Type - Purchase</h3>
                                <thead>
                                <tr>
                                    <th width="5%">SL NO</th>
                                    <th width="12%">Brand</th>
                                    <th width="12%">Product</th>
                                    <th width="12%">Stock Type</th>
                                    <th width="12%">Previous Stock</th>
                                    <th width="12%">Stock In</th>
                                    <th width="12%">Stock Out</th>
                                    <th width="12%">Current Stock</th>
                                    <th width="12%">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $stocks = \App\Stock::where('store_id',$store->id)->where('stock_type','=','purchase')->latest()->get();
                                @endphp
                                @foreach($stocks as $key => $stock)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $stock->product->product_brand->name}}</td>
                                        <td>{{ $stock->product->name}}</td>
                                        <td>{{ $stock->stock_type}}</td>
                                        <td>{{ $stock->previous_stock}}</td>
                                        <td>{{ $stock->stock_in}}</td>
                                        <td>{{ $stock->stock_out}}</td>
                                        <td>{{ $stock->current_stock}}</td>
                                        <td>{{ $stock->created_at}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="tile-footer">
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
    </main>
@endsection


