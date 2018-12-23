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
                                <h4 class="blog-title"><a href="#">{{$exam->name}}</a></h4>
                                <p style="float: left; padding-left: 90px;"><span
                                            style="font-style: italic">Thời gian: </span>{{$exam->time}} phút.</p>
                                <p style="float: left; padding-left: 100px;"><span
                                            style="font-style: italic">Số câu hỏi: </span>{{$exam->number_of_questions}}
                                    câu.</p>
                                <p style="float: left; padding-left: 100px;padding-bottom: 15px;"><span
                                            style="font-style: italic">Người đăng: </span>{{$exam->lecturer_name}}</p>
                                <iframe src="{{url('user/file_exam='. $exam->name_briefly)}}#toolbar=0&navpanes=0&view=fitH,100"
                                        width="100%" height="700"></iframe>
                            </div>
                        </div>
                        <!-- End Single Blog -->
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="learnedu-sidebar"
                             style="display: block; border: solid 1px; width:100% ; height: 450px">
                            <!-- Categories -->
                            <p>Đề thi: <b>{{$exam->name}}</b></p>
                            <p>Thời gian làm bài: <b>{{$exam_history->actual_test_time_mm}} phút
                                    {{$exam_history->actual_test_time_ss}} giây</b></p>
                            <p>Đáp án chi tiết sẽ có vào
                                lúc {{date('H:i d/m/Y', strtotime($exam_history->time_to_send_result))}}</p>
                            <p>
                                <b style="color: #af160e;">Lưu ý: </b>Kiểm tra kết quả trong lịch sử thi
                            </p>
                            <!--/ End Categories -->

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/ End Blogs -->
    @else
        <div style="height: 78vh;">
            <p style="text-align: center;padding-top: 35vh"><a href="{{ url('/login')}}" style="color: red;">Đăng
                    nhập</a> để thực hiện chức năng này</p>

        </div>

    @endif

@endsection

