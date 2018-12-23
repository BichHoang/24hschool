@extends('layout.lecturer')
@section('content')
    <style>
        .hidden_show {
            visibility: hidden;
        }

        #my_div {
            margin-right: 20%;
            margin-left: 20%;
            display: block;
            max-width: 60%;
            min-width: 40%;
        }
    </style>

    <body class="open">
    @if(isset($exam) && count($exam) > 0)
        <div class="panel-heading-row">
            <h2>
                Xem chi tiết đề thi
            </h2>
            <div>
                <p style="color: #00000b;"><b>Đề thi: {{$exam->name}}</b></p>
                <p style="color: #00000b;"><b>{{$exam->class_name}}</b>
                    <b style="padding-left: 20px">{{$exam->subject_name}}</b>
                    <b style="padding-left: 20px">Mức độ: {{$exam->level_name}}</b>
                </p>
                <p style="color: #00000b;"><b>Người soạn: {{$exam->name_user}}</b></p>
            </div>
        </div>
        <div class="panel-heading-row">
            <div class="col-lg-6">
                <h3>File đề thi</h3>
                <iframe width="100%" height="600px" style="margin-left: 0;"
                        src="{{url('lecturer/file_exam='.$exam->name_briefly)}}?#scrollbar=1&toolbar=1&navpanes=1&statusbar=1&view=fitH,100"
                        id="pdf_content">
                </iframe>
            </div>
            <div class="col-lg-6">
                <h3>File giải thích</h3>
                <iframe width="100%" height="600px" style="margin-left: 0;"
                        src="{{url('lecturer/file_explain='.$exam->explain_file_name)}}?#&scrollbar=1&toolbar=1&navpanes=1&statusbar=1&view=fitH,100">
                </iframe>
            </div>
        </div>
        <div class="panel-heading-row">
            <div id="my_div">

                @foreach($list_answer as $value)
                    @if($value->stt < 10)
                        <label for="{{$value->stt}}">Câu 0{{$value->stt}}</label>
                    @else
                        <label for="{{$value->stt}}">Câu {{$value->stt}}</label>
                    @endif

                    @if($value->answer == 1)
                        <label id="{{$value->stt}}" style="color: #34ce57;">: <b>A</b></label>
                    @elseif($value->answer == 2)
                        <label id="{{$value->stt}}" style="color: #00acc1;">: <b>B</b></label>
                    @elseif($value->answer == 3)
                        <label id="{{$value->stt}}" style="color: #99abb4;">: <b>C</b></label>
                    @else
                        <label id="{{$value->stt}}" style="color: #ff2e44;">: <b>D</b></label>
                    @endif

                    @if($value->stt % 10 == 0)
                        <br><br>
                    @endif
                @endforeach


                @if($exam->request_approve == 1 && $exam->status == 6)
                    <div class="panel-heading row" style="padding-top: 1em; margin-left: 30%; margin-right: 30%">
                        <div class="col-lg-5">
                            <a class="approve_exam" id="{{$exam->id}}"
                               href="{{url('lecturer/exam/exam_waiting_approve/approve_web='.$exam->id)}}">
                                <button class="btn btn-basic" style="background-color: #34ce57; color: #000000;">
                                    <b>Duyệt đề</b>
                                </button>
                            </a>
                        </div>
                        <div class="col-lg-3">
                            <a href="{{url('lecturer/exam/exam_waiting_approve/send_modify='. $exam->id)}}">
                                <button class="btn btn-basic" style="background-color: #ff2e44; color: #000000">
                                    <b>Yêu cầu chỉnh sửa</b></button>
                            </a>
                        </div>
                    </div>
                @elseif($exam->status ==  4)
                    <div class="panel-heading row" style="padding-top: 1em; margin-left: 30%; margin-right: 30%">
                        <div class="col-lg-3">
                            <a href="{{url('lecturer/exam/exam_waiting_approve/send_modify='. $exam->id)}}">
                                <button class="btn btn-primary">
                                    <b>Thêm comment</b>
                                </button>
                            </a>
                        </div>
                        <div class="col-lg-3"></div>
                        <div class="col-lg-4">
                            <a href="{{url('lecturer/exam/exam_need_modify/list=%20')}}">
                                <button class="btn btn-secondary">
                                    <b>Trở về</b></button>
                            </a>
                        </div>
                    </div>
                @elseif($exam->request_approve == 4)
                    <div class="panel-heading row" style="margin-left: 40%; margin-right: 40%">
                        <div class="col-lg-4">
                            <a href="{{url()->previous()}}">
                                <button class="btn btn-secondary">
                                    <b>Trở về</b></button>
                            </a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    @else
        <h3>Không có thông tin đề thi</h3>
    @endif
    </body>
@endsection

@section('script')
    <script type="text/javascript">
        var id = null;
        $('a.approve_exam').confirm({
            columnClass: 'col-md-6',
            icon: 'fa fa-bullhorn',
            title: "Lưu ý",
            content: "Chọn hình thức duyệt đề",
            type: 'blue',
            typeAnimated: true,
            draggable: false,
            buttons: {
                duyet_len_web: {
                    text: 'Duyệt lên web',
                    btnClass: 'btn-blue',
                    action: function () {
                        id = this.$target.attr('id');
                        location.replace("approve_web=" + id);
                    }
                },
                duyet_vao_kho: {
                    text: "Duyệt vào kho đề",
                    btnClass: 'btn-red',
                    action: function () {
                        id = this.$target.attr('id');
                        location.replace("approve_repository=" + id);
                    }
                },
                cancel: {
                    text: "Hủy bỏ",
                    btnClass: 'btn-brown',
                    action: function () {
                        return;
                    }
                }
            }
        });
    </script>
@endsection