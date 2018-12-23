@extends('layout.admin')
@section('content')
    <div class="animated fadeIn">
        <div class="row">

            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header"><strong>Thêm mới giáo viên</strong>
                    </div>
                    <form action="" method="post" id="form_create_ctv">
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
                                <label for="email" class=" form-control-label">
                                    Email<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <input type="email" name="email" id="email" required
                                       placeholder="Email của giáo viên" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="txt_full_name" class=" form-control-label">
                                    Họ và tên<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <input type="text" name="full_name" id="txt_full_name" value="{{old('full_name')}}"
                                       placeholder="Họ tên của giáo viên" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class=" form-control-label">
                                    Mật khẩu<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <input type="password" id="password" name="password"
                                       placeholder="Nhập mật khẩu" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="re_password" class=" form-control-label">
                                    Nhập lại mật khẩu<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <input type="password" id="re_password" name="re_password"
                                       placeholder="Nhập lại mật khẩu" class="form-control">
                            </div>
                            {{--<div class="form-group">--}}
                            {{--<label for="birthday" class=" form-control-label">--}}
                            {{--Ngày sinh<b style="color: #ff2e44; font-size: 14px;">(*)</b>--}}
                            {{--</label>--}}
                            {{--<input type="date" id="birthday" name="birthday" class=" form-control image_date_chose"--}}
                            {{--placeholder="Nhập ngày sinh" >--}}
                            {{--</div>--}}
                            <div class="form-group">
                                <label for="phone" class=" form-control-label">
                                    Số điện thoại<b style="color: #ff2e44; font-size: 14px;">(*)</b>
                                </label>
                                <input type="number" id="phone" name="phone" value="{{old('phone')}}"
                                       placeholder="Nhập số điện thoại" class="form-control">
                            </div>
                        </div>
                        <div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="save">
                                    <i class="fa fa-dot-circle-o"></i> Tạo giáo viên
                                </button>
                                <button type="reset" class="btn btn-danger">
                                    <i class="fa fa-ban"></i> Reset
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
        $(document).ready(function () {
            $('#form_create_ctv').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    txt_full_name: {
                        required: true
                    },
                    password: {
                        required: true,
                        rangelength: [6, 20]
                    },
                    re_password: {
                        required: true,
                        equalTo: '[name="password"]'
                    },
                    phone: {
                        required: true,
                        digits: true,
                        rangelength: [10,11]
                    }
                },
                messages: {
                    email: {
                        required: "Trường email là bắt buộc",
                        email: "Nhập sai định dạng email"
                    },
                    txt_full_name:{
                        required: "Trường này là bắt buộc"
                    },
                    password: {
                        required: "Trường này là bắt buộc",
                        rangelength: "Mật khẩu nhận từ 6 đến 20 ký tự"
                    },
                    re_password: {
                        requried: "Trường này là băt buộc",
                        equalTo:"Mật khẩu không khớp"
                    },
                    phone:{
                        required: "Trường này là bắt buộc",
                        digits: "Số điện thoại chỉ nhận chữ số",
                        rangelength: "Số điện thoại có 10 hoặc 11 số"
                    }
                }
            });
        });

    </script>
@endsection
