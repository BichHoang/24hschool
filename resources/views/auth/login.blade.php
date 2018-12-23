@extends('user.layout.home')

@section('content')

    <style>
        .error {
            color: red;
        }

        #loginForm label {
            padding: 10px;
            font-size: 15px;
        }

        .login-form input[type=email], input[type=password] {
            width: 80%;
            padding: 10px;
            display: inline-block;
            border: none;
            background: #f1f1f1;
            float: right;
        }

        .login-form input[type=email]:focus, input[type=password]:focus {
            background-color: #ddd;
            outline: none;
        }

        a {
            color: dodgerblue;
        }

        .btnLogin {
            background-color: #4CAF50;
            color: white;
            padding: 16px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            opacity: 0.9;
        }

        .btnLoginFB {
            background-color: #0c5480;
            color: white;
            padding: 16px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            opacity: 0.9;
        }

    </style>

    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-12"></div>
                <div class="col-lg-8 col-12">
                    <div class="login-content">
                        <h5 style="text-align: center; padding-top: 15px;color: #00B069">Đăng nhập hệ thống</h5>
                        <hr>
                        <div class="login-form">
                            <form action="{{url('login')}}" method="post" id="loginForm">
                                <input type="hidden" name="_token" value="<?= csrf_token() ?>">

                                <div class="form-group">
                                    <label><b>Địa chỉ email</b>
                                        <p style="color: red; display: inline"> (*)</p></label>
                                    <input type="email" name="txf_email" id="email" class="form-control"
                                           placeholder="Email" required>
                                </div>
                                <div class="form-group">
                                    <label><b>Mật khẩu</b>
                                        <p style="color: red; display: inline"> (*)</p></label>
                                    <input type="password" name="txf_password" id="password" class="form-control"
                                           placeholder="Mật khẩu" required>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="cb_remember"> Ghi nhớ tài khoản
                                    </label>
                                    <label class="pull-right">
                                        <a href="{{url('forgot_password')}}">Quên mật khẩu?</a>
                                    </label>

                                </div>
                                <button type="submit" class="btnLogin">Đăng
                                    nhập
                                </button>
                                <div class="social-login-content">
                                    <div class="social-button">
                                        <button type="button" class="btnLoginFB"><i
                                                    class="ti-facebook"></i>Đăng nhập bằng facebook
                                        </button>
                                    </div>
                                </div>
                                <div class="register-link m-t-15 text-center" style="padding-bottom: 15px;">
                                    <p>Không có tài khoản<a href="{{url('register')}}"> Đăng ký</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-12"></div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script type="text/javascript">

        $(document).ready(function () {
            $('#loginForm').validate({
                rules: {
                    txf_email: {
                        required: true,
                        email: true,
                    },
                    txf_password: {
                        required: true,
                        minlength: 6,
                        maxlength: 20
                    },
                },

                messages: {
                    txf_email: {
                        required: "Vui lòng nhập email",
                        email: "Vui lòng nhập đúng email",
                    },
                    txf_password: {
                        required: "Vui lòng nhập mật khẩu",
                        minlength: "Mật khẩu ít nhất 6 kí tự",
                        maxlength: "Mật khẩu nhiều nhất 20 kí tự"
                    },
                }
            });
        });

    </script>


@endsection