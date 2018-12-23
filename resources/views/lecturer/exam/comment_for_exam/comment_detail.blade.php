@extends('layout.lecturer')
@section('content')
    <style>
        .hidden_show {
            visibility: hidden;
        }

        #my_div {
            position: absolute;
            top: 100px;
            right: 30px;
        }
    </style>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 id="title_border">
            Chi tiết yêu cầu chỉnh sửa
        </h1>
    </section>
    <body class="open">
    @if(isset($exam) && count($exam) > 0 && isset($comment))
        <object width="670px" height="600px" type='application/pdf' style="margin-left: 0;"
                data="{{url('lecturer/file_exam='.$exam->name_briefly)}}?#zoom=80&scrollbar=1&toolbar=1&navpanes=1"
                id="pdf_content">
            <h3>Rất tiếc !<br>
                Không thể hiển thị file</h3>
        </object>
        <div id="my_div">

            @foreach($list_answer as $value)
                @if($value->stt < 10)
                    <label for="{{$value->stt}}">Câu 0{{$value->stt}}</label>
                    @if($value->answer == 1)
                        <label id="{{$value->stt}}" style="color: #34ce57;">: <b>A</b></label>
                    @elseif($value->answer == 2)
                        <label id="{{$value->stt}}" style="color: #00acc1;">: <b>B</b></label>
                    @elseif($value->answer == 3)
                        <label id="{{$value->stt}}" style="color: #99abb4;">: <b>C</b></label>
                    @else
                        <label id="{{$value->stt}}" style="color: #ff2e44;">: <b>D</b></label>
                    @endif
                @else
                    <label for="{{$value->stt}}">Câu {{$value->stt}}</label>
                    @if($value->answer == 1)
                        <label id="{{$value->stt}}" style="color: #34ce57;">: <b>A</b></label>
                    @elseif($value->answer == 2)
                        <label id="{{$value->stt}}" style="color: #00acc1;">: <b>B</b></label>
                    @elseif($value->answer == 3)
                        <label id="{{$value->stt}}" style="color: #99abb4;">: <b>C</b></label>
                    @else
                        <label id="{{$value->stt}}" style="color: #ff2e44;">: <b>D</b></label>
                    @endif
                @endif

                @if($value->stt % 5 == 0)
                    <br><br>
                @endif
            @endforeach

        </div>

        <form action="{{url('lecturer/exam/exam_need_modify/update_comment='.$comment->id)}}" method="post">
            <input type="hidden" name="_token" value="<?= csrf_token() ?>">
            <div class="row">
                <div class="col-lg-2">Viết nhận xét</div>
                <div class="col-lg-6">
                    <textarea name="ta_comment" rows="4" cols="60">{{$comment->comment}}</textarea>
                </div>
            </div>
            <div class="row" style="padding-top: 1em;">
                <div class="col-lg-2"></div>
                <div class="col-lg-2">
                    <input type="submit" class="btn btn-primary" value="Yêu cầu chỉnh sửa">
                </div>
                <div class="col-lg-3">
                    <input type="button" class="btn btn-primary"
                           onclick="location.href = '{{url()->previous()}}'"
                           value="Trở về">
                </div>
            </div>
        </form>
    @else
        <h3>Không có thông tin đề thi</h3>
    @endif
    </body>

@endsection