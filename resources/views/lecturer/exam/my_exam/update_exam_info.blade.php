@extends('layout.lecturer')
@section('content')

    <style>
        select {
            width: 300px;
        }
    </style>

    <section class="content-header">
        <h2 id="title_border">
            Chỉnh sửa thông tin đề thi "{{$exam->name}}"
        </h2>
    </section>
    <form enctype="multipart/form-data" method="post" action="" id="my_form">
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
                            @if($exam->id_class == $value->id)
                                <option value="{{$value->id}}" selected>{{$value->name}}</option>
                            @else
                                <option value="{{$value->id}}">{{$value->name}}</option>
                            @endif
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
                            @if($exam->id_subject == $value->id)
                                <option value="{{$value->id}}" selected>{{$value->name}}</option>
                            @else
                                <option value="{{$value->id}}"> {{$value->name}}</option>
                            @endif
                        @endforeach
                    </select>
                @endif
            </div>
        </div>

        <div class="panel-heading row" style="padding-top: 1em">
            <div class="col-lg-2"></div>
            <div class="col-lg-2">
                <label style="font-weight: normal; font-size: 15px"> Tên đề thi <b style="color: #ff2e44">(*)</b>
                </label>
            </div>
            <div class="col-lg-6">
                <input name="exam_name" type="text" class="input-sm" autocomplete="off" min="5" max="255"
                       required style="width: 300px" value="{{$exam->name}}">
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
                            @if($exam->id_level == $value->id)
                                <option value="{{$value->id}}" selected>{{$value->name}}</option>
                            @else
                                <option value="{{$value->id}}">{{$value->name}}</option>
                            @endif
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
                        @if($exam->time == ($index * 15))
                            <option value="{{$index * 15}}" selected>{{$index * 15}} phút</option>
                        @else
                            <option value="{{$index * 15}}">{{$index * 15}} phút</option>
                        @endif
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
                <input name="img_exam" type="file" id="img_user" accept="image/*"
                       class="required" style="height:0; width:0; visibility:hidden">
                <input type="button" class="btn btn-warning text-center" onclick="showImagePreview();"
                       value="Thay đổi ảnh"/>
            </div>
        </div>

        <div class="panel-heading row" style="padding-top: 2em">
            <div class="col-lg-2"></div>
            <div class="col-lg-6">
                @if(empty($exam->image))
                    <div id="img_show" class="row hidden_show">
                        <img style="margin-left: 200px;" id="img_avatar" src="{{asset('template/images/de_thi.jpg')}}"/>
                    </div>
                @else
                    <div id="img_show" class="row hidden_show">
                        <img style="margin-left: 200px;" id="img_avatar" src="{{url('image_exam/' .$exam->image)}}"/>
                    </div>
                @endif
            </div>
        </div>

        <div class="panel-heading row" style="padding-top: 2em">
            <div class="col-lg-4"></div>
            <div class="col-lg-2">
                <input style="background-color: #34ce57" type="submit" value="Lưu sửa đổi" id="btn_save" name="save">
            </div>
            <div class="col-lg-2">
                <input type="button" value="Trở lại" id="btn_enter_answer" name="enter_answer"
                       onclick="location.href='{{url()->previous()}}'">
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
                    }
                }
            });
        });
    </script>
@endsection