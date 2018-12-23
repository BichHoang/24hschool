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
    <link rel="stylesheet" href="{{asset('template/css/lightgallery.css')}}">
    <link rel="stylesheet" href="{{asset('template/css/bookgallery.css')}}">
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        #container {
            min-height: 100%; /* Fix cho firefox */
            height: auto !important;
            height: 100%;
            margin: 0 auto -4em;
        }
        .fb-livechat, .fb-widget {
            display: none
        }

        .ctrlq.fb-button, .ctrlq.fb-close {
            position: fixed;
            right: 24px;
            cursor: pointer
        }

        .ctrlq.fb-button {
            z-index: 999;
            background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDEyOCAxMjgiIGhlaWdodD0iMTI4cHgiIGlkPSJMYXllcl8xIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAxMjggMTI4IiB3aWR0aD0iMTI4cHgiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxnPjxyZWN0IGZpbGw9IiMwMDg0RkYiIGhlaWdodD0iMTI4IiB3aWR0aD0iMTI4Ii8+PC9nPjxwYXRoIGQ9Ik02NCwxNy41MzFjLTI1LjQwNSwwLTQ2LDE5LjI1OS00Niw0My4wMTVjMCwxMy41MTUsNi42NjUsMjUuNTc0LDE3LjA4OSwzMy40NnYxNi40NjIgIGwxNS42OTgtOC43MDdjNC4xODYsMS4xNzEsOC42MjEsMS44LDEzLjIxMywxLjhjMjUuNDA1LDAsNDYtMTkuMjU4LDQ2LTQzLjAxNUMxMTAsMzYuNzksODkuNDA1LDE3LjUzMSw2NCwxNy41MzF6IE02OC44NDUsNzUuMjE0ICBMNTYuOTQ3LDYyLjg1NUwzNC4wMzUsNzUuNTI0bDI1LjEyLTI2LjY1N2wxMS44OTgsMTIuMzU5bDIyLjkxLTEyLjY3TDY4Ljg0NSw3NS4yMTR6IiBmaWxsPSIjRkZGRkZGIiBpZD0iQnViYmxlX1NoYXBlIi8+PC9zdmc+) center no-repeat #0084ff;
            width: 60px;
            height: 60px;
            text-align: center;
            bottom: 50px;
            border: 0;
            outline: 0;
            border-radius: 60px;
            -webkit-border-radius: 60px;
            -moz-border-radius: 60px;
            -ms-border-radius: 60px;
            -o-border-radius: 60px;
            box-shadow: 0 1px 6px rgba(0, 0, 0, .06), 0 2px 32px rgba(0, 0, 0, .16);
            -webkit-transition: box-shadow .2s ease;
            background-size: 80%;
            transition: all .2s ease-in-out
        }

        .ctrlq.fb-button:focus, .ctrlq.fb-button:hover {
            transform: scale(1.1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, .09), 0 4px 40px rgba(0, 0, 0, .24)
        }

        .fb-widget {
            background: #fff;
            z-index: 1000;
            position: fixed;
            width: 360px;
            height: 435px;
            overflow: hidden;
            opacity: 0;
            bottom: 0;
            right: 24px;
            border-radius: 6px;
            -o-border-radius: 6px;
            -webkit-border-radius: 6px;
            box-shadow: 0 5px 40px rgba(0, 0, 0, .16);
            -webkit-box-shadow: 0 5px 40px rgba(0, 0, 0, .16);
            -moz-box-shadow: 0 5px 40px rgba(0, 0, 0, .16);
            -o-box-shadow: 0 5px 40px rgba(0, 0, 0, .16)
        }

        .fb-credit {
            text-align: center;
            margin-top: 8px
        }

        .fb-credit a {
            transition: none;
            color: #bec2c9;
            font-family: Helvetica, Arial, sans-serif;
            font-size: 12px;
            text-decoration: none;
            border: 0;
            font-weight: 400
        }

        .ctrlq.fb-overlay {
            z-index: 0;
            position: fixed;
            height: 100vh;
            width: 100vw;
            -webkit-transition: opacity .4s, visibility .4s;
            transition: opacity .4s, visibility .4s;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, .05);
            display: none
        }

        .ctrlq.fb-close {
            z-index: 4;
            padding: 0 6px;
            background: #365899;
            font-weight: 700;
            font-size: 11px;
            color: #fff;
            margin: 8px;
            border-radius: 3px
        }

        .ctrlq.fb-close::after {
            content: "X";
            font-family: sans-serif
        }

        .bubble {
            width: 20px;
            height: 20px;
            background: #c00;
            color: #fff;
            position: absolute;
            z-index: 998;
            text-align: center;
            vertical-align: middle;
            top: -2px;
            left: -5px;
            border-radius: 50%;
        }

        .bubble-msg {
            width: 120px;
            left: -140px;
            top: 5px;
            position: relative;
            background: rgba(59, 89, 152, .8);
            color: #fff;
            padding: 5px 8px;
            border-radius: 8px;
            text-align: center;
            font-size: 13px;
        }
    </style>


</head>
<body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9"></script>
<script>
    $(document).ready(function () {
        function detectmob() {
            if (navigator.userAgent.match(/Android/i)
                || navigator.userAgent.match(/webOS/i)
                || navigator.userAgent.match(/iPhone/i)
                || navigator.userAgent.match(/iPad/i)
                || navigator.userAgent.match(/iPod/i)
                || navigator.userAgent.match(/BlackBerry/i)
                || navigator.userAgent.match(/Windows Phone/i)) {
                return true;
            } else {
                return false;
            }
        }

        var t = {
            delay: 125, overlay: $(".fb-overlay"),
            widget: $(".fb-widget"), button: $(".fb-button")
        };
        setTimeout(function () {
            $("div.fb-livechat").fadeIn()
        }, 8 * t.delay);
        if (!detectmob()) {
            $(".ctrlq").on("click", function (e) {
                e.preventDefault(), t.overlay.is(":visible") ? (t.overlay.fadeOut(t.delay),
                    t.widget.stop().animate({bottom: 0, opacity: 0}, 2 * t.delay, function () {
                        $(this).hide("slow"),
                            t.button.show()
                    })) : t.button.fadeOut("medium", function () {
                    t.widget.stop().show().animate({
                        bottom: "30px", opacity: 1
                    }, 2 * t.delay), t.overlay.fadeIn(t.delay)
                })
            })
        }
    });

</script>
<div class="fb-livechat">
    <div class="ctrlq fb-overlay"></div>
    <div class="fb-widget">
        <div class="ctrlq fb-close"></div>
        <div class="fb-page" data-href="https://www.facebook.com/hethong24hschool/" data-tabs="messages"
             data-width="360" data-height="400" data-small-header="true" data-hide-cover="true"
             data-show-facepile="false"></div>
        <div class="fb-credit"><a href="" target="_blank"></a></div>
        <div id="fb-root"></div>
    </div>
    <a href="https://m.me/hethong24hschool" title="Gửi tin nhắn cho chúng tôi qua Facebook" class="ctrlq fb-button">
        <div class="bubble">1</div>
        <div class="bubble-msg">Bạn cần hỗ trợ?</div>
    </a>
</div>
<!-- Book Preloader -->
<div class="book_preload">
    <div class="book">
        <div class="book__page"></div>
        <div class="book__page"></div>
        <div class="book__page"></div>
    </div>
</div>
<!--/ End Book Preloader -->

<!-- Mp Color -->
{{--<div class="mp-color">--}}
{{--<div class="icon inOut"><i class="fa fa-cog fa-spin"></i></div>--}}
{{--<h4>Choose Color</h4>--}}
{{--<span class="color1"></span>--}}
{{--<span class="color2"></span>--}}
{{--<span class="color3"></span>--}}
{{--<span class="color4"></span>--}}
{{--<span class="color5"></span>--}}
{{--<span class="color6"></span>--}}
{{--<span class="color7"></span>--}}
{{--<span class="color8"></span>--}}
{{--</div>--}}
<!--/ End Mp Color -->
<div id="container">
    @include('user.layout.header')
    @yield('content')
    @if(\Illuminate\Support\Facades\Session::has('message_notification'))
        <div class="container">
            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fa fa-bell-o" style="color: #ff2e44">
                                    Thông báo</i></h4>
                        </div>
                        <div class="modal-body">
                            <p>{{Session::get('message_notification')}}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @elseif(\Illuminate\Support\Facades\Session::has('message_success'))
        <div class="container">
            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fa fa-bell-o" style="color: #34ce57;">
                                    Thông báo
                                </i></h4>
                        </div>
                        <div class="modal-body">
                            <p>{{Session::get('message_success')}}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    @endif
    @include('user.layout.footer')
</div>


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
<script src="https://maps.google.com/maps/api/js?key=AIzaSyC0RqLa90WDfoJedoE3Z_Gy7a7o8PCL2jw"></script>
<script src="{{asset('source/js/gmaps.min.js')}}"></script>
<!-- Main JS-->
<script src="{{asset('source/js/main.js')}}"></script>
<script src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script>
<script src="{{asset('template/js/jquery.mousewheel.min.js')}}"></script>
<script src="{{asset('template/js/lightgallery-all.min.js')}}"></script>

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

@if(\Illuminate\Support\Facades\Session::has('message_success') ||
 \Illuminate\Support\Facades\Session::has('message_notification'))
    <script>
        $("document").ready(function () {
            $('#myModal').modal('show');
            //$('.modal-backdrop').addClass('modal');
            $('.modal-backdrop').removeClass('modal-backdrop');
        })
    </script>
@endif
</body>
</html>