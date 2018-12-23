@extends('layout.lecturer')
@section('content')

    <style>
        .hidden_show {
            visibility: hidden;
        }

        select {
            width: 300px;
        }
    </style>

    <section class="content-header">
        <h1 id="title_border">
            Thêm mới đề thi
        </h1>
    </section>
    <form enctype="multipart/form-data" method="post" action="" id="form_upload_exam">
        <input type="hidden" name="_token" value="<?= csrf_token() ?>">

        <div class="panel-heading row" style="padding-top: 1em">
            <div class="col-lg-2"></div>
            <div class="col-lg-2">
                <label style="font-weight: normal; font-size: 15px"> Chọn lớp <b style="color: #ff2e44">(*)</b> </label>
            </div>
            <div class="col-lg-6">
                @if(isset($class_room))
                    <select name="class_room" id="class_room">
                        @foreach($class_room as $value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>

        <div class="panel-heading row" style="padding-top: 1em">
            <div class="col-lg-2"></div>
            <div class="col-lg-2">
                <label style="font-weight: normal; font-size: 15px"> Chọn môn học <b style="color: #ff2e44">(*)</b>
                </label>
            </div>
            <div class="col-lg-6">
                @if(isset($subject))
                    <select name="subject" id="subject">
                        @foreach($subject as $value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>

        <div class="panel-heading row" style="padding-top: 1em">
            <div class="col-lg-2"></div>
            <div class="col-lg-2">
                <label style="font-weight: normal; font-size: 15px"> Đề thi <b style="color: #ff2e44">(*)</b> </label>
            </div>
            <div class="col-lg-6">
                <input name="file_exam" id="file_exam" type="file" class="input-sm"  accept=".pdf" style="width: 300px">
            </div>
        </div>
        <div class="panel-heading row" style="padding-top: 1px">
            <div class="col-lg-2"></div>
            <div class="col-lg-2"></div>
            <div class="col-lg-6">
                <label style="font-weight: normal; font-size: 15px; color: #ff2e44;"> File đề thi nhận các loại file
                    pdf </label>
            </div>
        </div>

        <div class="panel-heading row" style="padding-top: 1em">
            <div class="col-lg-2"></div>
            <div class="col-lg-2">
                <label style="font-weight: normal; font-size: 15px"> Tên đề thi <b style="color: #ff2e44">(*)</b>
                </label>
            </div>
            <div class="col-lg-6">
                <input name="exam_name"  id="exam_name"
                       type="text" class="input-sm" autocomplete="off" maxlength="255" style="width: 300px">
            </div>
        </div>

        <div class="panel-heading row" style="padding-top: 1em">
            <div class="col-lg-2"></div>
            <div class="col-lg-2">
                <label style="font-weight: normal; font-size: 15px"> Số lượng câu hỏi <b style="color: #ff2e44">(*)</b>
                </label>
            </div>
            <div class="col-lg-6">
                <input name="number_question" id="number_question"
                       type="number" class="input-sm" autocomplete="off" style="width: 300px">
            </div>
        </div>

        <div class="panel-heading row" style="padding-top: 1em">
            <div class="col-lg-2"></div>
            <div class="col-lg-2">
                <label style="font-weight: normal; font-size: 15px"> File giải thích <b style="color: #ff2e44">(*)</b>
                </label>
            </div>
            <div class="col-lg-6">
                <input name="file_explain" id="file_explain" type="file" class="input-sm" accept=".pdf"
                       style="width: 300px">
            </div>
        </div>
        <div class="panel-heading row" style="padding-top: 1px">
            <div class="col-lg-2"></div>
            <div class="col-lg-2"></div>
            <div class="col-lg-6">
                <label style="font-weight: normal; font-size: 15px; color: #ff2e44;"> File giải thích nhận các loại file
                    pdf </label>
            </div>
        </div>

        <div class="panel-heading row" style="padding-top: 1em">
            <div class="col-lg-2"></div>
            <div class="col-lg-2">
                <label style="font-weight: normal; font-size: 15px">Mức độ của đề <b style="color: #ff2e44">(*)</b>
                </label>
            </div>
            <div class="col-lg-6">
                @if(isset($level))
                    <select name="level" id="level">
                        @foreach($level as $value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>

        <div class="panel-heading row" style="padding-top: 1em">
            <div class="col-lg-2"></div>
            <div class="col-lg-2">
                <label style="font-weight: normal; font-size: 15px"> Thời gian thi <b style="color: #ff2e44">(*)</b>
                </label>
            </div>
            <div class="col-lg-6">
                <select name="time" id="time">
                    @for($index = 1; $index <= 10; $index++)
                        <option value="{{$index * 15}}">{{$index * 15}} phút</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="panel-heading row" style="padding-top: 2em">
            <div class="col-lg-2"></div>
            <div class="col-lg-2">
                <label style="font-weight: normal; font-size: 15px"> Ảnh đề thi </label>
            </div>
            <div class="col-lg-6">
                <!-- Tải ảnh lên -->
                <input name="img_exam" type="file" id="img_user"
                       class="required" style="height:0; width:0; visibility:hidden">
                <input type="button" class="btn btn-warning text-center" onclick="showImagePreview();"
                       value="Thêm ảnh"/>
            </div>
        </div>

        <div class="panel-heading row" style="padding-top: 2em">
            <div class="col-lg-2"></div>
            <div class="col-lg-6">
                <label id="lb_show" style="color: red; font-size: 12px; margin-left: 200px ">
                    Hiện tại chưa có ảnh </label>
                <div id="img_show" class="row hidden_show">
                    <img style="margin-left: 200px;" id="img_avatar" src=""/>
                </div>
            </div>
        </div>

        <div class="panel-heading row" style="padding-top: 2em">
            <div class="col-lg-4"></div>
            <div class="col-lg-2">
                <input style="background-color: #34ce57" type="submit" value="Lưu đề" id="btn_save" name="save">
            </div>
            <div class="col-lg-2">
                <input type="submit" value="Nhập đáp án" id="btn_enter_answer" name="enter_answer">
            </div>
        </div>
    </form>

@endsection

@section('script')
    <script>
        //Chọn ảnh lên và xử lí
        function showImagePreview() {
            var fileInput = $("#img_user");
            if (fileInput !== null) {
                //Mở cửa sổ và chọn anhr
                fileInput.trigger("click");
                fileInput.change(function () {
                    $('#img_show').removeClass("hidden_show");
                    $('#lb_show').addClass("hidden_show");
                    if (this.files && this.files[0]) {
                        // Sau khi chọn xong ảnh sẽ chuyển ảnh sang mã Base64 và đọc
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#img_avatar').attr('src', e.target.result);
                            $('#img_avatar').attr('width', 250);
                            $('#img_avatar').attr('height', 250);
                        }
                        reader.readAsDataURL(this.files[0])
                    }
                });
            }
        }

        $(document).ready(function () {
            console.log(3);
            $('#form_upload_exam').validate({
                rules: {
                    exam_name: {
                        required: true,
                        maxlength: 255
                    },
                    number_question: {
                        required: true,
                        digits: true,
                        range: [5, 250]
                    },
                    file_exam: {
                        required: true,
                        accept: "application/pdf"
                    },
                    file_explain: {
                        required: true,
                        accept: "application/pdf"
                    }
                },
                messages: {
                    exam_name: {
                        required: "Vui lòng nhập tên đề thi",
                        maxlength: "Tên đề thi không được quá 255 ký tự"
                    },
                    number_question: {
                        required: "Vui lòng nhập số lượng câu hỏi",
                        digits: "Vui lòng nhập số",
                        range: "Số câu hỏi nhận giá trị từ 5 - 250 câu hỏi"
                    },
                    file_exam:{
                        required: "Vui lòng nhập file đề thi",
                        accept: "Vui lòng chọn file pdf"
                    },
                    file_explain:{
                        required: "Vui lòng nhập file giải thích",
                        accept: "Vui lòng chọn file pdf"
                    }
                }
            });
        });
    </script>
@endsection