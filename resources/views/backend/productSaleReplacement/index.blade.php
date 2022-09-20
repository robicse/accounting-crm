@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Replacement Sale Product</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('productSaleReplacement.create') !!}" class="btn btn-sm btn-primary" type="button">Add Product Sales</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">

                <h3 class="tile-title">All Replacement Sale Product</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th width="5%">SL NO</th>
                            <th>Invoice</th>
                            <th>User</th>
{{--                            <th>Store</th>--}}
                            <th>Customer</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($productSaleReplacements as $key => $productSaleReplacement)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $productSaleReplacement->sale_invoice_no}}</td>
                            <td>{{ $productSaleReplacement->user->name}}</td>
{{--                            <td>{{ $productSaleReplacement->store->name}}</td>--}}
                            <td>{{ $productSaleReplacement->party->name}}</td>
                            <td>
                                <a href="{{ route('productSaleReplacement.show',$productSaleReplacement->id) }}" class="btn btn-sm btn-info float-left" style="margin-left: 5px">Show</a>
                                <a href="{{ route('productSaleReplacement.edit',$productSaleReplacement->id) }}" class="btn btn-sm btn-primary float-left" style="margin-left: 5px"><i class="fa fa-edit"></i></a>
                                <form method="post" action="{{ route('productSaleReplacement.destroy',$productSaleReplacement->id) }}" >
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


