@extends('user.layout.home')
@section('content')
    <style>
        .containerBook {
            padding: 25px 50px 0px 50px;
        }

        .boxShow {
            background: white;
        }

        .contentBook h3 {
            color: #2ecc71;
            padding-bottom: 10px;
        }

        .boxBigImg {
            padding: 5px;
            padding-bottom: 10px;
        }

        .detailBook {
            background: #dddddd;
            padding-top: 10px;
            border: outset;
        }

        .detailBook h6 {
            text-align: center;
        }

        .detailBook .row {
            padding: 7px;
        }

        #saleoff p {
            color: red;
            -webkit-animation-name: example; /* Safari 4.0 - 8.0 */
            -webkit-animation-duration: 4s; /* Safari 4.0 - 8.0 */
            -webkit-animation-iteration-count: infinite; /* Safari 4.0 - 8.0 */
            animation-name: example;
            animation-duration: 4s;
            animation-delay: 5s;
            animation-iteration-count: infinite;
        }

        /* Safari 4.0 - 8.0 */
        @-webkit-keyframes example {
            0% {
                font-size: 14px;
            }
            25% {
                font-size: 16px;
            }
            50% {
                font-size: 18px;
            }
            75% {
                font-size: 20px;
            }
            100% {
                font-size: 22px;
            }
        }

        /* Standard syntax */
        @keyframes example {
            0% {
                font-size: 14px;
            }
            25% {
                font-size: 16px;
            }
            50% {
                font-size: 18px;
            }
            75% {
                font-size: 20px;
            }
            100% {
                font-size: 22px;
            }
        }

        i {
            padding-right: 5px;
        }

        #quantity {
            padding-top: 15px;
        }

        .quantityBox button {
            padding: 15px 20px;
            border: outset;
            background: lavender;
        }

        .quantityBox input {
            padding: 8px;
            border: inset;
        }

        .quantityBox label {
            color: silver;
            font-size: 15px;
            font-style: italic;
            padding-right: 10px;
        }

        .orderbnt, #input_buy_whole {
            background: #34ce57;
            color: mintcream;
            padding: 15px 20px;
            border: outset;
        }

        .orderbtn_no {
            background: #ff2e44;
            color: mintcream;
            padding: 15px 20px;
            border: outset;
        }

        #btn_add_cart button:hover, #btn_buy_whole input:hover {
            background: transparent;
            color: #34ce57;
            border: inset;
        }
    </style>

    <section>
        <div class="containerBook">
            <div class="boxShow">
                <div class="row">
                    <div class="col-lg-3 col-12">
                        <div class="boxBigImg">
                            <!--Book Image-->
                            <div class="bookImg">
                                <img src="{{url('image_book/'.$book->previous_image)}}" alt="#" width="100%">
                            </div>
                            <!--End Bool Image-->
                        </div>
                        <div class="boxSmallImg">
                            <div class="demo-gallery">
                                <ul id="lightgallery">
                                    <li data-responsive="{{url('image_book/'.$book->previous_image)}} 375, {{url('image_book/'.$book->previous_image)}} 480, {{url('image_book/'.$book->previous_image)}} 800"
                                        data-src="{{url('image_book/'.$book->previous_image)}}"
                                        data-sub-html="<h4>Bìa trước</h4>">
                                        <a>
                                            <img class="img-responsive"
                                                 src="{{url('image_book/'. $book->previous_image)}}">
                                            <div class="demo-gallery-poster">
                                                <img src="{{url('image_book/'.$book->previous_image)}}"
                                                     alt="Ảnh bìa trước"
                                                     title="Bìa trước" id="frontcover">
                                            </div>
                                        </a>
                                    </li>
                                    <li data-responsive="{{url('image_book/'.$book->rear_image)}} 375, {{url('image_book/'.$book->rear_image)}} 480, {{url('image_book/'.$book->rear_image)}} 800"
                                        data-src="{{url('image_book/'.$book->rear_image)}}"
                                        data-sub-html="<h4>Bìa sau</h4>">
                                        <a>
                                            <img class="img-responsive"
                                                 src="{{url('image_book/'.$book->rear_image)}}">
                                            <div class="demo-gallery-poster">
                                                <img src="{{url('image_book/'.$book->rear_image)}}" alt="Ảnh bìa sau"
                                                     title="Bìa sau" id="frontcover">
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="contentBook">
                            <h3>{{$book->name}}</h3>
                            <div class="row">
                                @if($book->sale != 0)
                                    <div class="col-lg-6 col-12">
                                        <h4>{{$book->sale}} VNĐ</h4>
                                        <del>
                                            <span>{{$book->price}} VNĐ</span>
                                        </del>
                                    </div>
                                    <div class="col-lg-6 col-12" id="saleoff">
                                        <p>-{{round(($book->price - $book->sale)/ $book->price, 2) * 100}}%</p>
                                    </div>
                                @else
                                    <div class="col-lg-6 col-12">
                                        <h4>{{$book->price}} VNĐ</h4>
                                    </div>
                                @endif
                            </div>
                            <hr>
                            <div class="descriptionBook">
                                <h5>Giới thiệu:</h5>
                                <p>{{$book->introduce}}</p>
                            </div>

                            <form action="{{url('user/book/add_book-'. $book->id)}}" method="post"
                                  id="form_number_book">
                                <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                <div class="row" id="quantity">
                                    <div class="col-lg-6 col-12">
                                        <div class="quantityBox">
                                            <div>
                                                <label>Số lượng:</label>
                                                <button id="btn_giam" style="height: 3em">-</button>
                                                <input id="qty" type="number" name="qty" value="1" min="1" max="5"
                                                       style="height: 3em" required>
                                                <button id="btn_tang" style="height: 3em">+</button>
                                            </div>
                                        </div>
                                    </div>
                                    @if($book->status == 1)
                                        <div class="col-lg-3 col-12 hover_btn" id="btn_buy_whole">
                                            <a id="buy_whole"
                                               href="{{url('user/transaction/book/buy_whole/'. $book->id)}}">
                                                <input type="button" id="input_buy_whole"
                                                       style="height: 3.5em; padding: 2px; width: 100%"
                                                       value="Mua 1 bộ">
                                            </a>
                                        </div>
                                        <div class="col-lg-3 col-12" id="btn_add_cart">
                                            <a id="order">
                                                <button class="orderbnt" type="submit"
                                                        style="height: 3.5em;padding: 2px; width: 100%">
                                                    <i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng
                                                </button>
                                            </a>
                                        </div>
                                    @else
                                        <div class="col-lg-3 col-12" id="btn_add_cart">
                                            <a href="#" id="order_no">
                                                <button class="orderbtn_no">
                                                    <i class="fa fa-shopping-cart"></i>Đã hết hàng mất rồi
                                                </button>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="detailBook">
                            <h6>Thông tin chi tiết</h6>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6 col-12">Hình thức:</div>
                                <div class="col-lg-6 col-12">Bìa mềm</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">Giá bìa:</div>
                                <div class="col-lg-6 col-12">{{$book->price}}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">Giá đã sale:</div>
                                @if($book->sale == 0)
                                    <div class="col-lg-6 col-12">Không có</div>
                                @else
                                    <div class="col-lg-6 col-12">{{$book->sale}}</div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">Tác giả:</div>
                                <div class="col-lg-6 col-12">{{$book->author}}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">Số trang:</div>
                                <div class="col-lg-6 col-12">{{$book->pages}}</div>
                            </div>
                            @if($book->status == 0)
                                <div class="row">
                                    <div class="col-lg-6 col-12">Tình trạng:</div>
                                    <div class="col-lg-6 col-12">Hết hàng</div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-lg-6 col-12">Tình trạng:</div>
                                    <div class="col-lg-6 col-12">Còn hàng</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            {{--<div class="recommendation">--}}
            {{--<div class="seen">--}}
            {{--<div class="row">--}}
            {{--<div class="col-12">--}}
            {{--<div class="book-slider">--}}
            {{--@for($i=0;$i<5;$i++)--}}
            {{--<!-- Single Course -->--}}
            {{--<div class="col-lg-6 col-12">--}}
            {{--<div class="single-book">--}}
            {{--<img src="{{asset('source/images/book/book2.jpg')}}" alt="#" width="100%">--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<!--/ End Single Course -->--}}
            {{--@endfor--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="manayViewer">--}}
            {{--<div class="row"></div>--}}
            {{--</div>--}}
            {{--</div>--}}

            <div id="recommendation">
                <div class="row">
                    <div class="col-12">
                        <h4 style="font-style: italic">Sản phẩm liên quan:</h4>
                    </div>
                    <div class="col-12">
                        <div class="course-slider">
                            @for($i=1; $i<6; $i++)
                                <div class="single-course">
                                    <img src="{{asset('source/images/book/book1.jpg')}}" alt="#">
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
@section('script')
    <script>

        $(document).ready(function () {
            $('#lightgallery').lightGallery();

            var btn_reduction = $('#btn_giam');
            var btn_in = $('#btn_tang');
            var $input = $('#qty');

            btn_reduction.click(function () {
                if (parseInt($input.val()) > 1) {
                    $input.val(parseInt($input.val()) - 1);
                }
                return false;
            });

            btn_in.click(function () {
                if (parseInt($input.val()) < 5) {
                    $input.val(parseInt($input.val()) + 1);
                }
                return false;
            });
        });

        $(document).ready(function () {
            $('#order_no').confirm({
                icon: 'fa fa-bullhorn',
                content: "Thông báo hết sách",
                title: "Hết hàng",
                type: 'blue',
                typeAnimated: true,
                draggable: false,
                buttons: {
                    cancel: {
                        text: 'Đóng thông báo',
                        btnClass: 'btn-blue',
                        action: function () {
                            return;
                        }
                    }
                }
            });
        })
    </script>

@endsection
