@extends('layout.ctv')
@section('content')
    <style>
        .hidden_show {
            visibility: hidden;
        }

        #my_form {
            position: relative;
            margin-top: 100px;
            right: 0;
            display: block;
            max-width: 1200px;
            min-width: 600px;
        }

        .not_answer {
            background-color: #34ce57;
        }

        .have_answer {
            background-color: #f7f7f7;
        }
    </style>

    <body class="open">
    @if(isset($exam) && count($exam) > 0)
        <div class="panel-heading-row">
            <h2>
                Thêm đáp án đề thi
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
                        src="{{url('ctv/file_exam='.$file_name)}}?#scrollbar=1&toolbar=1&navpanes=1&statusbar=1&view=fitH,100"
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
            <form enctype="multipart/form-data" method="post" action="" id="my_form">
                <input type="hidden" name="_token" value="<?= csrf_token() ?>">

                @for($index = 1; $index <= $number_of_questions; $index ++)
                    @if($index < 10)
                        <label for="{{$index}}">Câu 0{{$index}}</label>
                    @else
                        <label for="{{$index}}">Câu {{$index}}</label>
                    @endif
                    <select name="{{$index}}" id="{{$index}}" style="width: 60px"
                            onchange="this.className=this.options[this.selectedIndex].className"
                            class="not_answer">
                        <option class="not_answer" value="0">???</option>
                        <option class="have_answer" value="1">A</option>
                        <option class="have_answer" value="2">B</option>
                        <option class="have_answer" value="3">C</option>
                        <option class="have_answer" value="4">D</option>
                    </select>

                    @if($index % 10 == 0)
                        <br>
                    @endif
                @endfor

                <div class="panel-heading row" style="padding-top: 2em;">
                    <div class="col-lg-3" style="margin-left: 50px">
                        <input class="btn btn-primary" type="submit" value="Lưu đáp án" id="btn_save_new">
                    </div>
                    <div class="col-lg-3">
                        <input class="btn btn-basic" type="reset" value="Nhập lại" id="btn_cancel_new">
                    </div>
                    <div class="col-lg-3">
                        <input type="reset" value="Trở về" id="btn_come_back"
                               onclick="location.href='{{url('ctv/exam/not_answer/list=%20')}}'">
                    </div>
                </div>

            </form>
        </div>
    @else
        <h3>Không có dữ liệu</h3>
    @endif
    </body>

@endsection