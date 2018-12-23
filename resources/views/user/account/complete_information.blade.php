@extends('user.layout.home')

@section('content')
    <style>
        * {
            box-sizing: border-box;
        }

        /* Full-width input fields */
        .register input[type=text], input[type=password], input[type=date], input[type=number] {
            width: 100%;
            padding: 15px;
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
            color: #ff2e44;
        }
    </style>
    <!-- Faqs -->
    <section class="register">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <form action="" method="post" id="form_complete_information">
                            <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                            <h3 style="padding: 15px;">Hoàn thiện thông tin cá nhân</h3>
                            <p>Vui lòng điền vào các thông tin sau:</p>
                            <hr>
                            @if(empty($full_name))
                                <div style="text-align: left; font-size: 18px;">
                                    <label for="full_name"><b>Họ và tên</b>
                                        <p style="color: red; display: inline"> (*)</p></label>
                                    <input type="text" placeholder="Nhập họ và tên" name="full_name" id="full_name">
                                </div>
                            @endif

                            @if(empty($phone))
                                <div style="text-align: left; font-size: 18px;">
                                    <label for="phone"><b>Số điện thoại</b>
                                        <p style="color: red; display: inline"> (*)</p></label>
                                    <input type="number" placeholder="Nhập số điện thoại" name="phone" id="phone">
                                </div>
                            @endif

                            @if(empty($at_school))
                                <div style="text-align: left; font-size: 18px;">
                                    <label for="at_school"><b>Học sinh trường</b>
                                        <p style="color: red; display: inline"> (*)</p></label>
                                    <input type="text" placeholder="Nhập vào trường bạn đang học" name="at_school"
                                           id="at_school">
                                </div>
                            @endif

                            @if(empty($birthday))
                                <div style="text-align: left; font-size: 18px;">
                                    <label for="birthday"><b>Ngày sinh</b>
                                        <p style="color: red; display: inline"> (*)</p></label>
                                    <input type="date" name="birthday" id="birthday">
                                </div>
                            @endif

                            <hr>
                            <button type="submit" class="registerbtn">Lưu thông tin</button>
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
        $(document).ready(function () {
            // console.log($('#formRegister').prop('tagName'));
            $('#form_complete_information').validate({
                rules: {
                    full_name: {
                        required: true
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
                    full_name: {
                        required: "Vui lòng nhập họ tên"
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