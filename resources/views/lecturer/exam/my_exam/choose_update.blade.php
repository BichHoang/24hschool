@extends('layout.lecturer')
@section('content')

    @if(isset($exam) && !is_null($exam))
        <section class="content-header">
            <h2 id="title_border">
                Chọn hình thức chỉnh sửa cho đề thi "{{$exam->name}}"
            </h2>
        </section>

        <div class="panel-heading row" style="padding-top: 1em">
            <div class="col-lg-2"></div>
            <div class="col-lg-3">
                <label style="font-weight: normal; font-size: 15px"> Tải lại file đề thi </label>
            </div>
            <div class="col-lg-6">
                <a href="{{url('lecturer/exam/my_exam/update_exam_file=' . $exam->id)}}">
                    <button class="btn btn-basic" style="color: #000000;">
                        Đổi file đề thi
                    </button>
                </a>
            </div>
        </div>

        <div class="panel-heading row" style="padding-top: 1em">
            <div class="col-lg-2"></div>
            <div class="col-lg-3">
                <label style="font-weight: normal; font-size: 15px"> Tải lại file giải thích </label>
            </div>
            <div class="col-lg-6">
                <a href="{{url('lecturer/exam/my_exam/update_explain_file='. $exam->id)}}">
                    <button class="btn btn-primary">
                        Đổi file giải thích
                    </button>
                </a>
            </div>
        </div>

        <div class="panel-heading row" style="padding-top: 1em">
            <div class="col-lg-2"></div>
            <div class="col-lg-3">
                <label style="font-weight: normal; font-size: 15px"> Chỉnh sửa thông tin đề thi </label>
            </div>
            <div class="col-lg-6">
                <a href="{{url('lecturer/exam/my_exam/update_exam_info='. $exam->id)}}">
                    <button class="btn btn-success">
                        Sửa thông tin đề thi
                    </button>
                </a>
            </div>
        </div>

        @if($exam->status == 5)
            <div class="panel-heading row" style="padding-top: 1em">
                <div class="col-lg-2"></div>
                <div class="col-lg-3">
                    <label style="font-weight: normal; font-size: 15px">Nhập lại câu trả lời</label>
                </div>
                <div class="col-lg-6">
                    <a href="{{url('lecturer/exam/my_exam/update_list_answer='. $exam->id)}}">
                        <button class="btn btn-warning">
                            Sửa câu trả lời
                        </button>
                    </a>
                </div>
            </div>
        @endif
        <div class="panel-heading row" style="padding-top: 1em">
            <div class="col-lg-2"></div>
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                @if($exam->status == 3) {{--de thi chua co dap an --}}
                <a href="{{url('lecturer/exam/my_exam/not_answer/list='. $exam->name)}}">
                    <button class="btn btn-success" style="background-color: #15D588">
                        Chỉnh sửa xong
                    </button>
                </a>
                @elseif($exam->status == 4){{--de thi can chinh sua--}}
                <a href="{{url('lecturer/exam/my_exam/need_modify/list='. $exam->name)}}">
                    <button class="btn btn-success" style="background-color: #15D588">
                        Chỉnh sửa xong
                    </button>
                </a>
                @elseif($exam->status == 5){{--de thi co dap an --}}
                <a href="{{url('lecturer/exam/my_exam/have_answer/list='. $exam->name)}}">
                    <button class="btn btn-success" style="background-color: #15D588">
                        Chỉnh sửa xong
                    </button>
                </a>
                @elseif($exam->status == 6){{--de thi da gui duyet--}}
                <a href="{{url('lecturer/exam/my_exam/waiting_approve/list='. $exam->name)}}">
                    <button class="btn btn-success" style="background-color: #15D588">
                        Chỉnh sửa xong
                    </button>
                </a>
                @endif
            </div>
        </div>
    @else
        <a href="{{url('lecturer/exam/my_exam/not_answer/list=%20')}}">
            <button class="btn btn-primary">
                Trở về
            </button>
        </a>
    @endif
@endsection