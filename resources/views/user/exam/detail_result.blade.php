@extends('user.layout.homeShortHeaderFooter')
@section('content')

    @if(Auth::check())
        <!-- Blogs -->
        <section class="blog b-archives section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <!-- Single Blog -->
                        <div class="single-blog">
                            <div class="blog-content" style="text-align: center">
                                <h4 class="blog-title"><a href="#">File đáp án chi tiết</a></h4>
                                <iframe src="{{url('user/file_explain='. $exam_history->file_explain)}}#toolbar=0&navpanes=0&view=fitH,100"
                                        width="100%" height="650"></iframe>
                            </div>
                        </div>
                        <!-- End Single Blog -->
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="learnedu-sidebar"
                             style="display: block; border: solid 1px; width:100% ; height: 400px">
                            <p>Đề thi: <b>{{$exam_history->exam_name}}</b></p>
                            <p>Thời gian làm bài: <b>{{$exam_history->actual_test_time_mm}} phút
                                    {{$exam_history->actual_test_time_ss}} giây</b></p>
                            <p>Số câu đúng: <b>{{$exam_history->total_right_answer}}
                                    /{{$exam_history->number_of_questions}}</b>
                            </p>
                            <p>Điểm: <b>{{$exam_history->point}}</b></p>
                            <p>Video định hướng dành cho bạn:
                                <iframe width="300" height="250" src="{{$exam_history->link}}"
                                        frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/ End Blogs -->
    @else
        <div style="height: 78vh;">
            <p style="text-align: center;padding-top: 35vh"><a href="{{ url('/login')}}" style="color: red;">Đăng
                    nhập</a> để thực hiện chức
                năng này</p>

        </div>

    @endif

@endsection

