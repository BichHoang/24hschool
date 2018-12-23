<style type='text/css'>
    a.unclickable {
        text-decoration: none;
    }

    a.unclickable:hover {
        cursor: default;
    }
</style>

<!-- Header Menu -->
<div class="header-menu">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-default">
                    <div class="navbar-collapse">
                        <!-- Main Menu -->
                        <ul id="nav" class="nav menu navbar-nav">
                            <li class=""><a class="unclickable" href="#">KHÓA HỌC<i
                                            class="fa fa-angle-down"></i></a>
                                <ul class="dropdown">
                                    <li><a class="unclickable" href="#">Các khóa học</a></li>
                                </ul>
                            </li>
                            <li><a>THI THỬ<i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown">
                                    <li><a onclick="delete_locale_storage()"
                                           href="{{url('user/exam/exam_free')}}">Đề thi miễn phí</a></li>
                                    <li><a onclick="delete_locale_storage()"
                                           href="{{url('user/exam/exam_coin')}}">Đề thi có phí</a></li>
                                    <li><a href="{{url('user/history')}}">Lịch sử thi</a></li>
                                </ul>
                            </li>
                            {{--<li><a class="unclickable" href="#">LIVESTREAM<i class="fa fa-angle-down"></i></a>--}}
                            {{--<ul class="dropdown">--}}
                            {{--<li><a href="#">Events</a></li>--}}
                            {{--<li><a href="#">Event Single</a></li>--}}
                            {{--</ul>--}}
                            {{--</li>--}}
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
                                <li style="float: right;">
                                    @if(Auth::user()->avatar == null || Auth::user()->avatar == "")
                                        <a style="color: green;border: 1px solid green;border-radius: 25px;"><img
                                                    src="{{asset('template/images/no_user.png')}}" alt="Ảnh người dùng"
                                                    style="height: 30px;padding-right: 5px;">
                                            {{$user = Auth::user()->full_name}}
                                        </a>
                                    @else
                                        <a style="color: green;border: 1px solid green;border-radius: 25px;"><img
                                                    src="{{asset('avatar/'. Auth::user()->avatar)}}"
                                                    alt="Ảnh người dùng"
                                                    style="height: 30px;padding-right: 5px;">
                                            {{$user = Auth::user()->full_name}}
                                        </a>
                                    @endif
                                    <ul class="dropdown">
                                        <li><a href="{{url('user/account/information')}}"><i class=""></i>Thông tin
                                                cá nhân</a></li>
                                        <li><a href="{{url('user/book/my_cart')}}">Giỏ sách</a></li>
                                        <li><a href="{{url('user/document/my_cart')}}">Giỏ tài liệu</a></li>
                                        <li><a href="{{url('user/transaction/all')}}">Quản lý giao dịch</a></li>
                                        <li><a href="#">Thanh toán</a></li>
                                        <li><a href="{{url('/logout_user')}}"><i class=""></i>Đăng xuất</a></li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                        <!-- End Main Menu -->
                        <!-- button -->
                        <div class="button">
                        @if(Auth::check())
                            <!--	<a href="{{url('/dangky')}}" class="btn"><i class="fa fa-pied-piper-alt"></i>{{$user = Auth::user()->email}}</a>
											<a href="{{url('/logout_user')}}" ><i class=""></i>Logout</a> -->
                            @else
                                <a href="{{url('/register')}}" class="btn"><i class="fa fa-pencil"></i>Đăng ký</a>
                                <a href="{{url('/login')}}" class="btn"><i class="fa fa-user"></i>Đăng nhập</a>
                            @endif

                        </div>
                        <!--/ End Button -->
                        @yield('iconCart')
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--/ End Header Menu -->
<script>
    function delete_locale_storage() {
        localStorage.setItem('active_li', null);
    }
</script>