@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Product Category</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('productCategories.create') !!}" class="btn btn-sm btn-primary" type="button">Add Product Category</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Product Category Table</h3>
                 <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="5%">SL NO</th>
                        <th width="10%">Name</th>
                        <th width="15%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($productCategories as $key => $productCategory)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $productCategory->name}}</td>
                        <td>
                            <a href="{{ route('productCategories.edit',$productCategory->id) }}" class="btn btn-sm btn-primary float-left" style="margin-left: 5px"><i class="fa fa-edit"></i></a>
{{--                            <form method="post" action="{{ route('productCategories.destroy',$productCategory->id) }}" >--}}
{{--                               @method('DELETE')--}}
{{--                                @csrf--}}
{{--                                <button class="btn btn-sm btn-danger" style="margin-left: 5px" type="submit" onclick="return confirm('You Are Sure This Delete !')"><i class="fa fa-trash"></i></button>--}}
{{--                            </form>--}}
                        </td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="tile-footer">
                </div>
            </div>

        </div>
    </main>
@endsection


