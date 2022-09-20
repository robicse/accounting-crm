@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Product Sub Category</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('productSubCategories.create') !!}" class="btn btn-sm btn-primary" type="button">Add Product Sub Category</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Product Sub Category Table</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th width="5%">#Id</th>
                            <th width="10%">Category Name</th>
                            <th width="10%">Sub Category Name</th>
                            <th width="15%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($productSubCategories as $key => $productSubCategory)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $productSubCategory->product_category->name}}</td>
                            <td>{{ $productSubCategory->name}}</td>
                            <td>
                                <a href="{{ route('productSubCategories.edit',$productSubCategory->id) }}" class="btn btn-sm btn-primary float-left"><i class="fa fa-edit"></i></a>
                                <form method="post" action="{{ route('productSubCategories.destroy',$productSubCategory->id) }}" >
                                   @method('DELETE')
                                    @csrf
                                    <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('You Are Sure This Delete !')"><i class="fa fa-trash"></i></button>
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


