@extends('user.layout.home')
@section('content')
    <style>
        #btBuy {
            padding: 15px 20px 15px 20px;
            color: white;
            background: #34ce57;
        }

        #boxInfo {
            border: #7da8c3 1px ridge;
            margin: 20px;
            text-align: center;
        }

        #boxInfo input[type=text], #boxInfo input[type=password], textarea {
            width: 75%;
            padding: 5px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
            float: right;
        }

        #boxInfo label {
            padding: 5px;
            margin: 5px 0 22px 0;
        }

        #boxInfo input[type=text]:focus, input[type=password]:focus {
            background-color: #ddd;
            outline: none;
        }

        .orderbt {
            background-color: #4CAF50;
            color: white;
            padding: 16px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            opacity: 0.9;
        }

        .orderbt:hover {
            opacity: 1;
        }

        #totalMoney {
            padding: 25px;
            background: #d6e9c6;
        }

        #totalMoney table td {
            padding: 10px 0px 10px 0px;
            text-align: left;
        }

        #totalMoney table th {
            font-size: 14px;
        }

        #totalMoney table thead {
            padding-bottom: 15px;
        }

        .error {
            color: red;
        }

        .pagination li.disabled {
            padding: 12px 25px;
            border: none;
            display: block;
            background: #f6f6f6;
            color: #252525;
        }

        .pagination li.active {
            padding: 12px 25px;
            border: none;
            display: block;
            background: #00B16A;
            color: white;
        }

        .pagination li a {
            padding: 12px 25px;
            border: none;
            display: block;
            background: #f6f6f6;
            color: #fff;
            color: #252525;
        }

        .pagination li:hover a {
            background: #00B16A;
            color: #fff;
        }
        
        #formOrder input, textarea {
            color: #00000b;
        }
    </style>
    <section>
        <!--Empty Cart-->
        @if(count($book) <= 0)
            <div style="text-align: center; padding: 20px;">
                <div style="border: #c4e3f3 1px">
                    <h3 style="padding-bottom: 15px;">Sản phẩm này không tồn tại hoặc hết hàng!</h3>
                    <button id="btBuy" onclick="location.href='{{url('user/book/all')}}'">Xem sách khác</button>
                </div>
            </div>
            <!--\End Empty Cart-->
    @else
        <!--Cart-->
            <div class="container">
                <div class="row">
                    <div class="col-12" id="boxInfo">
                        <div class="row">
                            <div class="col-lg-8">
                                <form action="" method="post" id="formOrder">
                                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                    <h5 style="padding: 15px;">Thông tin khách hàng</h5>
                                    <hr>
                                    <div style="text-align: left; font-size: 18px;">
                                        <label for="name"><b>Họ và tên:</b>
                                            <p style="color: red; display: inline"> *</p></label>
                                        <input type="text" id="name" placeholder="Nhập họ tên"
                                               name="customer_name" required>
                                    </div>
                                    <div style="text-align: left; font-size: 18px;">
                                        <label for="phone"><b>Số điện thoại:</b>
                                            <p style="color: red; display: inline"> *</p></label>
                                        <input type="text" placeholder="Nhập số điện thoại" name="phone" id="phone"
                                               required>
                                    </div>
                                    <div style="text-align: left; font-size: 18px;">
                                        <label for="email"><b>Email:</b>
                                            <p style="color: red; display: inline"> *</p></label>
                                        <input type="text" placeholder="Nhập địa chỉ email" name="email"
                                               value="{{Auth::user()->email}}" required>
                                    </div>
                                    <div style="text-align: left; font-size: 18px;">
                                        <label for="addr"><b>Địa chỉ:</b>
                                            <p style="color: red; display: inline"> *</p></label>
                                        <textarea name="address" id="addr" required></textarea>
                                    </div>
                                    @if($is_ebook == 0 || $is_ebook == 2)
                                        <div style="text-align: left; font-size: 18px;">
                                            <label for="pay"><b>Hình thức thanh toán:</b>
                                                <p style="color: red; display: inline"> *</p></label>
                                            <label class="radio-inline">
                                                <input type="radio" name="payment" value="1" checked>Ship COD
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="payment" value="2">Chuyển khoản
                                            </label>
                                        </div>
                                    @else
                                        <div style="text-align: left; font-size: 18px;">
                                            <label for="pay"><b>Hình thức thanh toán:</b>
                                                <p style="color: red; display: inline"> *</p></label>
                                            <label class="radio-inline">
                                                <input type="radio" name="payment" value="2" checked>Chuyển khoản
                                            </label>
                                        </div>
                                    @endif
                                    <div style="text-align: left; font-size: 18px;">
                                        <label for="id_note"><b>Ghi chú:</b></label>
                                        <textarea name="note" id="id_note"></textarea>
                                    </div>
                                    <button type="submit" class="orderbt">Đặt hàng</button>
                                </form>
                            </div>
                            <div class="col-lg-4" id="totalMoney">
                                <table>
                                    <thead>
                                    <tr>
                                        <th colspan="2"><h5>Phiếu thanh toán</h5></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Tạm tính (1 đơn hàng):</td>
                                        <td>{{$price}} VNĐ</td>
                                    </tr>
                                    @if(isset($ship))
                                        <tr>
                                            <td>Tiền ship:</td>
                                            <td>{{$ship}}VNĐ</td>
                                        </tr>
                                    @endif

                                    <tr style="background: #7da8c3; line-height: 3">
                                        <th>Tổng tiền:</th>
                                        <th style="text-align: left">{{$total}} VNĐ</th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @endif
    <!--\End Cart-->
    </section>
@endsection
@section('script')
    <script>

        $(document).ready(function () {

            $('#formOrder').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    customer_name: {
                        required: true
                    },
                    phone: {
                        required: true,
                        digits: true,
                        rangelength: [10,11]
                    },
                    address: {
                        required: true
                    }
                },

                messages: {
                    email: {
                        required: "Vui lòng nhập email",
                        email: "Vui lòng nhập đúng email",
                    },
                    customer_name: {
                        required: "Vui lòng nhập họ tên",
                    },
                    phone: {
                        required: "Nhập số điện thoại",
                        digits: "Nhập số điện thoại",
                        rangelength:"Số điện thoại không hợp lệ"
                    },
                    address: {
                        required: "Vui lòng nhập địa chỉ nhận hàng",
                    }
                }
            });
        });
    </script>
@endsection