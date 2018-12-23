@extends('user.layout.home')

@section('content')
    <style>
        * {
            box-sizing: border-box;
        }

        /* Full-width input fields */
        .register input[type=text], input[type=password], input[type=date], input[type=number] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
        }

        .register input[type=text]:focus, input[type=password]:focus {
            background-color: #ddd;
            outline: none;
        }

        /* Overwrite default styles of hr */
        hr {
            border: 1px solid #f1f1f1;
            margin-bottom: 25px;
        }

        /* Set a style for the submit button */
        .registerbtn {
            background-color: #4CAF50;
            color: white;
            padding: 16px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            opacity: 0.9;
        }

        .registerbtn:hover {
            opacity: 1;
        }

        /* Add a blue text color to links */
        a {
            color: dodgerblue;
        }

        /* Set a grey background color and center the text of the "sign in" section */
        .signin {
            background-color: #f1f1f1;
            text-align: center;
        }
        .error {
            color:#ff2e44;
        }
    </style>
    <!-- Faqs -->
    <section class="register">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <form action="" method="post" id="formRegister">
                            <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                            <h3 style="padding: 15px;">Đăng ký thành viên</h3>
                            <p>Vui lòng điền vào các thông tin sau:</p>
                            <hr>
                            @if(count($errors)>0)
                                <div class="alert alert-danger">
                                    @foreach($errors->all() as $err)
                                        {{$err}}
                                    @endforeach
                                </div>
                            @endif
                            <div style="text-align: left; font-size: 18px;">
                                <label for="email"><b>Email</b><p style="color: red; display: inline"> (*)</p></label>
                                <input type="text" placeholder="Nhập địa chỉ email" name="email"
                                       value="{{old('email')}}" required>
                            </div>
                            <div style="text-align: left; font-size: 18px;">
                                <label for="full_name"><b>Họ và tên</b><p style="color: red; display: inline"> (*)</p></label>
                                <input type="text" placeholder="Nhập họ tên" name="full_name"
                                       value="{{old('full_name')}}" required>
                            </div>
                            <div style="text-align: left; font-size: 18px;">
                                <label for="psw"><b>Mật khẩu</b><p style="color: red; display: inline"> (*)</p></label>
                                <input type="password" placeholder="Nhập mật khẩu" name="password" required>
                            </div>
                            <div style="text-align: left; font-size: 18px;">
                                <label for="psw-repeat"><b>Nhập lại mật khẩu</b><p style="color: red; display: inline"> (*)</p></label>
                                <input type="password" placeholder="Nhập lại mật khẩu" name="re_password" required>
                            </div>
                            <div style="text-align: left; font-size: 18px;">
                                <label for="phone"><b>Số điện thoại</b>
                                    <p style="color: red; display: inline"> (*)</p></label>
                                <input type="number" placeholder="Nhập số điện thoại" name="phone" id="phone"
                                    value="{{old('phone')}}" required>
                            </div>
                            <div style="text-align: left; font-size: 18px;">
                                <label for="at_school"><b>Học sinh trường</b>
                                    <p style="color: red; display: inline"> (*)</p></label>
                                <input type="text" placeholder="Nhập vào trường bạn đang học" name="at_school"
                                       id="at_school" value="{{old('at_school')}}">
                            </div>
                            <div style="text-align: left; font-size: 18px;">
                                <label for="birthday"><b>Ngày sinh</b>
                                    <p style="color: red; display: inline"> (*)</p></label>
                                <input type="date" name="birthday" id="birthday" value="{{old('birthday')}}">
                            </div>
                            <hr>
                            <p>Bằng cách bấm đăng ký bạn đã đồng ý với <a href="#">Chính sách và Điều khoản</a> của
                                chúng tôi.</p>

                            <button type="submit" class="registerbtn">Đăng ký</button>

                            <div class="container signin">
                                <p>Bạn đã có tài khoản? <a href="{{url('login')}}">Đăng nhập</a>.</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Faqs -->


@endsection
@section('script')
    <script type="text/javascript">
        $.validator.addMethod("nameValidate", function (value, element) {
            return this.optional(element) || isValidString(value);
        }, "Lỗi họ tên");

        function isValidString(str) {
            var filter = /[A-Z a-z]/;
            var value = str.toString();
            for(i = 0; i < value.length; i++){
                if(filter.test(value.charAt(i)) == true){
                } else {return false;}
            }
        }

        $(document).ready(function () {
            // console.log($('#formRegister').prop('tagName'));
            $('#formRegister').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    full_name: {
                        required: true
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 20
                    },
                    re_password: {
                        required: true,
                        equalTo: '[name="password"]'
                    },
                    phone: {
                        required: true,
                        digits: true,
                        rangelength: [10,11]
                    },
                    at_school: {
                        required: true
                    },
                    birthday: {
                        required: true,
                        date: true
                    }

                },

                messages: {
                    email: {
                        required: "Vui lòng nhập email",
                        email: "Vui lòng nhập đúng email",
                    },
                    full_name: {
                        required: "Vui lòng nhập họ tên",
                    },
                    password: {
                        required: "Vui lòng nhập mật khẩu",
                        minlength: "Mật khẩu ít nhất 6 kí tự",
                        maxlength: "Mật khẩu nhiều nhất là 20 kí tự"
                    },
                    re_password: {
                        required: "Nhập lại mật khẩu",
                        equalTo: "Mật khẩu không khớp"
                    },
                    phone: {
                        required: "Vui lòng nhập số điện thoại của bạn",
                        digits: "Số điện thoại chỉ nhận chữ số",
                        rangelength: "Số điện thoại từ 10 đến 11 số"
                    },
                    at_school: {
                        required: "Vui lòng nhập trường bạn đang học"
                    },
                    birthday: {
                        required: "Vui lòng nhập ngày sinh của bạn",
                        date: "Nhập ngày sinh không đúng định dạng"
                    }
                }
            });
        });

    </script>

@endsection