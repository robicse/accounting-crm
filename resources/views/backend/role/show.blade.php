@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Show Role</h1>
            </div>
{{--            <ul class="app-breadcrumb breadcrumb">--}}
{{--                <li class="breadcrumb-item"> <a href="{{ route('roles.index') }}" class="btn btn-sm btn-primary" type="button">Add Role</a></li>--}}
{{--            </ul>--}}
        </div>
        <div class="row">
            {{--<div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    {{ $role->name }}
                </div>
            </div>--}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="tile">
                            <h3 class="tile-title">{{ $role->name }} : Permissions</h3>
                            @if($rolePermissions->count() > 0)
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="10%">SL</th>
                                                <th width="10%">Controller</th>
                                                <th width="15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if(!empty($rolePermissions))
                                            @foreach($rolePermissions as $key => $v)
                                                <tr>
                                                    <td width="10%">{{ $key+1 }}</td>
                                                    <td width="10%">{{ $v->controller_name }}</td>
                                                    <td width="15%">{{ $v->name }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                    <div class="tile-footer">
                                    </div>
                                </div>
                            @else
                                <h3>No permission found for {{ $role->name }}!</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
