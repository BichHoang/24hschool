@extends('layout.lecturer')
@section('content')
    <style>

        #my_form {
            position: absolute;
            top: 100px;
            right: 0;
        }
    </style>

    <link rel="stylesheet" href="{{asset('template/css/datepicker.css')}}" media="screen">

    <script src="{{asset('template/js/bootstrap-datepicker.js')}}"></script>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 id="title_border">
            Chỉnh sửa đáp án cho đề thi {{$exam->name}}
        </h1>
    </section>
    <body class="open">
    <object width="670px" height="600px" type='application/pdf' style="margin-left: 0;"
            data="{{url('lecturer/file_exam='.$exam->name_briefly)}}?#zoom=80&scrollbar=1&toolbar=1&navpanes=1"
            id="pdf_content">
        <h3>Rất tiếc !<br>
            Không thể hiển thị file</h3>
    </object>
    <form enctype="multipart/form-data" method="post" action="" id="my_form">
        <input type="hidden" name="_token" value="<?= csrf_token() ?>">

        @foreach($list_answer as $index=>$value)
            @if($index + 1 < 10)
                <label for="{{$index +1 }}">Câu 0{{$index +1}}</label>
            @else
                <label for="{{$index +1}}">Câu {{$index +1}}</label>
            @endif
            <select name="{{$index +1}}" id="{{$index+1}}" style="width: 60px">
                @if($value->answer == 1)
                    <option value="1" selected>A</option>
                    <option value="2">B</option>
                    <option value="3">C</option>
                    <option value="4">D</option>
                @elseif($value->answer == 2)
                    <option value="1">A</option>
                    <option value="2" selected>B</option>
                    <option value="3">C</option>
                    <option value="4">D</option>
                @elseif($value->answer == 3)
                    <option value="1">A</option>
                    <option value="2">B</option>
                    <option value="3" selected>C</option>
                    <option value="4">D</option>
                @else
                    <option value="1">A</option>
                    <option value="2">B</option>
                    <option value="3">C</option>
                    <option value="4" selected>D</option>
                @endif
            </select>

            @if(($index + 1) % 5 == 0)
                <br>
            @endif
        @endforeach

        <div class="panel-heading row" style="padding-top: 2em;">
            <div class="col-lg-3" style="margin-left: 100px">
                <input  class="btn btn-primary" type="submit" value="Lưu đáp án" id="btn_save_new">
            </div>
            <div class="col-lg-3">
                <input class="btn btn-basic" type="reset" value="Nhập lại" id="btn_cancel_new">
            </div>
            <div class="col-lg-3">
                <input type="reset" value="Trở về" id="btn_come_back"
                       onclick="location.href='{{url()->previous()}}'">
            </div>
        </div>

    </form>
    </body>

@endsection