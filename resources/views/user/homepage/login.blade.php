<!DOCTYPE html>
<html class="no-js" lang="zxx">
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="SITE KEYWORDS HERE"/>
    <meta name="description" content="">
    <meta name='copyright' content=''>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title -->
    <title>24h School</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{asset('images/favicon.png')}}">
    <!-- Web Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('source/css/bootstrap.min.css')}}">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{asset('source/css/font-awesome.min.css')}}">
    <!-- Fancy Box CSS -->
    <link rel="stylesheet" href="{{asset('source/css/jquery.fancybox.min.css')}}">
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="{{asset('source/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('source/css/owl.theme.default.min.css')}}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{asset('source/css/animate.min.css')}}">
    <!-- Slick Nav CSS -->
    <link rel="stylesheet" href="{{asset('source/css/slicknav.min.css')}}">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{asset('source/css/magnific-popup.css')}}">

    <!-- Learedu Stylesheet -->
    <link rel="stylesheet" href="{{asset('source/css/normalize.css')}}">
    <link rel="stylesheet" href="{{asset('source/style.css')}}">
    <link rel="stylesheet" href="{{asset('source/css/responsive.css')}}">

    <!-- Learedu Color -->
    <link rel="stylesheet" href="{{asset('source/css/color/color1.css')}}">
<!--<link rel="stylesheet" href="{{asset('source/css/color/color2.css')}}">-->
<!--<link rel="stylesheet" href="{{asset('source/css/color/color3.css')}}">-->
<!--<link rel="stylesheet" href="{{asset('source/css/color/color4.css')}}">-->
<!--<link rel="stylesheet" href="{{asset('source/css/color/color5.css')}}">-->
<!--<link rel="stylesheet" href="{{asset('source/css/color/color6.css')}}">-->
<!--<link rel="stylesheet" href="{{asset('source/css/color/color7.css')}}">-->
<!--<link rel="stylesheet" href="{{asset('source/css/color/color8.css')}}">-->
    <link rel="stylesheet" href="#" id="colors">
</head>
<body>

<!-- Book Preloader -->
<div class="book_preload">
    <div class="book">
        <div class="book__page"></div>
        <div class="book__page"></div>
        <div class="book__page"></div>
    </div>
</div>
<!--/ End Book Preloader -->
<!-- Header -->
<header class="header">
    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-12">
                    <div class="logo">
                        <a href="{{url('/index')}}"><img src="{{asset('source/images/logo.png')}}" alt="#"></a>
                    </div>
                    <div class="mobile-menu"></div>
                </div>
                <div class="col-lg-9 col-md-9 col-12">
                    <!-- Header Widget -->
                    <div class="header-widget">
                        <div class="single-widget">
                            <i class="fa fa-phone"></i>
                            <h4>Call Now<span>(+121) 1800 567 980</span></h4>
                        </div>
                        <div class="single-widget">
                            <i class="fa fa-envelope-o"></i>
                            <h4>Send Message<a href="mailto:mailus@mail.com"><span>support@education.com</span></a></h4>
                        </div>
                        <div class="single-widget">
                            <i class="fa fa-map-marker"></i>
                            <h4>Our Location<span>211 Ronad, California, Us</span></h4>
                        </div>
                    </div>
                    <!--/ End Header Widget -->
                </div>
            </div>
        </div>
    </div>
</header>
<!--/ End Header Inner -->
<div class="sufee-login d-flex align-content-center flex-wrap">
    <div class="container">
        <div class="login-content">
            <div class="login-form">
                <form action="{{url('login')}}" method="post">
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">

                    <div class="form-group">
                        <label>Địa chỉ email</label>
                        <input type="email" name="txf_email" id="email" class="form-control" placeholder="Email"
                               required>
                    </div>
                    <div class="form-group">
                        <label>Mật khẩu</label>
                        <input type="password" name="txf_password" id="password" class="form-control"
                               placeholder="Mật khẩu" required>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="cb_remember"> Remember Me
                        </label>
                        <label class="pull-right">
                            <a href="{{url('forget_password')}}">Quên mật khẩu?</a>
                        </label>

                    </div>
                    <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30" style="margin-top: 10px;">Đăng
                        nhập
                    </button>
                    <div class="social-login-content">
                        <div class="social-button" style="padding-top: 10px;">
                            <button type="button" class="btn social facebook btn-flat btn-addon mb-3"
                                    style="background-color: blue;color: white;"><i
                                        class="	fa fa-facebook-square"></i> Đăng nhập bằng facebook
                            </button>
                        </div>
                    </div>
                    <div class="register-link m-t-15 text-center">
                        <p>Bạn chưa có tài khoản ? <a href="{{url('/register')}}"> Đăng ký tại đây</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@if(\Illuminate\Support\Facades\Session::has('message_success'))
    <script type="text/javascript">
        setTimeout(function () {
            $("#dialog_message_information").css("display", "block");
            $("#dialog_message_information").css("background", "#66BB6A");
            $("#lb_message_action").html("{{\Illuminate\Support\Facades\Session::get('message_success')}}");

            setTimeout(function () {
                $("#dialog_message_information").css("display", "none");
            }, 5000);
        }, 100);
    </script>
@endif

@if(\Illuminate\Support\Facades\Session::has('message_notification'))
    <script type="text/javascript">
        setTimeout(function () {
            $("#dialog_message_information").css("display", "block");
            $("#dialog_message_information").css("background", "#E57373");
            $("#lb_message_action").html("{{\Illuminate\Support\Facades\Session::get('message_notification')}}");

            setTimeout(function () {
                $("#dialog_message_information").css("display", "none");
            }, 5000);
        }, 100);
    </script>
@endif

<div id="dialog_message_information" style="z-index: 9999999999; background: #EF9A9A; border-top-left-radius: 3px;
    border-bottom-left-radius: 5px; width: 30%; display: none; margin-top: -30px; margin-left: 35%; margin-right: auto; position: absolute"
     class="message_position">
    <div id="content-header"
         style="margin-left: 15px; padding-left: 15px; margin-right: 15px; min-height: 45px;">
        <div class="row text-center">
            <span class="fa fa-bell-o" style="color: #F5F5F5"></span>
            <label style="font-size: 12px; color: #F5F5F5" id="lb_message_action"></label>
        </div>
    </div>
</div>
@include('user.layout.footer')