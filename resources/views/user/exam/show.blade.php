@extends('user.layout.home')
@section('content')

    <style>
        h4.blog-title, .post-info h4 {
            display: -webkit-box;
            max-width: 100%;
            line-height: 1.5em;
            height: 3em;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pagination li.active {
            padding: 12px 25px;
            border: none;
            display: block;
            background: #00B16A;
            color: white;
        }

        .pagination li.disabled {
            padding: 12px 25px;
            border: none;
            display: block;
            background: #f6f6f6;
            color: #252525;
        }

        .pagination li a {
            padding: 12px 25px;
            border: none;
            display: block;
            background: #f6f6f6;
            color: #fff;
            color: #252525;
        }

        .pagination li:hover a {
            background: #00B16A;
            color: #fff;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            overflow: auto;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown a:hover {
            background-color: #ddd;
        }

        .show {
            display: block;
        }

        .btn-info {
            background: #00B16A;
        }

        .post-info span {
            font-style: italic;
            padding-left: 15px;
        }

        .storage_active {
            background: #00B16A;
        }

    </style>

    <!-- Blogs -->
    <section class="blog b-archives section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12">
                    <div class="learnedu-sidebar left">
                        <div class="search">
                            <form action="{{url('user/exam/search-%20' )}}" method="post">
                                <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                <input type="text" placeholder="Tìm kiềm đề thi ..." name="search">
                                <button type="submit" class="button"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <!-- Categories -->
                        <div class="single-widget categories">
                            <div>
                                <button type="button" class="btn btn-info" data-toggle="collapse"
                                        data-target="#class">Lớp học <i class="fa fa-hand-o-down"></i></button>
                                <ul style="padding-top: 20px;" class="collapse" id="class">
                                    @foreach($class as $item)
                                        <li id="class{{$item->id}}" onclick="save_local_storage_li(this.id)">
                                            <a href="{{url('user/exam/class/'. $item->slug. "/".$item->id)}}"><i
                                                        class="fa fa-book"></i>
                                                {{$item->name}}<span>{{$item->exam_count}}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="single-widget categories">
                            <div>
                                <button type="button" class="btn btn-info" data-toggle="collapse"
                                        data-target="#subject">Môn học <i class="fa fa-hand-o-down"></i></button>
                                <ul style="padding-top: 20px;" class="collapse" id="subject">
                                    @foreach($subject as $item)
                                        <li id="subject{{$item->id}}" onclick="save_local_storage_li(this.id)">
                                            <a href="{{url('user/exam/subject/'.$item->slug. "/".$item->id)}}"><i
                                                        class="fa fa-book"></i>
                                                {{$item->name}}<span>{{$item->exam_count}}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!--/ End Categories -->
                        <!-- Posts -->
                        <div class="single-widget posts">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="newExam-tab" data-toggle="tab" href="#newExam"
                                       role="tab" aria-controls="home" aria-selected="true">Đề mới</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="manyView-tab" data-toggle="tab" href="#manyView" role="tab"
                                       aria-controls="profile" aria-selected="false">Đề hay</a>
                                </li>
                            </ul>

                            {{--new exams--}}
                            <div class="tab-content">
                                <div class="tab-pane" id="newExam" role="tabpanel" aria-labelledby="manyView-tab">
                                    <div class="single-post" style="padding-top: 20px;">
                                        @foreach($newest_exam as $value)
                                            <div class="post-info">
                                                @if($value->status == 1)
                                                    <div class="post-info">
                                                        <h4><a class="exam_free"
                                                               href="{{url('user/exam/do_exam_free/'.$value->id)}}">
                                                                <img src="{{asset('template/images/free.png')}}"
                                                                     alt="Đề thi miễn phí"
                                                                     style="width: 2em; height: 1.5em"> {{$value->name}}
                                                            </a>
                                                        </h4>
                                                        <span><i class="fa fa-calendar"></i>
                                                            {{date('d/m/Y', strtotime($value->created_at))}}</span>
                                                    </div>
                                                @elseif($value->status == 2)
                                                    <div class="post-info">
                                                        <h4><a class="exam_coin">
                                                                <img src="{{asset('template/images/coin.jpg')}}"
                                                                     alt="Đề thi mất phí"
                                                                     style="width: 2em; height: 1.5em"> {{$value->name}}
                                                            </a>
                                                        </h4>
                                                        <span><i class="fa fa-calendar"></i>
                                                            {{date('d/m/Y', strtotime($value->created_at))}}
                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                {{--many view--}}
                                <div class="tab-pane active" id="manyView" role="tabpanel"
                                     aria-labelledby="newExam-tab">
                                    <div class="single-post" style="padding-top: 20px;">
                                        @foreach($most_exam as $value)
                                            <div class="post-info">
                                                @if($value->status == 1)
                                                    <div class="post-info">
                                                        <h4><a class="exam_free"
                                                               href="{{url('user/exam/do_exam_free/'.$value->id)}}">
                                                                <img src="{{asset('template/images/free.png')}}"
                                                                     alt="Đề thi miễn phí"
                                                                     style="width: 2em; height: 1.5em">
                                                                {{$value->name}}</a></h4>
                                                        <div class="meta">
                                                            <span><i class="fa fa-edit"></i>
                                                                Có {{$value->joined}}</span> lượt làm
                                                        </div>
                                                    </div>
                                                @elseif($value->status == 2)
                                                    <div class="post-info">
                                                        <h4><a class="exam_coin">
                                                                <img src="{{asset('template/images/coin.jpg')}}"
                                                                     alt="Đề thi mất phí" style="width: 2em; height: 1.5em">
                                                                {{$value->name}}
                                                            </a>
                                                        </h4>
                                                        <div class="meta"><span><i class="fa fa-edit"></i>
                                                                    Có {{$value->joined}}</span> lượt làm
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ End Posts -->
                    </div>
                </div>
                <div class="col-lg-9 col-12">
                    <div class="row">
                        @foreach($data as $value)
                            <div class="col-lg-4 col-12">
                                <!-- Single Blog -->
                                <div class="single-blog">
                                    @if(empty($value->image))
                                        <div class="blog-head overlay">
                                            <img src="{{asset('template/images/de_thi.jpg')}}"
                                                 style="width: 100%; height:150px;" alt="{{$value->name}}">
                                        </div>
                                    @else
                                        <div class="blog-head overlay">
                                            <img src="{{url('image_exam/'. $value->image)}}"
                                                 style="width: 100%; height:150px;" alt="{{$value->name}}">
                                        </div>
                                    @endif
                                    <div class="blog-content" style="margin-right: auto; margin-left: auto">
                                        <h4 class="blog-title" style="text-align: left; ">{{$value->name}}</h4>
                                        {{-- Exam free --}}
                                        @if($value->status == 1)
                                            <div class="blog-info">
                                                <a href="#"><i class="fa fa- user"></i>Giáo
                                                    viên: {{$value->lecturer_name}}
                                                </a>
                                                <p><img src="{{asset('source/images/free.png')}}" alt="{{$value->name}}"
                                                        style="width: 35px; height: 25px;" \></p>
                                                <p style="font-style: italic">
                                                <p><i class="fa fa-edit"></i>Lượt làm: {{$value->joined}}</p>
                                            </div>
                                            <div class="button">
                                                <a href="{{url('user/exam/do_exam_free/'. $value->id)}}"
                                                   class="btn exam_free">
                                                    Làm đề ngay<i class="fa fa-angle-double-right"></i></a>
                                            </div>
                                            {{-- Exam coin--}}
                                        @elseif($value->status ==2)
                                            <div class="blog-info">
                                                <a href="#"><i class="fa fa- user"></i>Giáo
                                                    viên: {{$value->lecturer_name}}
                                                </a>
                                                <p><i class="fa fa-diamond"></i> Giá: 99 xèng <img
                                                            src="{{asset('template/images/coin.jpg')}}"
                                                            style="width: 2em; height: 1.5em;" \></p>
                                                <p style="font-style: italic">
                                                <p><i class="fa fa-edit"></i>Lượt làm: {{$value->joined}}</p>
                                            </div>
                                            <div class="button">
                                                <a class="btn exam_coin" style="color: #f7f7f7;">
                                                    Làm đề ngay<i class="fa fa-angle-double-right"></i></a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- End Single Blog -->
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <!-- Start Pagination -->
                        {{$data->render()}}
                        <!--/ End Pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Blogs -->
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('a.exam_free').confirm({
                icon: 'fa fa-bullhorn',
                content: "Bạn có muốn làm đề thi này?",
                title: "Làm đề thi",
                type: 'blue',
                typeAnimated: true,
                draggable: false,
                buttons: {
                    do_exam: {
                        text: 'Làm đề thi',
                        btnClass: 'btn-blue',
                        action: function () {
                            location.href = this.$target.attr('href');
                        }
                    },
                    huy_bo: {
                        text: 'Hủy bỏ',
                        action: function () {
                            return;
                        }
                    }
                }
            });

            $('a.exam_coin').confirm({
                title: "Thông báo",
                content: "Đề thi mất phí đang trong quá trình xây dựng." +
                "<br>Chúng tôi sẽ gửi thông báo cho bạn khi hoàn thiện" +
                "<br>Xin chân thành cám!",
                buttons: {
                    ok: {
                        text: 'Đóng thông báo',
                        btnClass: 'btn-blue',
                        action: function () {
                            return;
                        }
                    }
                }
            });
        });

        function save_local_storage_li(id_li) {
            localStorage.setItem("active_li", id_li);
        }

        $(function () {
            if ((typeof localStorage.getItem('active_li') != "undefined") &&
                localStorage.getItem('active_li').localeCompare("null") != 0) {

                var local_li = localStorage.getItem('active_li');
                var child = document.getElementById(local_li);
                child.classList.add('storage_active');
                child.parentElement.classList.add('show');
            }
        });

        $(function () {
            $('#myTab li:last-child a').tab('show')
        });

    </script>
@endsection