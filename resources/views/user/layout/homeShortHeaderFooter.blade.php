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
    <!-- Styles -->
    <link rel="apple-touch-icon" href="{{asset('template/images/24hschool-black.png')}}">
    <link rel="shortcut icon" href="{{asset('template/images/24hschool-black.png')}}">
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
    <link rel="stylesheet" href="{{asset('template/css/jquery-confirm.min.css')}}">
    <!-- phai load file jquery va file jquery-confirm truoc khi load den cau lenhj confirm neu khong se error -->
    <script src="{{asset('template/js/jquery-2.2.3.min.js')}}"></script>
    <script src="{{asset('template/js/jquery-confirm.min.js')}}"></script>

    <style>
        .header .nav li a {
            padding: 15px !important;
        }

        .clockCountdown {
            position: fixed;
            top: 10%;
        }

        .rdbtAns {
            -webkit-appearance: button;
            -moz-appearance: button;
            appearance: button;
            border: 4px solid #ccc;
            border-top-color: #bbb;
            border-left-color: #bbb;
            background: #fff;
            width: 20px;
            height: 20px;
            border-radius: 50%;
        }

        .rdbtAns:checked {
            border: 10px solid #4099ff;
        }

        @media only screen and (max-width: 1010px) {
            /* For desktop: */
            .clockCountdown {
                position: relative;

            }
        }
    </style>
    <style type='text/css'>
        a.unclickable  { text-decoration: none; }
        a.unclickable:hover { cursor: default; }
    </style>
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
    <!-- Topbar -->
    <div class="container" style="background-color: #f6f6f6;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <!-- Contact -->
                    <ul class="nav menu navbar-nav" style="display: inline">
                        {{--<li>--}}
                            {{--<div class="">--}}
                                {{--<a href="{{url('/')}}"><img src="{{asset('template/images/24hschool-black.png')}}"--}}
                                    {{--style="width: 180px; height: 40px;"></a>--}}
                            {{--</div>--}}
                            {{--<div class="mobile-menu"></div>--}}
                        {{--</li>--}}
                        <li class=""><a href="{{url('#')}}">KHÓA HỌC<i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown">
                                <li><a class="unclickable" href="#">Các khóa học</a></li>
                            </ul>
                        </li>
                        <li><a href="#">THI THỬ<i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown">
                                <li><a href="{{ url('user/exam/exam_free')}}">Đề thi miễn phí</a></li>
                                <li><a href="{{ url('user/exam/exam_coin')}}">Đề thi có phí</a></li>
                                <li><a href="{{url('user/history')}}">Lịch sử thi</a></li>
                            </ul>
                        </li>
                        <li><a class="unclickable" href="#">LIVESTREAM<i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown">
                                <li><a href="#">Events</a></li>
                                <li><a href="#">Event Single</a></li>
                            </ul>
                        </li>
                        <li><a class="unclickable" href="#">ĐỒNG HỒ HỌC TẬP</a>
                        </li>
                        <li><a class="unclickable" href="#">CUỘC THI</a></li>
                        <li><a class="unclickable" href="#">SÁCH HAY<i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown">
                                <li><a class="unclickable">Sách</a>
                                    <ul class=" dropdown submenu">
                                        <li><a href="{{url('user/book/my_book')}}">Sách đã mua</a></li>
                                        <li><a href="{{url('user/book/all')}}">Cửa hàng sách</a></li>
                                    </ul>
                                </li>
                                <li><a class="unclickable">Tài liệu học tập</a>
                                    <ul class=" dropdown submenu">
                                        <li><a href="{{url('user/document/my_document')}}">Tài liệu đã mua</a></li>
                                        <li><a href="{{url('user/document/all')}}">Cửa hàng tài liệu</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        @if(Auth::check())
                            <li style="float: right; padding-top: 5px; display: inline"><a style="color: green;border: 1px solid green;border-radius: 25px;"><img
                                            src="{{asset('template/images/no_user.png')}}" alt="#"
                                            style="height: 30px;padding-right: 5px;">
                                    @if(Auth::user()->full_name != null)
                                        {{$user = Auth::user()->full_name}}
                                    @else

                                        {{$user = Auth::user()->email}}

                                    @endif
                                </a>
                                <ul class="dropdown">
                                    <li><a href="{{url('user/account/information')}}"><i class=""></i>Thông tin
                                            cá nhân</a></li>
                                    <li><a href="{{url('user/book/my_cart')}}">Giỏ sách</a></li>
                                    <li><a href="{{url('user/book/my_cart')}}">Giỏ tài liệu</a></li>
                                    <li><a href="{{url('user/transaction/all')}}">Quản lý giao dịch</a></li>
                                    <li><a href="#">Thanh toán</a></li>
                                    <li><a href="{{url('/logout_user')}}"><i class=""></i>Đăng xuất</a></li>
                                </ul>
                            </li>
                        @endif

                    </ul>
                    <!-- End Contact -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->
</header>
<!-- End Header -->
@yield('content')

<!-- Footer -->
<footer class="footer overlay section">
    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bottom-head">
                        <div class="row">
                            <div class="col-12">
                                <!-- Copyright -->
                                <div class="copyright">
                                    <p>© Copyright 2018 <a href="#">24hSchool</a>. All Rights Reserved</p>
                                </div>
                                <!--/ End Copyright -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Footer Bottom -->
</footer>
<!--/ End Footer -->


<!-- Jquery JS-->
<script type="text/javascript" src="{{asset('source/js/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('template/js/jquery-confirm.min.js')}}"></script>
<script src="{{asset('source/js/jquery-migrate.min.js')}}"></script>
<script type="text/javascript" src="{{asset('source/js/jquery.validate.min.js')}}"></script>
<!-- Popper JS-->
<script src="{{asset('source/js/popper.min.js')}}"></script>
<!-- Bootstrap JS-->
<script src="{{asset('source/js/bootstrap.min.js')}}"></script>
<!-- Colors JS-->
<script src="{{asset('source/js/colors.js')}}"></script>
<!-- Jquery Steller JS -->
<script src="{{asset('source/js/jquery.stellar.min.js')}}"></script>
<!-- Particle JS -->
<script src="{{asset('source/js/particles.min.js')}}"></script>
<!-- Fancy Box JS-->
<script src="{{asset('source/js/facnybox.min.js')}}"></script>
<!-- Magnific Popup JS-->
<script src="{{asset('source/js/jquery.magnific-popup.min.js')}}"></script>
<!-- Masonry JS-->
<script src="{{asset('source/js/masonry.pkgd.min.js')}}"></script>
<!-- Circle Progress JS -->
<script src="{{asset('source/js/circle-progress.min.js')}}"></script>
<!-- Owl Carousel JS-->
<script src="{{asset('source/js/owl.carousel.min.js')}}"></script>
<!-- Waypoints JS-->
<script src="{{asset('source/js/waypoints.min.js')}}"></script>
<!-- Slick Nav JS-->
<script src="{{asset('source/js/slicknav.min.js')}}"></script>
<!-- Counter Up JS -->
<script src="{{asset('source/js/jquery.counterup.min.js')}}"></script>
<!-- Easing JS-->
<script src="{{asset('source/js/easing.min.js')}}"></script>
<!-- Wow Min JS-->
<script src="{{asset('source/js/wow.min.js')}}"></script>
<!-- Scroll Up JS-->
<script src="{{asset('source/js/jquery.scrollUp.min.js')}}"></script>
<!-- Google Maps JS -->
<script src="http://maps.google.com/maps/api/js?key=AIzaSyC0RqLa90WDfoJedoE3Z_Gy7a7o8PCL2jw"></script>
<script src="{{asset('source/js/gmaps.min.js')}}"></script>
<!-- Main JS-->
<script src="{{asset('source/js/main.js')}}"></script>

<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js'></script>

<script src="{{asset('source/js/countdown.js')}}"></script>
@yield('script')
<script>
    $(window).load(function () {
        var s = $(window).height();
        var header = $('#header').height();
        var footer = $('#footer').height();
        var h = s - (header + footer);

        if ($("section").height() < (h + 200)) {
            console.log(h + 200);
            $("section").height(h + 200);
        }

    });
</script>

</body>
</html>

