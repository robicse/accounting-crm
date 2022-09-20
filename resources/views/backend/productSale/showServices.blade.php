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
                <h1><i class=""></i> Show Product's Services Details</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('productSales.index') !!}" class="btn btn-sm btn-primary" type="button">Back</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Show Product's Services Details</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Services</th>
                            <th>Date</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($saleServices as $saleService)
                            @php
                                $saleServicesDurations =  \App\SaleServiceDuration::where('sale_service_id',$saleService->id)->get();
                                    //dd($saleServicesDuration)
                                    foreach ($saleServicesDurations as $saleServicesDuration)
                            @endphp
                            <tr>
                                <td>
                                    @php
                                        echo $product_name = \Illuminate\Support\Facades\DB::table('products')
                                                ->join('product_sale_details','products.id','product_sale_details.product_id')
                                                ->where('product_sale_details.id',$saleService->product_sale_detail_id)
                                                ->pluck('products.name')
                                                ->first();
                                    @endphp
                                </td>
                                <td>{{$saleService->service->name}}</td>
                                <td>{{$saleServicesDuration->service_date}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </main>
@endsection

@push('js')

@endpush
