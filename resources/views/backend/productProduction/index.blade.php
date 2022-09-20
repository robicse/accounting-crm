@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Product Production</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('productProductions.create') !!}" class="btn btn-sm btn-primary" type="button">Add Product Productions</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">

                <h3 class="tile-title">Product Productions Table</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="5%">SL NO</th>
                        <th>Production User</th>
{{--                        <th>Store</th>--}}
                        <th>Finish Good</th>
                        <th>Total Amount</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($productProductions as $key => $productProduction)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $productProduction->user->name}}</td>
{{--                        <td>{{ $productProduction->store->name}}</td>--}}
                        <td>
                            @php
                                echo $product_name = \Illuminate\Support\Facades\DB::table('products')
                                                    ->join('product_purchase_details','product_purchase_details.product_id','products.id')
                                                    ->where('product_purchase_details.ref_id',$productProduction->id)
                                                    ->pluck('products.name')
                                                    ->first();
                            @endphp
                        </td>
                        <td>{{ $productProduction->total_amount}}</td>
                        <td>{{ $productProduction->created_at}}</td>
                        <td>
                            <a href="{{ route('productProductions.show',$productProduction->id) }}" class="btn btn-sm btn-info float-left" style="margin-left: 5px">Show</a>
                            <a href="{{ route('productProductions.edit',$productProduction->id) }}" class="btn btn-sm btn-primary float-left" style="margin-left: 5px"><i class="fa fa-edit"></i></a>
                            <form method="post" action="{{ route('productProductions.destroy',$productProduction->id) }}" >
                               @method('DELETE')
                                @csrf
                                <button class="btn btn-sm btn-danger" style="margin-left: 5px" type="submit" onclick="return confirm('You Are Sure This Delete !')"><i class="fa fa-trash"></i></button>
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


