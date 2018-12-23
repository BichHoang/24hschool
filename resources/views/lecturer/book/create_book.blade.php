@extends('layout.lecturer')
@section('content')
    <div class="animated fadeIn">
        <div class="row">

            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header"><strong>Thêm sách</strong>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data" id="form_create_book">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $err)
                                    {{$err}}
                                @endforeach
                            </div>
                        @endif

                        <div class="card-body card-block">
                            <div class="form-group">
                                <label for="name" class=" form-control-label">
                                    Tên sách<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <input type="text" name="name" id="name"
                                       placeholder="Tên của cuốn sách" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="author" class=" form-control-label">
                                    Tác giả<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <input type="text" name="author" id="author"
                                       placeholder="Họ tên của tác giả" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="topic" class=" form-control-label">
                                    Thể loại<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <select name="topic" id="topic" style="width: 100%; height: 2.5em;">
                                    @foreach($topic as $tp)
                                        <option value="{{$tp->id}}">{{$tp->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="publication_date" class=" form-control-label">
                                    Ngày xuất bản<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <input type="date" name="publication_date" id="publication_date"
                                       class="form-control">
                            </div>
                            {{-- check book is free or buy by coin --}}
                            <div class="check_free form-group">
                                <div class="form-group">
                                    <label for="type_book" class=" form-control-label">
                                        Loại sách<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                    </label>
                                    <select name="type_book" onchange="select_type_book()" id="type_book"
                                            class="form-control">
                                        <option value="0" selected>Miễn phí</option>
                                        <option value="1">Trả phí</option>
                                    </select>
                                </div>
                            </div>
                            <div id="div_coin" style="display: none;">
                                <div class="form-group">
                                    <label for="price" class=" form-control-label">
                                        Giá sách bản cứng<b style="color: #ff2e44; font-size: 14px;">(*)</b> -Đơn vị:
                                        VNĐ
                                    </label>
                                    <input type="number" id="price" name="price"
                                           placeholder="Nhập giá cuốn sách" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="sale" class="form-control-label">
                                        Giảm giá (nếu có)-Đơn vị: VNĐ<b style="color: #ff2e44; font-size: 14px;"></b>
                                    </label>
                                    <input type="number" id="sale" name="sale" value="{{old('sale')}}"
                                           placeholder="Nhập giá khi đã hạ giá" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="price_of_ebook" class="form-control-label">
                                        Giá ebook <b style="color: #ff2e44; font-size: 14px;">(*)</b> -Đơn vị: VNĐ
                                    </label>
                                    <input type="number" id="price_of_ebook" name="price_of_ebook"
                                           placeholder="Nhập giá ebook" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pages" class=" form-control-label">
                                    Số trang<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <input type="number" id="pages" name="pages"
                                       placeholder="Nhập số trang sách" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="introduction" class=" form-control-label">
                                    Lời giới thiệu<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <textarea name="introduce" id="introduction" cols="30" rows="10"
                                          class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="ebook" class=" form-control-label">
                                    File ebook<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <input name="ebook" type="file" id="ebook" accept="application/pdf"
                                       oninvalid="setCustomValidity('Hãy nhập file ebook của cuốn sách')">
                            </div>
                            <div class="form-group">
                                <label style="font-weight: normal; font-size: 15px" for="img_avatar"> Ảnh mặt
                                    trước</label>
                                <input name="img_previous" type="file" id="img_previous" accept="image/*"
                                       class="required"
                                       oninvalid="setCustomValidity('Hãy nhập file ảnh cho cuốn sách')"
                                       style="height:0; width:0; visibility:hidden">
                            </div>
                            <div class="form-group">
                                <img id="img_avatar_previous" src=""/>
                            </div>
                            <div class="form-group" style="padding-top: 2em">
                                <input type="button" class="btn btn-warning text-center form-control" style="width: 33%"
                                       onclick="showImagePreviewPrevious();"
                                       value="Thêm ảnh mặt trước"/>
                            </div>
                            <div class="form-group">
                                <label style="font-weight: normal; font-size: 15px" for="img_avatar"> Ảnh mặt
                                    sau</label>
                                <input name="img_rear" type="file" id="img_rear" accept="image/*"
                                       class="required"
                                       oninvalid="setCustomValidity('Hãy nhập file ảnh cho cuốn sách')"
                                       style="height:0; width:0; visibility:hidden">
                            </div>
                            <div class="form-group">
                                <img id="img_avatar_rear" src=""/>
                            </div>
                            <div class="form-group" style="padding-top: 2em">
                                <input type="button" class="btn btn-warning text-center form-control" style="width: 33%"
                                       onclick="showImagePreviewRear();"
                                       value="Thêm ảnh mặt sau"/>
                            </div>
                        </div>
                        <div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="save">
                                    <i class="fa fa-dot-circle-o"></i> Thêm sách
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
        function showImagePreviewPrevious() {
            var fileInput = $("#img_previous");
            if (fileInput !== null) {
                //Mở cửa sổ và chọn anhr
                fileInput.trigger("click");
                fileInput.change(function () {
                    if (this.files && this.files[0]) {
                        // Sau khi chọn xong ảnh sẽ chuyển ảnh sang mã Base64 và đọc
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#img_avatar_previous').attr('src', e.target.result);
                            $('#img_avatar_previous').attr('width', 500);
                            $('#img_avatar_previous').attr('height', 250);
                        };
                        reader.readAsDataURL(this.files[0])
                    }
                });
            }
        }

        function showImagePreviewRear() {
            var fileInput = $("#img_rear");
            if (fileInput !== null) {
                //Mở cửa sổ và chọn anhr
                fileInput.trigger("click");
                fileInput.change(function () {
                    if (this.files && this.files[0]) {
                        // Sau khi chọn xong ảnh sẽ chuyển ảnh sang mã Base64 và đọc
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#img_avatar_rear').attr('src', e.target.result);
                            $('#img_avatar_rear').attr('width', 500);
                            $('#img_avatar_rear').attr('height', 250);
                        };
                        reader.readAsDataURL(this.files[0])
                    }
                });
            }
        }

        function select_type_book() {
            var type_book = document.getElementById('type_book').value;
            console.log(type_book);
            if (type_book == 0) {
                return free();
            } else if (type_book == 1) {
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
            // debugger
            $('#form_create_book').validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 200
                    },
                    author: {
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
                    price_of_ebook: {
                        required: true,
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
                    publication_date: {
                        required: true,
                        date: true
                    },
                    img_user: {
                        required: true
                    },
                    ebook: {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: "Vui lòng nhập tên cuốn sách",
                        maxlength: "Không được quá 200 ký tự"
                    },
                    author: {
                        required: "Vui lòng nhập tên tác giả",
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
                    price_of_ebook: {
                        required: "Vui lòng nhập giá cuốn sách",
                        number: "Giá sách là số",
                        maxlength: "Giá sách nhiều nhất là 20 chữ số"
                    },
                    pages: {
                        required: "Vui lòng nhập vào số trang sách",
                        number: "Số trang sách là số",
                        maxlength: "Số trang sách tối đa 20 chữ số"
                    },
                    introduction: {
                        required: "Lời giới thiệu không được để trống"
                    },
                    img_user: {
                        required: "Bạn chưa tải ảnh lên"
                    },
                    publication_date: {
                        required: "Hãy nhập ngày xuất bản",
                        date: "Không đúng định dạng ngày tháng năm"
                    },
                    ebook: {
                        required: "Hãy nhập file ebook cho cuốn sách",
                    }
                }
            });
        });

    </script>
@endsection
