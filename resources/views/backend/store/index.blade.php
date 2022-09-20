@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Store</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('stores.create') !!}" class="btn btn-sm btn-primary" type="button">Add Store</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Store Table</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th width="5%">SL NO</th>
                            <th width="10%">Store Name</th>
                            <th width="10%">Store Phone</th>
                            <th width="10%">Store Address</th>
                            <th width="10%">Store Logo</th>
                            <th width="15%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($stores as $key => $store)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $store->name}}</td>
                            <td>{{ $store->phone }}</td>
                            <td>{{ $store->address }}</td>
                            <td>
                                <img src="{{asset('uploads/store/'.$store->logo)}}" height="80px" width="250px"/>
                            </td>
                            <td>
                                <a href="{{ route('stores.edit',$store->id) }}" class="btn btn-sm btn-primary float-left" style="margin-left: 5px"><i class="fa fa-edit"></i></a>
                                <form method="post" action="{{ route('stores.destroy',$store->id) }}" >
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


