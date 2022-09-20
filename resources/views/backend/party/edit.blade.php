@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Edit Party</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('party.index') }}" class="btn btn-sm btn-primary col-sm" type="button">All Party</a>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Edit Party</h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('party.update',$parties->id) }}">
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Type <small class="text-danger">*</small></label>
                            <div class="col-md-8">
                                <select name="type" id="type" class="form-control">
                                    <option value="1" {{ $parties->type == 'supplier' ? 'selected' : ''}} >Supplier</option>
                                    <option value="2" {{ $parties->type == 'customer' ? 'selected' : ''}} >Customer</option>
                                    <option value="3" {{ $parties->type == 'whole sale customer' ? 'selected' : ''}} >Whole Sale Customer</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Name  <small class="text-danger">*</small></label>
                            <div class="col-md-8">
                                <input type="text" id="name" name="name" value="{{$parties->name}}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Phone <span style="color: red">*</span></label>
                            <div class="col-md-8">
                                <input type="text" id="phone" name="phone" value="{{$parties->phone}}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Email</label>
                            <div class="col-md-8">
                                <input type="email" id="email" name="email" value="{{$parties->email}}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Address<span style="color: red">*</span></label>
                            <div class="col-md-8">
                                <input type="text" id="address" name="address" value="{{$parties->address}}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Status  <small class="text-danger">*</small></label>
                            <div class="col-md-8">
                                <select name="status" id="status" class="form-control">
                                    <option value="1" {{ $parties->type == 'active' ? 'selected' : ''}}>active</option>
                                    <option value="2" {{ $parties->type == 'inactive' ? 'selected' : ''}}>inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-8">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Party</button>
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


