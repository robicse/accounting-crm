@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All User</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary" type="button">Add User</a></li>
            </ul>
        </div>
{{--        <div class="card-body">--}}
{{--            <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">--}}
{{--                @csrf--}}
{{--                <input type="file" name="file" class="form-control">--}}
{{--                <br>--}}
{{--                <button class="btn btn-success">Import data</button>--}}
{{--                <a class="btn btn-warning" href="{{ route('export') }}">Export Data</a>--}}
{{--            </form>--}}
{{--        </div>--}}
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">User Table</h3>


                @if(session('response'))
                    <div class="alert alert-success">
                        {{ session('response') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th width="10%">SL NO</th>
                            <th width="10%">Store Name</th>
                            <th width="10%">Name</th>
                            <th width="10%">Email</th>
                            <th width="10%">Phone</th>
                            <th width="10%">Role</th>
                            <th width="15%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $key => $user)
                        <tr style="{{$user->user_role == 2 ? 'opacity:.5' : ''}};">
                            <td>{!! $key+1 !!}</td>
                            <td>
                                @php
                                    echo $store_name = \Illuminate\Support\Facades\DB::table('stores')
                                ->where('id',$user->store_id)->pluck('name')->first();
                                @endphp
                            </td>
                            <td>{!! $user->name !!}</td>
                            <td>{!! $user->email !!}</td>
                            <td>{!! $user->phone !!}</td>
                            <td>
                                @if(!empty($user->getRoleNames()))
                                    @foreach($user->getRoleNames() as $v)
                                        <label class="badge badge-success">{{ $v }}</label>
                                    @endforeach
                                @endif
                            </td>
                            <td class="d-inline-flex">
                                <a class="btn btn-primary" style="margin-left: 5px" href="{{ route('users.edit',$user->id) }}">Edit</a>
                                <a class="btn btn-info" style="margin-left: 5px" href="{{ route('password.change_password',$user->id) }}">Edit Password</a>
{{--                                {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline;margin-left: 5px']) !!}--}}
{{--                                {!! Form::submit('Delete', ['class' => 'btn btn-danger','style'=>'margin-left: 5px']) !!}--}}
{{--                                {!! Form::close() !!}--}}
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


