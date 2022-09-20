@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Product</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('products.create') !!}" class="btn btn-sm btn-primary" type="button">Add Product</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Product Table</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th width="5%">SL NO</th>
                            <th width="10%">Warranty</th>
                            <th width="17%">Product Name</th>
                            <th width="10%">Product Model</th>
                            <th width="10%">Category Name</th>
                            <th width="10%">Brand Name</th>
                            <th width="8%">Unit</th>
{{--                            <th width="10%">Image</th>--}}
                            <th width="10%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $key => $product)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $product->warranty}}</td>
                                <td>{{ $product->name}}</td>
                                <td>{{ $product->model}}</td>
                                <td>{{ $product->product_category ? $product->product_category->name : ''}}</td>
                                <td>{{ $product->product_brand ? $product->product_brand->name : ''}}</td>
                                <td>{{ $product->product_unit ? $product->product_unit->name : ''}}</td>
{{--                                <td> <img src="{{asset('uploads/product/'.$product->image)}}" alt="" width="100px;"></td>--}}
                                <td class="d-inline-flex">
                                    <a href="{{ route('products.edit',$product->id) }}" class="btn btn-sm btn-primary float-left" style="margin-left: 5px"><i class="fa fa-edit"></i></a>
                                    <form method="post" action="{{ route('products.destroy',$product->id) }}" >
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-sm btn-danger" style="margin-left: 5px" type="submit" onclick="return confirm('You Are Sure This Delete !')"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
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


