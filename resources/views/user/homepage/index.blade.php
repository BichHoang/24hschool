@extends('user.layout.home')

@section('content')

    <!-- Slider Area -->
    <section class="home-slider">
        <div class="slider-active">
            <!-- Single Slider -->
            <div class="single-slider overlay" id="slider1"
                 data-stellar-background-ratio="0.5">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-12">
                            <div class="slider-text">
                                <h1>Giáo viên <span>giàu kinh nghiệm</span> & năng động</h1>
                                <p>Chúng ta nắm giữ vận mệnh của chính mình chứ không phải các vì sao.</p>
                                <div class="button">
                                    <a href="#" class="btn primary">Khóa học</a>
                                    <a href="#" class="btn">Giáo viên</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ End Single Slider -->
            <!-- Single Slider -->
            <div class="single-slider overlay" id="slider2"
                 data-stellar-background-ratio="0.5">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-12">
                            <div class="slider-text text-center">
                                <h1>Kho đề thi và khóa học <span>miễn phí</span> khổng lồ</h1>
                                <p>Nghị lực và bền bỉ có thể chinh phục mọi thứ .</p>
                                <div class="button">
                                    <a href="#" class="btn primary">Thi thử</a>
                                    <a href="#" class="btn">Khóa học</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ End Single Slider -->
            <!-- Single Slider -->
            {{--<div class="single-slider overlay" id="slider3"--}}
            {{--data-stellar-background-ratio="0.5">--}}
            {{--<div class="container">--}}
            {{--<div class="row">--}}
            {{--<div class="col-lg-8 offset-lg-4 col-md-8 offset-md-4 col-12">--}}
            {{--<div class="slider-text text-right">--}}
            {{--<h1> <span>Hoc</span> & Courses Website</h1>--}}
            {{--<p>Our mission is to empower clients, colleagues, and communities to achieve aspirations--}}
            {{--while building lasting, caring relationships.</p>--}}
            {{--<div class="button">--}}
            {{--<a href="#" class="btn primary">Our Courses</a>--}}
            {{--<a href="#" class="btn">About Learnedu</a>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<!--/ End Single Slider -->--}}
        </div>
    </section>
    <!--/ End Slider Area -->

    <!-- Features -->
    <section class="our-features section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Tất cả <span>Khóa học</span></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12">
                    <!-- Single Feature -->
                    <div class="single-feature">
                        <div class="feature-head">
                            <img src="{{asset('source/images/feature1.jpg')}}" alt="#">
                        </div>
                        <h2></h2>
                        <p>Có <strong style="font-style: italic">123 bài học</strong> trong khóa học này.
                            <a href="#" style="color: #00b3ee"><i class="fa fa-angle-double-right"
                                                                  style="padding-left: 10px;">
                                    Xem chi tiết</i></a>
                        </p>
                    </div>
                    <!--/ End Single Feature -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Features -->

    <!-- Courses -->
    <section class="courses section-bg section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Kho <span>đề thi </span>khổng lồ</h2>
                        <p>Hàng ngàn đề thi hay và chất lượng đang chờ bạn </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="course-slider">
                        <!-- Single exam -->
                    {{--<div class="single-course">--}}
                    {{--<div class="course-head overlay">--}}
                    {{--<img src="{{asset('source/images/course/course1.jpg')}}" alt="#">--}}
                    {{--<a href="#" class="btn"><i class="fa fa-link"></i></a>--}}
                    {{--</div>--}}
                    {{--<div class="single-content">--}}
                    {{--<h4><a href="#"><span>Commerce</span>Business Management</a></h4>--}}
                    {{--<p>Vivamus volutpat eros pulvinar velit laoreet, sit amet egestas erat dignissim. Lorem--}}
                    {{--ipsum dolor sit amet, consectetur adipiscing elit aenean </p>--}}
                    {{--</div>--}}
                    {{--<div class="course-meta">--}}
                    {{--<div class="meta-left">--}}
                    {{--<span><i class="fa fa-users"></i>36 Seat</span>--}}
                    {{--<span><i class="fa fa-clock-o"></i>2 Years</span>--}}
                    {{--</div>--}}
                    {{--<span class="price">$350</span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    <!--/ End Single exam -->
                        {{--@foreach($exam as $item)--}}
                            {{--<div class="col-lg-3 col-12">--}}
                                {{--<!-- Single Blog -->--}}
                                {{--<div class="single-blog">--}}
                                    {{--<div class="blog-content">--}}
                                        {{--<h4 class="blog-title"--}}
                                            {{--style="text-align: center; line-height: 2; padding-bottom: 5px;">{{$item->name}}--}}
                                        {{--</h4>--}}
                                        {{--<div class="blog-info">--}}
                                            {{--<a href="#"><i class="fa fa-user"></i>Giáo viên: {{$item->lecturer_name}}--}}
                                            {{--</a>--}}
                                            {{--@if($item->status == 1)--}}
                                                {{--<p><i class="fa fa-diamond"></i> Giá: 0 xèng <img--}}
                                                            {{--src="{{asset('source/images/free.png')}}"--}}
                                                            {{--style="width: 35px; height: 25px;" \></p>--}}
                                                {{--<p style="font-style: italic">--}}
                                            {{--@else--}}
                                                {{--<p><i class="fa fa-diamond"></i> Giá: 99 xèng <img--}}
                                                            {{--src="{{asset('source/images/not_free.png')}}"--}}
                                                            {{--style="width: 35px; height: 25px;" \></p>--}}
                                                {{--<p style="font-style: italic">--}}
                                            {{--@endif--}}
                                            {{--<p>Lượt làm: {{$item->joined}}</p>--}}
                                        {{--</div>--}}
                                        {{--@if($item->status == 1)--}}
                                            {{--<div class="button">--}}
                                                {{--<a href="{{url('user/exam_free/id/'. $item->id)}}" class="btn">Làm đề<i--}}
                                                            {{--class="fa fa-angle-double-right"></i></a>--}}
                                            {{--</div>--}}
                                        {{--@else--}}
                                            {{--<div class="button">--}}
                                                {{--<a href="{{url('user/exam_not_free/id/'. $item->id)}}" class="btn">Làm đề<i--}}
                                                            {{--class="fa fa-angle-double-right"></i></a>--}}
                                            {{--</div>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<!-- End Single Blog -->--}}
                            {{--</div>--}}
                        {{--@endforeach--}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Courses -->

    <!-- Courses -->
    <section class="courses section-bg section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Video <span>bài giảng</span></h2>
                        <p>Các bài giảng hay đến từ các thầy cô giàu kinh nghiệm </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="course-slider">
                        <!-- Single Course -->
                        <div class="single-course">
                            <iframe src="https://www.youtube.com/embed/cTMgCdW8g7w" frameborder="0" height="250px"
                                    width="100%"></iframe>
                            <div class="course-meta">
                                <div class="meta-left">
                                    <span><i class="fa fa-users"></i>36 Seat</span>
                                    <span><i class="fa fa-clock-o"></i>2 Years</span>
                                </div>
                                <span class="price">$350</span>
                            </div>
                        </div>
                        <!--/ End Single Course -->
                        <!-- Single Course -->
                        <div class="single-course">
                            <iframe src="https://www.youtube.com/embed/JVcKbEdyn1U" frameborder="0" height="250px"
                                    width="100%"></iframe>
                            <div class="course-meta">
                                <div class="meta-left">
                                    <span><i class="fa fa-users"></i>36 Seat</span>
                                    <span><i class="fa fa-clock-o"></i>2 Years</span>
                                </div>
                                <span class="price">$350</span>
                            </div>
                        </div>
                        <!--/ End Single Course -->
                        <!-- Single Course -->
                        <div class="single-course">
                            <iframe src="https://www.youtube.com/embed/yD-WKOlvENU" frameborder="0" height="250px"
                                    width="100%"></iframe>
                            <div class="course-meta">
                                <div class="meta-left">
                                    <span><i class="fa fa-users"></i>36 Seat</span>
                                    <span><i class="fa fa-clock-o"></i>2 Years</span>
                                </div>
                                <span class="price">$350</span>
                            </div>
                        </div>
                        <!--/ End Single Course -->
                        <!-- Single Course -->
                        <div class="single-course">
                            <iframe src="https://www.youtube.com/embed/4O5G4CKziKU" frameborder="0" height="250px"
                                    width="100%"></iframe>
                            <div class="course-meta">
                                <div class="meta-left">
                                    <span><i class="fa fa-users"></i>36 Seat</span>
                                    <span><i class="fa fa-clock-o"></i>2 Years</span>
                                </div>
                                <span class="price">$350</span>
                            </div>
                        </div>
                        <!--/ End Single Course -->

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Courses -->

    <!-- Team -->
    {{--<section class="team section">--}}
    {{--<div class="container">--}}
    {{--<div class="row">--}}
    {{--<div class="col-12">--}}
    {{--<div class="section-title">--}}
    {{--<h2><span>Giáo viên</span> của chúng tôi</h2>--}}
    {{--<p>Các giáo viên với nhiều năm kinh nghiệm. Thân thiện nhiệt tình, có trách nhiệm.</p>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="row">--}}
    {{--<div class="col-lg-3 col-md-6 col-12">--}}
    {{--<!-- Single Team -->--}}
    {{--<div class="single-team">--}}
    {{--<img src="{{asset('template/images/tran_mau_tu.jpg')}}" alt="#">--}}
    {{--<div class="team-hover">--}}
    {{--<h4>Trần Mậu Tú<span> Giáo viên Toán</span></h4>--}}
    {{--<p></p>--}}
    {{--<ul class="social">--}}
    {{--<li><a href="https://www.facebook.com/hlv.gv.tranmautu" target="_blank"><i--}}
    {{--class="fa fa-facebook"></i></a></li>--}}
    {{--<li><a><i class="fa fa-twitter"></i></a></li>--}}
    {{--<li><a><i class="fa fa-linkedin"></i></a></li>--}}
    {{--<li><a><i class="fa fa-youtube"></i></a></li>--}}
    {{--</ul>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<!--/ End Single Team -->--}}
    {{--</div>--}}
    {{--<div class="col-lg-3 col-md-6 col-12">--}}
    {{--<!-- Single Team -->--}}
    {{--<div class="single-team">--}}
    {{--<img src="{{asset('template/images/tran_mau_tu.jpg')}}" alt="#">--}}
    {{--<div class="team-hover">--}}
    {{--<h4>Trần Mậu Tú<span> Giáo viên Toán</span></h4>--}}
    {{--<p></p>--}}
    {{--<ul class="social">--}}
    {{--<li><a href="https://www.facebook.com/hlv.gv.tranmautu" target="_blank"><i--}}
    {{--class="fa fa-facebook"></i></a></li>--}}
    {{--<li><a><i class="fa fa-twitter"></i></a></li>--}}
    {{--<li><a><i class="fa fa-linkedin"></i></a></li>--}}
    {{--<li><a><i class="fa fa-youtube"></i></a></li>--}}
    {{--</ul>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<!--/ End Single Team -->--}}
    {{--</div>--}}
    {{--<div class="col-lg-3 col-md-6 col-12">--}}
    {{--<!-- Single Team -->--}}
    {{--<div class="single-team">--}}
    {{--<img src="{{asset('template/images/tran_mau_tu.jpg')}}" alt="#">--}}
    {{--<div class="team-hover">--}}
    {{--<h4>Trần Mậu Tú<span> Giáo viên Toán</span></h4>--}}
    {{--<p></p>--}}
    {{--<ul class="social">--}}
    {{--<li><a href="https://www.facebook.com/hlv.gv.tranmautu" target="_blank"><i--}}
    {{--class="fa fa-facebook"></i></a></li>--}}
    {{--<li><a><i class="fa fa-twitter"></i></a></li>--}}
    {{--<li><a><i class="fa fa-linkedin"></i></a></li>--}}
    {{--<li><a><i class="fa fa-youtube"></i></a></li>--}}
    {{--</ul>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<!--/ End Single Team -->--}}
    {{--</div>--}}
    {{--<div class="col-lg-3 col-md-6 col-12">--}}
    {{--<!-- Single Team -->--}}
    {{--<div class="single-team">--}}
    {{--<img src="{{asset('template/images/tran_mau_tu.jpg')}}" alt="#">--}}
    {{--<div class="team-hover">--}}
    {{--<h4>Trần Mậu Tú<span> Giáo viên Toán</span></h4>--}}
    {{--<p></p>--}}
    {{--<ul class="social">--}}
    {{--<li><a href="https://www.facebook.com/hlv.gv.tranmautu" target="_blank"><i--}}
    {{--class="fa fa-facebook"></i></a></li>--}}
    {{--<li><a><i class="fa fa-twitter"></i></a></li>--}}
    {{--<li><a><i class="fa fa-linkedin"></i></a></li>--}}
    {{--<li><a><i class="fa fa-youtube"></i></a></li>--}}
    {{--</ul>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<!--/ End Single Team -->--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</section>--}}
    <!--/ End Team -->

    <!-- Events -->
    <section class="events section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2><span>Sách hay </span>nên đọc</h2>
                        <p>Nhiều tài liệu được chia sẻ của thầy cô và các bạn học viên. </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="event-slider">
                        <!-- Single Event -->
                        <div class="single-event">
                            <div class="head overlay">
                                <img src="{{asset('source/images/book/book.jpg')}}" alt="#">
                                <a href="images/events/event1.jpg" data-fancybox="photo" class="btn"><i
                                            class="fa fa-search"></i></a>
                            </div>
                            <div class="event-content">
                                <div class="meta">
                                    <span><i class="fa fa-calendar"></i>05 June 2018</span>
                                    <span><i class="fa fa-clock-o"></i>12.00-5.00PM</span>
                                </div>
                                <h4><a href="#">Thanh xuân không hối tiếc</a></h4>
                                <p>Cuốn sách là cuộc đời của một đứa sáng chiều ăn chơi :V</p>
                                <div class="button">
                                    <a href="#" class="btn">Join Event</a>
                                </div>
                            </div>
                        </div>
                        <!--/ End Single Event -->
                        <!-- Single Event -->
                        <div class="single-event">
                            <div class="head overlay">
                                <img src="{{asset('source/images/book/book2.jpg')}}" alt="#">
                                <a href="images/events/event2.jpg" data-fancybox="photo" class="btn"><i
                                            class="fa fa-search"></i></a>
                            </div>
                            <div class="event-content">
                                <div class="meta">
                                    <span><i class="fa fa-calendar"></i>03 July 2018</span>
                                    <span><i class="fa fa-clock-o"></i>03.20-5.20PM</span>
                                </div>
                                <h4><a href="#">Bí Quyết Học Nhanh Nhớ Lâu</a></h4>
                                <p>Bí Quyết Học Nhanh Nhớ Lâu</p>
                                <div class="button">
                                    <a href="#" class="btn">Xem thêm</a>
                                </div>
                            </div>
                        </div>
                        <!--/ End Single Event -->
                        <!-- Single Event -->
                        <div class="single-event">
                            <div class="head overlay">
                                <img src="{{asset('source/images/book/book1.jpg')}}" alt="#">
                                <a href="{{asset('source/images/book/book1.jpg')}}" data-fancybox="photo" class="btn"><i
                                            class="fa fa-search"></i></a>
                            </div>
                            <div class="event-content">
                                <div class="meta">
                                    <span><i class="fa fa-calendar"></i>15 Dec 2018</span>
                                    <span><i class="fa fa-clock-o"></i>12.30-5.30PM</span>
                                </div>
                                <div class="title">
                                    <h4><a href="#">Em sẽ đến cùng cơn mưa</a></h4>
                                    <p>Em sẽ đến cùng cơn mưa. </p>
                                </div>
                                <div class="button">
                                    <a href="#" class="btn">Join Event</a>
                                </div>
                            </div>
                        </div>
                        <!--/ End Single Event -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Events -->


    <!-- Testimonials -->
    <section class="testimonials overlay section" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Mọi người nói về chúng tôi</h2>
                        {{--<p>Mauris at varius orci. Vestibulum interdum felis eu nisl pulvinar, quis ultricies nibh. Sed--}}
                        {{--ultricies ante vitae laoreet sagittis. In pellentesque viverra purus. Sed risus est,--}}
                        {{--molestie nec hendrerit hendreri </p>--}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="testimonial-slider">
                        <!-- Single Testimonial -->
                        <div class="single-testimonial">
                            <img src="{{asset('source/images/tran_van_thanh.jpg')}}" alt="#">
                            <div class="main-content">
                                <h4 class="name">Trần Văn Thành</h4>
                                <p>Đề thi rất hay và chất lượng. Thực sự cám ơn, nó giúp ích mình rất nhiều.</p>
                            </div>
                        </div>
                        <!--/ End Single Testimonial -->
                        <!-- Single Testimonial -->
                        <div class="single-testimonial">
                            <img src="{{asset('source/images/hong_nhung.jpg')}}" alt="#">
                            <div class="main-content">
                                <h4 class="name">Ngô Thị Hồng Nhung</h4>
                                <p>Hy vọng sau này càng nhiều tài liệu free hơn.. ^^.</p>
                            </div>
                        </div>
                        <!--/ End Single Testimonial -->
                        <!-- Single Testimonial -->
                        <div class="single-testimonial">
                            <img src="{{asset('source/images/dang_ba_tu.jpg')}}" alt="#">
                            <div class="main-content">
                                <h4 class="name">Đặng Bá Tú</h4>
                                <p>Khóa học thật hay và chất lượng. </p>
                            </div>
                        </div>
                        <!--/ End Single Testimonial -->
                        <!-- Single Testimonial -->
                        <div class="single-testimonial">
                            <img src="{{asset('source/images/thanh_lieu.jpg')}}" alt="#">
                            <div class="main-content">
                                <h4 class="name">Thanh Liễu</h4>
                                <p>Rất hay.</p>
                            </div>
                        </div>
                        <!--/ End Single Testimonial -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Testimonials -->
@endsection