<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{!! asset('backend/css/main.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('css/style.css') !!}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Login - Clean Tech Engineering</title>
</head>
<body>
<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content">
    <div class="logo">
{{--        <h1><img src="{{asset('uploads/logo.png')}}" alt="logo" height="auto" width="250px"></h1>--}}
        <h1 style="color: black">Clean Tech Engineering</h1>
    </div>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="login-box">
        <form class="login-form" method="POST" action="{{ route('login') }}">
            @csrf
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>

            <div class="form-group">
                <label class="control-label">Phone / Email</label>
                <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" placeholder="Phone No" value="{{ old('phone') }}" required autofocus>
                @if ($errors->has('phone'))
                    <span class="invalid-feedback" role="alert">
                   <strong>{{ $errors->first('phone') }}</strong>
                </span>
                @endif

            </div>
            <div class="form-group">
                <label class="control-label">PASSWORD</label>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                     <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <div class="utility">
                    <div class="animated-checkbox">
                        <label>
                            <input type="checkbox"><span class="label-text">Stay Signed in</span>
                        </label>
                    </div>
                    <p class=""><a href="{{route('user.reset.password')}}">Forgot Password ?</a></p>
                </div>
            </div>
            <div class="form-group btn-container">
                <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
            </div>
        </form>
{{--        <form method="POST" class="forget-form" action="{{ route('phone.check') }}">--}}
{{--            @csrf--}}
{{--            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?</h3>--}}
{{--            <div class="form-group">--}}
{{--                --}}{{--@if (session('status'))--}}
{{--                --}}{{--<div class="alert alert-success" role="alert">--}}
{{--                --}}{{--{{ session('status') }}--}}
{{--                --}}{{--</div>--}}
{{--                --}}{{--@endif--}}
{{--                <label class="control-label">Phone No</label>--}}
{{--                <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone"  placeholder="Phone No" required>--}}
{{--                @if ($errors->has('phone'))--}}
{{--                    <span class="invalid-feedback" role="alert">--}}
{{--                         <strong>{{ $errors->first('phone') }}</strong>--}}
{{--                    </span>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--            <div class="form-group btn-container">--}}
{{--                <button class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>Send Password Reset Link</button>--}}
{{--            </div>--}}
{{--            <div class="form-group mt-3">--}}
{{--                <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>--}}
{{--            </div>--}}
{{--        </form>--}}
    </div>
</section>
<!-- Essential javascripts for application to work-->
<script src="{!! asset('backend/js/jquery-3.2.1.min.js') !!}"></script>
<script src="{!! asset('backend/js/popper.min.js') !!}"></script>
<script src="{!! asset('backend/js/bootstrap.min.js') !!}"></script>
<script src="{!! asset('backend/js/main.js') !!}"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="{!! asset('backend/js/plugins/pace.min.js') !!}"></script>
<script type="text/javascript">
    // Login Page Flipbox control
    $('.login-content [data-toggle="flip"]').click(function() {
        $('.login-box').toggleClass('flipped');
        return false;
    });
</script>
</body>
</html>
