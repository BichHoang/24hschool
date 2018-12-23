@extends('layout.lecturer')
@section('content')
    <div class="animated fadeIn">
        <div class="row">

            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header"><strong>Thêm tài liệu học tập</strong>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data" id="form_create_document">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                        <div class="card-body card-block">
                            <div class="form-group">
                                <label for="name" class=" form-control-label">
                                    Tên tài liệu<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <input type="text" name="name" id="name" value="{{old('name')}}"
                                       placeholder="Tên của tài liệu" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="class_room" class="form-control-label">
                                    Lớp<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <select name="class" id="class_room" class="form-control">
                                    @foreach($class as $value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="subject" class="form-control-label">
                                    Môn học<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <select name="subject" id="subject" class="form-control">
                                    @foreach($subject as $value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
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
                                        <option value="0" selected>Miễn phí</option>
                                        <option value="1">Trả phí</option>
                                    </select>
                                </div>
                            </div>
                            <div id="div_coin" style="display: none;">
                                <div class="form-group">
                                    <label for="price" class=" form-control-label">
                                        Giá<b style="color: #ff2e44; font-size: 14px;">(*)</b>-Đơn vị: VNĐ
                                    </label>
                                    <input type="number" id="price" name="price" value="{{old('price')}}"
                                           placeholder="Nhập giá tài liệu" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="sale" class="form-control-label">
                                        Giảm giá (nếu có) -Đơn vị: VNĐ<b style="color: #ff2e44; font-size: 14px;"></b>
                                    </label>
                                    <input type="number" id="sale" name="sale" value="{{old('sale')}}"
                                           placeholder="Nhập giá khi đã hạ giá" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="introduction" class=" form-control-label">
                                    Lời giới thiệu<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <textarea name="introduce" id="introduction" cols="30" rows="10"
                                          class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="document" class=" form-control-label">
                                    File tài liệu<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <input name="document" type="file" id="document" accept=".pdf"
                                       oninvalid="setCustomValidity('Hãy nhập file tài liệu')">
                            </div>
                            <div class="form-group">
                                <label for="pages" class=" form-control-label">
                                    Số trang<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <input name="pages" type="number" id="pages">
                            </div>
                            <div class="form-group">
                                <label style="font-weight: normal; font-size: 15px" for="img_avatar"> Ảnh tài liệu</label>
                                <input name="img_document" type="file" id="img_user" accept="image/*" class="required"
                                       style="height:0; width:0; visibility:hidden">
                            </div>
                            <div class="form-group">
                                <img id="img_avatar" src=""/>
                            </div>
                            <div class="form-group" style="padding-top: 2em">
                                <input type="button" class="btn btn-warning text-center form-control"
                                       onclick="showImagePreview();"
                                       value="Thêm ảnh"/>
                            </div>
                        </div>
                        <div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="save">
                                    <i class="fa fa-dot-circle-o"></i> Thêm tài liệu
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
            $('#form_create_document').validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 200
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
                    },
                    img_user: {
                        required: true
                    },
                    document: {
                        required: true,
                        accept: "application/pdf"
                    }
                },
                messages: {
                    name: {
                        required: "Vui lòng nhập tên cuốn sách",
                        maxlength: "Không được quá 200 ký tự"
                    },
                    price: {
                        required: "Vui lòng nhập giá cuốn sách",
                        number: "Giá sách là số",
                        maxlength: "Giá sách nhiều nhất là 20 chữ số"
                    },
                    sale: {
                        number: "Giá sách là số",
                        maxlength: "Giá sách nhiều nhất 20 chữ số"
                    },
                    pages: {
                        required: "Vui lòng nhập vào số trang tài liệu",
                        number: "Số trang tài liệu là số",
                        maxlength: "Số trang tài liệu tối đa 20 chữ số"
                    },
                    introduction: {
                        required: "Lời giới thiệu không được để trống"
                    },
                    img_user: {
                        required: "Bạn chưa nhập ảnh tài liệu"
                    },
                    document: {
                        required: "Hãy nhập file tài liệu",
                        accept: "File tài liệu yêu cầu nhập file pdf"
                    }
                }
            });
        });
    </script>
@endsection
