<!DOCTYPE html>
<!-- saved from url=(0059)file:///E:/Template/sufee-admin-dashboard-master/index.html -->
<html class="no-js" lang=""><!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>24hSchool</title>
    <meta name="description" content="24hSchool">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Styles -->
    <link rel="apple-touch-icon" href="{{asset('template/images/24hschool-black.png')}}">
    <link rel="shortcut icon" href="{{asset('template/images/24hschool-black.png')}}">

    <link rel="stylesheet" href="{{asset('template/css/normalize.css')}}">
    <link rel="stylesheet" href="{{asset('template/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('template/css/flag-icon.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/css/cs-skin-elastic.css')}}">
    <link rel="stylesheet" href="{{asset('template/css/app.css')}}">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="{{asset('template/scss/style.css')}}">
    <link rel="stylesheet" href="{{asset('template/css/jquery-confirm.min.css')}}">


    <style>
        footer {
            position: relative;
            padding: 15px;
            background: #FFF;
            color: #000;
        }

        .error {
            color: #ff2e44;
        }
    </style>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

</head>
<body>


<!-- Left Panel -->

<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu"
                    aria-controls="main-menu" aria-expanded="true" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="#"><img
                        src="{{asset('template/images/24hschool.png')}}" alt="Logo"></a>
            <a class="navbar-brand hidden" href="#"><img
                        src="{{asset('template/images/24hschool.png')}}" alt="Logo"></a>
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <!--Component -->
                <!-- /.menu-title -->
                <h3 class="menu-title">Quản lý</h3>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <i
                                class="menu-icon fa fa-group"></i>Quản lý học sinh</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-plus-square-o"></i><a
                                    href="#">Tạo người dùng mới</a>
                        </li>
                        <li><i class="fa fa-circle-o"></i><a
                                    href="{{url('admin/student/show=%20')}}">Danh sách học sinh</a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <i
                                class="menu-icon fa fa-group"></i>Quản lý giáo viên</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-plus-square-o"></i><a
                                    href="{{url('admin/lecturer/create')}}">Tạo mới giáo viên</a>
                        </li>
                        <li><i class="fa fa-circle-o"></i><a
                                    href="{{url('admin/lecturer/show=%20')}}">Danh sách giáo viên</a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <i
                                class="menu-icon fa fa-building-o"></i>Quản lý lớp học</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-plus-square-o"></i><a
                                    href="#">Thêm mới</a>
                        </li>
                        <li><i class="fa fa-list"></i><a
                                    href="{{url('admin/class_room/show=%20')}}">Xem lớp học</a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <i
                                class="menu-icon fa fa-bookmark-o"></i>Quản lý môn học</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-plus-square-o"></i><a
                                    href="#">Thêm mới</a>
                        </li>
                        <li><i class="fa fa-list"></i><a
                                    href="{{url('admin/subject/show=%20')}}">Xem môn học</a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <i
                                class="menu-icon fa fa-bars"></i>Quản lý chủ đề</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-plus-square-o"></i><a
                                    href="#">Thêm mới</a>
                        </li>
                        <li><i class="fa fa-list"></i><a
                                    href="{{url('admin/topic/show=%20')}}">Xem chủ đề</a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-submenu"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <i
                                class="menu-icon fa fa-money"></i>Giao dịch</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-circle-o"></i><a href="{{url('admin/transaction/book/list_register-%20')}}">
                                Danh sách người đăng ký mua sách</a></li>
                        <li><i class="fa fa-circle-o"></i><a href="{{url('admin/transaction/document/list_register-%20')}}">
                                Danh sách người đăng ký mua tài liệu</a></li>
                        <li><i class="fa fa-circle-o"></i><a
                                    href="#">Giao dịch sách đã kết thúc</a></li>
                        <li><i class="fa fa-circle-o"></i><a
                                    href="#">Giao dịch tài liệu đã kết thúc</a></li>
                    </ul>
                </li>

                <!-- /.menu-title -->
                <h3 class="menu-title">Hệ thống</h3>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <i
                                class="menu-icon fa fa-gears"></i>Báo cáo sự cố</a>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <i
                                class="menu-icon fa fa-wrench"></i>Thông báo bảo trì</a>
                </li>
            </ul>


        </div><!-- /.navbar-collapse -->
    </nav>
</aside><!-- /#left-panel -->

<!-- Left Panel -->

<!-- Right Panel -->

<div id="right-panel" class="right-panel">

    <!-- Header-->
    <header id="header" class="header">

        <div class="header-menu">

            <div class="col-sm-7">
                <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>

                <!--Header lesf -->
                <div class="header-left">

                    <!-- Button search-->
                    <button class="search-trigger"><i class="fa fa-search"></i></button>
                    <div class="form-inline">
                        <form class="search-form">
                            <input class="form-control mr-sm-2" type="text" placeholder="Search ..."
                                   aria-label="Search">
                            <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                        </form>
                    </div>

                    <!--Notification -->
                    <div class="dropdown for-notification">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="notification"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                            <span class="count bg-danger">5</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="notification">
                            <p class="red">You have 3 Notification</p>
                            <a class="dropdown-item media bg-flat-color-1"
                               href="#">
                                <i class="fa fa-check"></i>
                                <p>Server #1 overloaded.</p>
                            </a>
                        </div>
                    </div>

                    <!-- Message -->
                    <div class="dropdown for-message">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="message"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ti-email"></i>
                            <span class="count bg-primary">9</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="message">
                            <p class="red">You have 4 Mails</p>
                            <a class="dropdown-item media bg-flat-color-1"
                               href="#">
                                <span class="photo media-left"><img alt="avatar"
                                                                    src="{{asset('template/images/icon_nologo.png')}}"></span>
                                <span class="message media-body">
                                    <span class="name float-left">Jonathan Smith</span>
                                    <span class="time float-right">Just now</span>
                                        <p>Hello, this is an example msg</p>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User information -->
            <div class="col-sm-5">
                <div class="user-area dropdown float-right">
                    <a href="#" class="dropdown-toggle"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <img class="user-avatar rounded-circle" src="{{asset('template/images/icon_nologo.png')}}"
                             alt="User Avatar">
                    </a>

                    <div class="user-menu dropdown-menu">
                        <a class="nav-link" href="#"><i
                                    class="fa fa- user"></i>Thông tin cá nhân</a>

                        <a class="nav-link" href="#"><i
                                    class="fa fa- user"></i>Thông báo<span class="count">13</span></a>

                        <a class="nav-link" href="#"><i
                                    class="fa fa -cog"></i>Cài đặt</a>

                        <a class="nav-link" href="{{url('logout')}}"><i
                                    class="fa fa-power -off"></i>Đăng xuất</a>
                    </div>
                </div>

            </div>
        </div>

    </header><!-- /header -->
    <!-- Header-->

    <div id="dialog_message_information" style="z-index: 9999999999; background: #EF9A9A; border-top-left-radius: 3px;
    border-bottom-left-radius: 5px; width: 24%; display: none; margin-left: 55%; position: absolute"
         class="message_position;">
        <div id="content-header"
             style="margin-left: 15px; padding-left: 15px; margin-right: 15px; min-height: 45px;">
            <div class="row text-center">
                <span class="fa fa-bell-o" style="color: #F5F5F5"></span>
                <label style="font-size: 12px; color: #F5F5F5" id="lb_message_action"></label>
            </div>
        </div>
    </div>

    <div class="content-wrapper" style="position: relative; padding-bottom: 70px; background: #F5F5F5 !important;">
        @yield('content')

    </div>
</div>

<!-- /#right-panel -->

<!-- footer -->

<!-- End Footer -->


<!-- Script -->
<script type="text/javascript" src="{{asset('source/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('template/js/jquery-confirm.min.js')}}"></script>
<script src="{{asset('source/js/jquery-migrate.min.js')}}"></script>
<script type="text/javascript" src="{{asset('source/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('template/js/popper.min.js')}}"></script>
<script src="{{asset('template/js/plugins.js')}}"></script>
<script src="{{asset('template/js/main.js')}}"></script>
<!-- jQuery UI 1.11.4 -->

<script src="{{asset('template/js/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script src="{{asset('template/js/bootstrap.min.js')}}"></script>
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
@yield('script')
<script>
    $(document).ready(function(){
        $('.dropdown-submenu a.dropdown').on("click", function(e){
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
        });
    });
</script>
</body>

</html>