@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Free Product</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('free-products.create') !!}" class="btn btn-sm btn-primary" type="button">Add Free Product</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Free Product Table</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th width="5%">SL NO</th>
                            <th width="15%">Name</th>
                            <th width="15%">Image</th>
                            <th width="15%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($freeprodcuts as $key => $freeprodcut)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $freeprodcut->name}}</td>
                            <td> <img src="{{asset('uploads/free-product/'.$freeprodcut->image)}}" alt="" width="100px;"></td>

                            <td>
                                <a href="{{ route('free-products.edit',$freeprodcut->id) }}" class="btn btn-sm btn-primary float-left" style="margin-left: 5px"><i class="fa fa-edit"></i></a>
                                <form method="post" action="{{ route('free-products.destroy',$freeprodcut->id) }}" >
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


