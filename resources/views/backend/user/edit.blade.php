@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Edit User</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary" type="button">All View User</a>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Edit User</h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                        {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Store User <span style="color: red">*</span></label>
                            <div class="col-md-8">
                                <select name="store_id" id="store_id" class="form-control">
                                    <option value="">Select One</option>
                                    @foreach($stores as $store)
                                        <option value="{{$store->id}}" {{$store->id == $user->store_id ? 'selected' : ''}}>{{$store->name}}</option>
                                    @endforeach()
                                </select>
                                @if ($errors->has('store_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('store_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right"> User Type<span style="color: red">*</span></label>
                            <div class="col-md-8">
                                <select name="type" id="type" class="form-control">
                                    <option value="executive" {{$user->type == 'executive' ? 'executive' : ''}}>Service Executive</option>
                                    <option value="provider" {{$user->type == 'provider' ? 'provider' : ''}}>Service Provider</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">User Name <span style="color: red">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" placeholder="User Name" name="name" value="{!! $user->name !!}">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">User Email </label>
                            <div class="col-md-8">
                                <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" placeholder="User Email" name="email" value="{!! $user->email !!}">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">User Phone <span style="color: red">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" type="text" placeholder="User Phone No" name="phone" value="{!! $user->phone !!}">
                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

{{--                        <div class="form-group row">--}}
{{--                            <label for="password" class="col-md-3 col-form-label text-md-right">{{ __('Password') }} <span style="color: red">*</span></label>--}}

{{--                            <div class="col-md-8">--}}
{{--                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>--}}

{{--                                @if ($errors->has('password'))--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $errors->first('password') }}</strong>--}}
{{--                                    </span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label for="password-confirm" class="col-md-3 col-form-label text-md-right">{{ __('Confirm Password') }} <span style="color: red">*</span></label>--}}

{{--                            <div class="col-md-8">--}}
{{--                                <input id="password-confirm" type="password" class="form-control" name="confirm-password" required>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="form-group row">
                            <label for="" class="col-md-3 col-form-label text-md-right">Role <span style="color: red">*</span></label>

                            <div class="col-md-8">
{{--                                {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}--}}
{{--                                <select class="form-control" multiple name="roles[]">--}}
                                <select class="form-control" name="roles[]">
                                    @foreach($roles as $role)
                                        <option value="{{$role->name}}" {{$role->name == $userRole ? 'selected' : ''}} >{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-8">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update User</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                </div>
                <div class="tile-footer">
                </div>
            </div>
        </div>
    </main>
@endsection


