@extends('user.layout.home')
@section('content')
    <style>
        #btBuy {
            padding: 15px 20px 15px 20px;
            color: white;
            background: #34ce57;
        }

        #boxCart {
            border: #7da8c3 1px ridge;
            margin: 20px;
            text-align: center;
        }

        #boxCart h4 {
            text-align: center;
            line-height: 1.5;
            color: #2ecc71;
        }

        #headContent {
            font-size: 16px;
            font-weight: bold;
        }

        #contentCart {
            line-height: 13;
            background: #f6f6f6;
            margin: 5px;
        }

        #nameProduct {
            font-style: italic;
            color: #7a43b6;
            font-size: 15px;
            line-height: 1.5em;
            margin: auto;

        }

        #btAddProduct {
            padding: 15px 20px 15px 20px;
            background: #34ce57;
            color: white;
        }

        #btDeleteAllBook {
            padding: 15px;
            background: red;
            color: white;
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

        .oderbt {
            background-color: #4CAF50;
            color: white;
            padding: 16px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            opacity: 0.9;
        }

        .oderbt:hover {
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
        @if(count($data) <= 0)
            <div style="text-align: center; padding: 20px;">
                <div style="border: #c4e3f3 1px">
                    <h3 style="padding-bottom: 15px;">Giỏ sách của bạn đang trống!</h3>
                    <button id="btBuy" onclick="location.href='{{url('user/book/all')}}'">Mua ngay</button>
                </div>
            </div>
            <!--\End Empty Cart-->
    @else
        <!--Cart-->
            <div class="container">
                <div class="row">
                    <div class="col-12" id="boxCart">
                        <div style="margin: 15px;">
                            <div>
                                <h4>Giỏ sách của bạn</h4>
                                <hr>
                            </div>
                            <div class="row" id="headContent">
                                <div class="col-lg-2 col-12">Hình ảnh</div>
                                <div class="col-lg-3 col-12">Tên sản phẩm</div>
                                <div class="col-lg-2 col-12">Giá sản phẩm</div>
                                <div class="col-lg-2 col-12">Số lượng</div>
                                <div class="col-lg-2 col-12">Giá đã sale</div>
                                <div class="col-lg-1 col-12">Gỡ bỏ</div>
                            </div>
                            <hr>
                            @foreach($data as $book)
                                <div class="row" id="contentCart">
                                    <div class="col-lg-2 col-12">
                                        <img src="{{url('image_book/'. $book->previous_image)}}" width="100%">
                                    </div>
                                    <div class="col-lg-3 col-12" id="nameProduct">{{$book->name}}</div>
                                    @if($book->type_book == 0)
                                        <div class="col-lg-2 col-12">Miễn phí</div>
                                    @else
                                        <div class="col-lg-2 col-12">{{$book->price}}</div>
                                    @endif
                                    <div class="col-lg-2 col-12">
                                        {{$book->number}}
                                    </div>
                                    @if($book->sale == 0)
                                        <div class="col-lg-2 col-12">Không có</div>
                                    @else
                                        <div class="col-lg-2 col-12">{{$book->sale}}</div>
                                    @endif
                                    <div class="col-lg-1 col-12" style="text-align: center">
                                        <a class="delete_a_book" href="{{url('user/book/delete_book-'. $book->id)}}">
                                            <i class="fa fa-remove" style="font-size:24px;color:red"
                                               title="Xóa sản phẩm"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                            <hr>
                            <div class="row" style="padding-top: 50px">
                                <div class="col-12">
                                    <!-- Start Pagination -->
                                {{$data->render()}}
                                <!--/ End Pagination -->
                                </div>
                            </div>
                            <hr>
                            <!--Button-->
                            <div class="row">
                                <div class="col-sm-8"></div>
                                <div class="col-sm-2">
                                    <button id="btAddProduct" onclick="location.href='{{url('user/book/all')}}'">
                                        Thêm sản phẩm
                                    </button>
                                </div>

                                <div class="col-sm-2">
                                    <a class="delete_all_book" href="{{url('user/book/delete_all_book')}}">
                                        <button id="btDeleteAllBook">
                                            Xóa tất cả giỏ sách
                                        </button>
                                    </a>
                                </div>

                            </div>
                            <!--\End Button-->
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12" id="boxInfo">
                        <div class="row">
                            <div class="col-lg-8">
                                <form action=""
                                      method="post" id="formOrder">
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
                                        <input type="text" placeholder="Nhập địa chỉ email" name="email" required
                                               value="{{Auth::user()->email}}">
                                    </div>
                                    <div style="text-align: left; font-size: 18px;">
                                        <label for="addr"><b>Địa chỉ:</b>
                                            <p style="color: red; display: inline"> *</p></label>
                                        <textarea name="address" id="addr" required></textarea>
                                    </div>
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
                                    <div style="text-align: left; font-size: 18px;">
                                        <label for="id_note"><b>Ghi chú:</b></label>
                                        <textarea name="note" id="id_note"></textarea>
                                    </div>
                                    <button type="submit" class="oderbt">Đặt hàng</button>
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
                                        <td>Tạm tính ({{$count}} đơn hàng):</td>
                                        <td>{{$price}} VNĐ</td>
                                    </tr>
                                    <tr>
                                        <td>Phí giao hàng:</td>
                                        <td>{{$ship}} VNĐ</td>
                                    </tr>
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
        function validatePhone() {
            var a = document.getElementById('phone').value;
            if (a.length > 9 && a.length <= 15) {
                var filter = /^[0-9-+]+$/;
                if (filter.test(a)) {
                    return true;
                }
                else {
                    return false;
                }
            } else {
                return false;
            }

        }

        jQuery.validator.addMethod("phoneValidate", function (number, element) {
            number = validatePhone();
            return this.optional(element) || number;
        }, "Please specify a valid phone number");
        $(document).ready(function () {

            $('a.delete_a_book').confirm({
                icon: 'fa fa-bullhorn',
                content: "Xóa cuốn sách trong giỏ",
                title: "Thông báo",
                type: 'red',
                typeAnimated: true,
                draggable: false,
                buttons: {
                    xoa_sach: {
                        text: 'Xóa sách',
                        btnClass: 'btn-red',
                        action: function () {
                            location.href = this.$target.attr('href');
                        }
                    },
                    cancel: function () {
                        return;
                    }
                }
            });

            $('a.delete_all_book').confirm({
                icon: 'fa fa-bullhorn',
                content: "Xóa tất cả sách trong giỏ",
                title: "Thông báo",
                type: 'red',
                typeAnimated: true,
                draggable: false,
                buttons: {
                    xoa_sach: {
                        text: 'Xóa sách',
                        btnClass: 'btn-red',
                        action: function () {
                            location.href = this.$target.attr('href');
                        }
                    },
                    cancel: function () {
                        return;
                    }
                }
            });

            $('#formOrder').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    full_name: {
                        required: true
                    },
                    phone: {
                        phoneValidate: true
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
                    full_name: {
                        required: "Vui lòng nhập họ tên",
                    },
                    phone: {
                        phoneValidate: "Nhập số điện thoại"
                    },
                    address: {
                        required: "Vui lòng nhập địa chỉ nhận hàng",
                    }
                }
            });
        });
    </script>
@endsection
{{--@section('iconCart')--}}
{{--<style>--}}
{{--#cart {--}}
{{--position: absolute;--}}
{{--top: 15px;--}}
{{--right: -70px;--}}
{{--}--}}

{{--#number {--}}
{{--position: absolute;--}}
{{--top: 12px;--}}
{{--right: -65px;--}}
{{--z-index: 100000;--}}
{{--}--}}
{{--</style>--}}
{{--<!--Shopping Cart-->--}}
{{--<div id="cart">--}}
{{--<a href="{{url('user/book/my_cart')}}">--}}
{{--<i class="fa fa-shopping-cart" style="font-size:30px;color: #34ce57"--}}
{{--title="Bạn có 3 sản phẩm trong giỏ hàng"></i>--}}
{{--</a>--}}
{{--</div>--}}
{{--<p style="color: red; font-size: 15px;" id="number">3</p>--}}
{{--<!--\End Shopping Cart-->--}}
{{--@endsection--}}