@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Monthly Service</h1>
            </div>

{{--            <ul class="app-breadcrumb breadcrumb">--}}
{{--                <li class="breadcrumb-item"> <a href="{!! route('service.create') !!}" class="btn btn-sm btn-primary" type="button">Add Service</a></li>--}}
{{--            </ul>--}}
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h2 class="tile-title" style="text-align: center">{{date('F')}} month Services</h2>
                <form class="form-inline" action="{{ route('monthly.services') }}">
                    <div class="form-group col-md-4">
                        <label for="start_date">Start Date:</label>
                        <input type="date" name="start_date" class=" form-control" value="{{$start_date}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="end_date">End Date:</label>
                        <input type="date" name="end_date" class=" form-control" value="{{$end_date}}">
                    </div>
                   <div class="form-group" style="margin-left: 30px">
                    <button class="btn btn-sm btn-primary float-left p-2">Advanced Search</button><span>&nbsp;</span>
                    <a href="{{ route('monthly.services') }}" class="btn btn-sm btn-info float-right p-2" role="button">Reset</a>
            </div>
                </form>
                <div>&nbsp;</div>

                <br>
                <br>
                <br>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th width="5%">SL NO</th>
                            <th width="15%">Service Name</th>
                            <th width="15%">Date </th>
                            <th width="15%">Customer Name</th>
                            <th width="15%">Customer Phone</th>
                            <th width="15%">Customer Address</th>
                            <th width="15%">Service Provider </th>
                        </tr>
                        </thead>
                        <tbody>
{{--                        @foreach($saleServices as $key=>$saleService)--}}
                        @foreach($saleServiceDurations as $key=>$saleServiceDuration)

                            <tr>
                                <td width="5%" >{{$key+1}}</td>
                                <td width="15%"> {{$saleServiceDuration->name}}</td>
                                <td width="8%"> {{$saleServiceDuration->service_date}}</td>
                                <td width="12%">
                                    @php

                                        $product_sale_detail_id = $saleServiceDuration->product_sale_detail_id;
//dd($product_sale_detail_id);
                                        $customer = DB::table('product_sales')
                                            ->join('product_sale_details', 'product_sales.id', '=', 'product_sale_details.product_sale_id')
                                            ->join('parties', 'parties.id', '=', 'product_sales.party_id')
                                            ->where('product_sale_details.id', $product_sale_detail_id)
                                            ->select('parties.name','parties.phone','parties.address','parties.id')
                                            ->first();
//dd($customer);
                                    if(!empty($customer)){
                                        $customer_id = $customer->id;
                                        $customer_name = $customer->name;
                                        $customer_phone = $customer->phone;
                                        $customer_address = $customer->address;
                                    }else{
                                        $customer_id = '';
                                        $customer_name = '';
                                        $customer_phone = '';
                                        $customer_address = '';
                                    }

                                    @endphp
                                    {{$customer_name}}
                                </td>
                                <td width="12%">{{$customer_phone}}</td>
                                <td width="12%">{{$customer_address}}</td>
                                <td width="25%">
                                    <form action="{{route('send.mail')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="customer_id" value="{{$customer_id}}">
                                        <input type="hidden" name="row_id" value="{{$saleServiceDuration->id}}">
                                        <input type="hidden" name="service_id" value="{{$saleServiceDuration->service_id}}">
                                        <select class="form-control select2" name="service_provider_id"  required>
                                            <option value="">Select  Service Provider</option>
                                            @foreach($serviceProviders as $serviceProvider)
                                                <option value="{{$serviceProvider->id}}" {{$serviceProvider->id == $saleServiceDuration
->provider_id ? 'selected' : '' }}>{{$serviceProvider->name}}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Send</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
@endsection


