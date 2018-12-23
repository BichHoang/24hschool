@extends('layout.ctv')
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

    <!-- Content Header (Page header) -->
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
                <iframe width="100%" height="600px" style="margin-left: 0;"
                        src="{{url('ctv/file_exam='.$exam->name_briefly)}}?#scrollbar=1&toolbar=1&navpanes=1&statusbar=1&view=fitH,100"
                        id="pdf_content">
                </iframe>
            </div>
            <div class="col-lg-6">
                <iframe width="100%" height="600px" style="margin-left: 0;"
                        src="{{url('ctv/file_explain='.$exam->explain_file_name)}}?#scrollbar=1&toolbar=1&navpanes=1&statusbar=1&view=fitH,100">
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

                @if($exam->request_approve == 4)
                    <div class="panel-heading row" style="padding-top: 1em;">
                        <div class="col-lg-4" style="margin-left: 40%; margin-right: 40%">
                            <a href="{{url()->previous()}}">
                                <button class="btn btn-secondary">
                                    <b>Trở về</b></button>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="panel-heading row" style="padding-top: 1em; margin-left: 30%; margin-right: 30%">
                        <div class="col-lg-4">
                            <a href="{{url('ctv/exam/update=' . $exam->id)}}">
                                <button class="btn btn-warning">
                                    <b>Chỉnh sửa</b></button>
                            </a>
                        </div>
                        <div class="col-lg-3" style="margin-left: 50px">
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