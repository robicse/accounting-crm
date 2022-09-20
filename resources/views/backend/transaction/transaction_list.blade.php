@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Delivery</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><a class="btn btn-warning" href="{{ route('delivery.export') }}">Export Data</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Delivery Table</h3>
                @if(!empty($stores))
                    @foreach($stores as $store)
                        <div class="col-md-12">
                            <h1 class="text-center">Clean Tech Engineering</h1>
                        </div>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">#Id</th>
                                <th width="10%">Invoice NO</th>
                                <th width="10%">Store</th>
                                <th width="10%">Delivery Service</th>
                                <th width="15%">Delivery Service Charge</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $delivery_charges = \App\ProductSale::where('store_id',$store->id)->latest()->get();
                            @endphp
                            @if(!empty($delivery_charges))
                                @foreach($delivery_charges as $key => $delivery_charge)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $delivery_charge->invoice_no}}</td>
                                        <td>{{ $delivery_charge->store->name}}</td>
                                        <td>{{ $delivery_charge->delivery_service}}</td>
                                        <td>{{ $delivery_charge->delivery_service_charge}}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div class="tile-footer">
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
    </main>
@endsection


