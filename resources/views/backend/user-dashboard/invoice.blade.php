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
    <title>Invoice - Clean Tech Engineering</title>
</head>
<style>
    .login-content .login-box {
        position: relative;
        min-width: 600px;
        min-height: 423px;
        background-color: #a50909;
        -webkit-perspective: 800px;
        transition: all 0.5s ease-in-out;
    }
</style>
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
        <form class="login-form" method="POST" action="{{ route('invoice.details') }}">
            @csrf
            <h3 class="login-head" style="color: white"><i class="fa fa-lg fa-fw fa-product-hunt"></i>Product Tracking</h3>

            <div class="form-group">
                <label class="control-label" style="color: white">Invoice No</label>
                <input id="invoice" type="text" class="form-control" name="query" placeholder="Invoice No" value="{{isset($query) ? $query : ''}}" required autofocus>
                @if ($errors->has('invoice'))
                    <span class="invalid-feedback" role="alert">
                   <strong>{{ $errors->first('invoice') }}</strong>
                </span>
                @endif

            </div>

            <div class="form-group btn-container">
                <button class="btn btn-primary btn-block">SUBMIT</button>
            </div>
        </form>
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
