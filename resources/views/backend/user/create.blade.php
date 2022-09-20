@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Add User</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary" type="button">All View User</a>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Add User</h3>
                <div class="tile-body tile-footer">
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
                        {!! Form::open(array('route'
=> 'users.store','method'=>'POST')) !!}
                            @csrf
                        <div class="form-group row">
                            <label class="control-label col-md-4 text-right">Store User <span style="color: red">*</span></label>
                            <div class="col-md-6">
                                <select name="store_id" id="store_id" class="form-control">
                                    <option value="">Select One</option>
                                    @foreach($stores as $store)
                                        <option value="{{$store->id}}">{{$store->name}}</option>
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
                            <label class="control-label col-md-4 text-right"> User Type <span style="color: red">*</span></label>
                            <div class="col-md-6">
                                <select name="type" id="type" class="form-control">
                                    <option value="">Select One</option>
                                    <option value="executive">Service Executive</option>
                                    <option value="provider">Service Provider</option>

                                </select>
                                @if ($errors->has('type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name <span style="color: red">*</span></label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" >
                                </div>
                            </div>
                        <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Phone <span style="color: red">*</span></label>

                                <div class="col-md-6">
                                    <input id="phone" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="phone" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password <span style="color: red">*</span></label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }} <span style="color: red">*</span></label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="confirm-password" required>
                                </div>
                            </div>

{{--                            <div class="form-group row" >--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <input id="party_id" type="text" class="form-control" name="party_id">--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <div class="form-group row" >
                                <label for="" class="col-md-4 col-form-label text-md-right">Role <span style="color: red">*</span></label>

                                <div class="col-md-6">
                                    {!! Form::select('roles', $roles,['User'], array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
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


@push('js')
    <script>
        $('#phone').keyup(function (){
            var phone = $(this).val();
            $.ajax({
                url :  "{{URL('check-phone-number-provider')}}",
                method : "get",
                data : {
                    phone : phone
                },
                success : function (res){
                    console.log(res)
                    if(res.data == 'Found'){
                        $('#phone').val('')
                        alert('Phone Number already exists, please add another!')
                        return false
                    }
                },
                error : function (err){
                    console.log(err)
                }

            })

        })

    </script>
@endpush
