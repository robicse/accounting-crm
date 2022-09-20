@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Edit Service</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('service.index') }}" class="btn btn-sm btn-primary col-sm" type="button">All Service</a>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Edit Service</h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('service.update',$services->id) }}">
                        @method('PUT')
                        @csrf

                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Name  <small class="text-danger">*</small></label>
                            <div class="col-md-8">
                                <input type="text" id="name" name="name" value="{{$services->name}}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Status  <small class="text-danger">*</small></label>
                            <div class="col-md-8">
                                <select name="status" id="status" class="form-control">
                                    <option value="1" {{ $services->type == 'active' ? 'selected' : ''}}>active</option>
                                    <option value="2" {{ $services->type == 'inactive' ? 'selected' : ''}}>inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-8">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Service</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tile-footer">
                </div>
            </div>
        </div>
    </main>
@endsection


