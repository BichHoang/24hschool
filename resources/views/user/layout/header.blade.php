<!-- Header -->
<header class="header" id="header">
    <!-- Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <!-- Contact -->
                    <ul class="content">
                        <li><i class="fa fa-phone"></i>096 828 47 62</li>
                        <li><a href="mailto:tranmautu@gmail.com"><i
                                        class="fa fa-envelope-o"></i>tranmautu@gmail.com</a></li>
                        <li><i class="fa fa-clock-o"></i>Opening: 8:00am - 5:00pm</li>
                    </ul>
                    <!-- End Contact -->
                </div>
                <div class="col-lg-4 col-12">
                    <!-- Social -->
                    <ul class="social">
                        <li><a href="https://www.facebook.com/truonghoc24hschool/" target="_blank"><i class="fa fa-facebook"></i></a></li>
                    </ul>
                    <!-- End Social -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->
    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-12">
                    <div class="logo">
                        <a href="{{url('/')}}"><img src="{{asset('template/images/24hschool-black.png')}}" alt="#"></a>
                    </div>
                    <div class="mobile-menu"></div>
                </div>
                <div class="col-lg-9 col-md-9 col-12">
                    <!-- Header Widget -->
                    <div class="header-widget">
                        <div class="single-widget">
                            <i class="fa fa-phone"></i>
                            <h4>Gọi ngay<span>096 828 47 62</span></h4>
                        </div>
                        <div class="single-widget">
                            <i class="fa fa-envelope-o"></i>
                            <h4>Gửi mail<a href="mailto:tranmautu@gmail.com"><span>tranmautu@gmail.com</span></a>
                            </h4>
                        </div>
                        <div class="single-widget">
                            <i class="fa fa-map-marker"></i>
                            <h4>Địa chỉ<span>Số 15 Ngõ 7 Thái Thịnh, Đống Đa Hà Nội</span></h4>
                        </div>
                    </div>
                    <!--/ End Header Widget -->
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
    @include('user.layout.headerMenu')
</header>
<!-- End Header -->