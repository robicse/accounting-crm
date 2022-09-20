<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <title>@yield('title') </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">


    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-158104991-11"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-158104991-11');
    </script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    {{--    <link rel="shortcut icon" type="image/x-icon" href="{{asset('backend/images/favicon.ico')}}">--}}
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700&amp;subset=all' rel='stylesheet' type='text/css'>
    <link href="{{asset('Frontend/assets/plugins/socicon/socicon.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('Frontend/assets/plugins/bootstrap-social/bootstrap-social.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('Frontend/assets/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('Frontend/assets/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('Frontend/assets/plugins/animate/animate.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('Frontend/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN: BASE PLUGINS  -->
    <link href="{{asset('Frontend/assets/plugins/revo-slider/css/settings.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('Frontend/assets/plugins/revo-slider/css/layers.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('Frontend/assets/plugins/revo-slider/css/navigation.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('Frontend/assets/plugins/cubeportfolio/css/cubeportfolio.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('Frontend/assets/plugins/owl-carousel/assets/owl.carousel.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('Frontend/assets/plugins/fancybox/jquery.fancybox.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('Frontend/assets/plugins/slider-for-bootstrap/css/slider.css')}}" rel="stylesheet" type="text/css" />
    <!-- END: BASE PLUGINS -->
    <!-- BEGIN: PAGE STYLES -->
    <link href="{{asset('Frontend/assets/plugins/ilightbox/css/ilightbox.css')}}" rel="stylesheet" type="text/css" />
    <!-- END: PAGE STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="{{asset('Frontend/assets/demos/index/css/plugins.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('Frontend/assets/demos/index/css/components.css')}}" id="style_components" rel="stylesheet" type="text/css" />
    <link href="{{asset('Frontend/assets/demos/index/css/themes/default.css')}}" rel="stylesheet" id="style_theme" type="text/css" />
    <link href="{{asset('Frontend/assets/demos/index/css/custom.css')}}" rel="stylesheet" type="text/css" />
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('backend/images/favicon.ico')}}" />
    {{--toastr js--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <style>
        .footer-fixed {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #146aa6;
            color: white;
            text-align: center;
            z-index: 199;
        }

    </style>
    @stack('css')
</head>

<body class="c-layout-header-fixed c-layout-header-mobile-fixed" >

@yield('content')

<!--[if lt IE 9]>
<script src="{{asset('Frontend/assets/global/plugins/excanvas.min.js')}}"></script>
<![endif]-->
{{--<script src="{{asset('Frontend/assets/plugins/jquery.min.js')}}" type="text/javascript"></script>--}}
<script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
<script src="{{asset('Frontend/assets/plugins/jquery-migrate.min.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/jquery.easing.min.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/reveal-animate/wow.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/demos/index/js/scripts/reveal-animate/reveal-animate.js')}}" type="text/javascript"></script>
<!-- END: CORE PLUGINS -->
<!-- BEGIN: LAYOUT PLUGINS -->
<script src="{{asset('Frontend/assets/plugins/revo-slider/js/jquery.themepunch.tools.min.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/revo-slider/js/jquery.themepunch.revolution.min.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/revo-slider/js/extensions/revolution.extension.slideanims.min.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/revo-slider/js/extensions/revolution.extension.layeranimation.min.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/revo-slider/js/extensions/revolution.extension.navigation.min.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/revo-slider/js/extensions/revolution.extension.video.min.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/revo-slider/js/extensions/revolution.extension.parallax.min.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/owl-carousel/owl.carousel.min.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/counterup/jquery.waypoints.min.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/fancybox/jquery.fancybox.pack.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/smooth-scroll/jquery.smooth-scroll.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/typed/typed.min.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/slider-for-bootstrap/js/bootstrap-slider.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/js-cookie/js.cookie.js')}}" type="text/javascript"></script>
<!-- END: LAYOUT PLUGINS -->
<!-- BEGIN: THEME SCRIPTS -->
<script src="{{asset('Frontend/assets/base/js/components.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/base/js/components-shop.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/base/js/app.js')}}" type="text/javascript"></script>
<script>
    $(document).ready(function()
    {
        App.init(); // init core
    });
</script>
<!-- END: THEME SCRIPTS -->
<!-- BEGIN: PAGE SCRIPTS -->
<script src="{{asset('Frontend/assets/demos/default/js/scripts/revo-slider/slider-4.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/isotope/isotope.pkgd.min.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/isotope/imagesloaded.pkgd.min.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/isotope/packery-mode.pkgd.min.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/ilightbox/js/jquery.requestAnimationFrame.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/ilightbox/js/jquery.mousewheel.')}}'" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/ilightbox/js/ilightbox.packed.js')}}'" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/demos/default/js/scripts/pages/isotope-gallery.js')}}" type="text/javascript"></script>
<script src="{{asset('Frontend/assets/plugins/revo-slider/js/extensions/revolution.extension.parallax.min.js')}}" type="text/javascript"></script>
@stack('js')




<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
{!! Toastr::message() !!}
<script>
    @if($errors->any())
    @foreach($errors->all() as $error )
    toastr.error('{{$error}}','Error',{
        closeButton:true,
        progressBar:true
    });
    @endforeach
    @endif
</script>

</body>
</html>
