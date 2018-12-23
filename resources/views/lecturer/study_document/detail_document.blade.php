@extends('layout.lecturer')

@section('content')
    <div class="animated fadeIn">
        <div class="col-lg-12">
            <div class="col-lg-6">
                <form action="{{url('lecturer/study_document/update_image/'.$document->id)}}" method="post"
                      enctype="multipart/form-data" id="form_update_image">
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    <div class="form-group">
                        <label style="font-weight: normal; font-size: 15px" for="img_avatar"> Ảnh tài liệu</label>
                        <input name="img_document" type="file" id="img_user" accept=".jpg, .png, .gif, .jpeg"
                               style="height:0; width:0; visibility:hidden" class="form-control">
                    </div>
                    <div class="form-group">
                        <img id="img_avatar" src="{{url('image_document/'.$document->image)}}"
                             style="width: 500px; height: 250px;"/>
                    </div>
                    <div class="form-group" style="padding-top: 2em">
                        <div class="col-lg-3">
                            <input type="button" class="btn btn-warning text-center form-control"
                                   onclick="showImagePreview();"
                                   value="Đổi ảnh"/>
                        </div>
                        <div class="col-lg-3">
                            <input type="submit" class="btn btn-success" value="Lưu thay đổi">
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header"><strong>Thông tin tài liệu học tập</strong>
                    </div>
                    <form action="{{url('lecturer/study_document/update_info/'. $document->id)}}" method="post" enctype="multipart/form-data" id="form_update_info">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                        <div class="card-body card-block">
                            <div class="form-group">
                                <label for="name" class=" form-control-label">
                                    Tên tài liệu<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <input type="text" name="name" id="name" value="{{$document->name}}"
                                       placeholder="Tên của tài liệu" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="class_room" class="form-control-label">
                                    Lớp<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <select name="class" id="class_room" class="form-control">
                                    @foreach($class as $value)
                                        @if($value->id == $document->id_class)
                                            <option value="{{$value->id}}" selected>{{$value->name}}</option>
                                        @else
                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="subject" class="form-control-label">
                                    Môn học<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <select name="subject" id="subject" class="form-control">
                                    @foreach($subject as $value)
                                        @if($value->id == $document->id_subject)
                                            <option value="{{$value->id}}" selected>{{$value->name}}</option>
                                        @else
                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            {{-- check document is free or buy by coin --}}
                            <div class="check_free form-group">
                                <div class="form-group">
                                    <label for="type_document" class=" form-control-label">
                                        Loại tài liệu<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                    </label>
                                    <select name="type_document" onchange="select_type_document()"
                                            id="type_document" class="form-control">
                                        @if($document->type_document == 0)
                                            <option value="0" selected>Miễn phí</option>
                                            <option value="1">Trả phí</option>
                                        @else
                                            <option value="0">Miễn phí</option>
                                            <option value="1" selected>Trả phí</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            @if($document->type_document == 0)
                                <div id="div_coin" style="display: none;">
                                    <div class="form-group">
                                        <label for="price" class=" form-control-label">
                                            Giá<b style="color: #ff2e44; font-size: 14px;">(*)</b>-Đơn vị: VNĐ
                                        </label>
                                        <input type="number" id="price" name="price" value="{{$document->price}}"
                                               placeholder="Nhập giá tài liệu" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="sale" class="form-control-label">
                                            Giảm giá (nếu có) -Đơn vị: VNĐ<b
                                                    style="color: #ff2e44; font-size: 14px;"></b>
                                        </label>
                                        <input type="number" id="sale" name="sale" value="{{$document->sale}}"
                                               placeholder="Nhập giá khi đã hạ giá" class="form-control">
                                    </div>
                                </div>
                            @else
                                <div id="div_coin" style="display: block;">
                                    <div class="form-group">
                                        <label for="price" class=" form-control-label">
                                            Giá<b style="color: #ff2e44; font-size: 14px;">(*)</b>-Đơn vị: VNĐ
                                        </label>
                                        <input type="number" id="price" name="price" value="{{$document->price}}"
                                               placeholder="Nhập giá tài liệu" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="sale" class="form-control-label">
                                            Giảm giá (nếu có) -Đơn vị: VNĐ<b
                                                    style="color: #ff2e44; font-size: 14px;"></b>
                                        </label>
                                        <input type="number" id="sale" name="sale" value="{{$document->sale}}"
                                               placeholder="Nhập giá khi đã hạ giá" class="form-control">
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="introduction" class=" form-control-label">
                                    Lời giới thiệu<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <textarea name="introduce" id="introduction" cols="30" rows="10"
                                          class="form-control" required>{{$document->introduce}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="document" class=" form-control-label">
                                    File tài liệu<b style="color: #ff2e44; font-size: 14px;">
                                        (Nếu bạn không thay đổi file tài liệu thì không chọn mục này)
                                    </b>
                                </label>
                                <input type="file" name="document" id="document" accept="application/pdf">
                            </div>
                            <div class="form-group">
                                <a href="{{url('lecturer/document/'. $document->document)}}" target="_blank">
                                    <input type="button" value="Xem chi tiết tài liệu" class="btn btn-info">
                                </a>
                            </div>
                            <div class="form-group">
                                <label for="pages" class=" form-control-label">
                                    Số trang<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <input name="pages" type="number" id="pages" value="{{$document->pages}}">
                            </div>
                        </div>
                        <div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="save">
                                    <i class="fa fa-dot-circle-o"></i> Thay đổi tài liệu
                                </button>
                                <button type="reset" class="btn btn-danger">
                                    <i class="fa fa-ban"></i> Nhập lại
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- .animated -->

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
                            $('#img_avatar').attr('width', 500);
                            $('#img_avatar').attr('height', 250);
                        };
                        reader.readAsDataURL(this.files[0])
                    }
                });
            }
        }

        function select_type_document() {
            var type_document = document.getElementById('type_document').value;
            console.log(type_document);
            if (type_document == 0) {
                return free();
            } else if (type_document == 1) {
                return coin();
            }
        }

        function coin() {
            document.getElementById('div_coin').style.display = 'block';
        }

        function free() {
            document.getElementById('div_coin').style.display = 'none';
        }

        $(document).ready(function () {
            $('#form_update_image').validate({
                rules: {
                    img_user: {
                        accept: 'image/*'
                    }
                }, messages: {
                    img_user:{
                        accept: "Hãy chọn file ảnh cho tài liệu"
                    }
                }
            });

            $('#form_update_info').validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 255
                    },
                    price: {
                        required: true,
                        number: true,
                        maxlength: 20
                    },
                    sale: {
                        number: true,
                        maxlength: 20
                    },
                    pages: {
                        required: true,
                        number: true,
                        maxlength: 20
                    },
                    introduction: {
                        required: true
                    }
                },

                messages: {
                    name: {
                        required: "Vui lòng nhập tên cuốn sách",
                        maxlength: "Không được quá 255 ký tự"
                    },
                    price: {
                        required: "Giá là bắt buộc với tài liệu trả phí",
                        number: "Giá sách là số",
                        maxlength: "Giá sách nhiều nhất là 20 chữ số"
                    },
                    sale: {
                        number: "Giá sách là số",
                        maxlength: "Giá sách nhiều nhất 20 chữ số"
                    },
                    pages: {
                        required: "Vui lòng nhập vào số trang sách",
                        number: "Số trang sách là số",
                        maxlength: "Số trang sách tối đa 20 chữ số"
                    },
                    introduction: {
                        required: "Lời giới thiệu không được để trống"
                    }
                }
            });
        });

        $("#form_update_info").data("changed", false);
        // When it changes, set "changed" to true
        $("#form_update_info").on("change", function () {
            $(this).data("changed", true);
        });
        $('#form_update_info').on('submit', function () {
            if ($(this).data("changed")) {
                $('#form_update_info').submit();
            } else {
                $.alert("Bạn chưa thay đổi thông tin tài liệu!");
            }
            return false;
        });

        //check form update image
        $("#form_update_image").data("changed", false);
        $("#form_update_image").on("change", function () {
            $(this).data("changed", true);
        });
        $('#form_update_image').on('submit', function () {
            if ($(this).data("changed")) {
                $('#form_update_image').submit();
            } else {
                $.alert("Bạn chưa thay đổi ảnh bìa tài liệu");
            }
            return false;
        });
    </script>
@endsection
