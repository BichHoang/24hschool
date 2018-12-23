@extends('user.layout.home')
@section('content')
    <style>
        .containerDocument {
            padding: 25px 50px 0px 50px;
        }

        .boxShow {
            background: white;
        }

        .contentDocument h3 {
            color: #2ecc71;
            padding-bottom: 10px;
        }

        .boxBigImg {
            padding: 5px;
            padding-bottom: 10px;
        }

        .detailDocument {
            background: #dddddd;
            padding-top: 10px;
            border: outset;
        }

        .detailDocument h6 {
            text-align: center;
        }

        .detailDocument .row {
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
        <div class="containerDocument">
            <div class="boxShow">
                <div class="row">
                    <div class="col-lg-3 col-12">
                        <div class="boxBigImg">
                            <!--Document Image-->
                            <div class="DocumntImg">
                                <img src="{{url('image_document/'.$document->image)}}" alt="#" width="100%">
                            </div>
                            <!--End Bool Image-->
                        </div>
                        <div class="boxSmallImg">
                            <div class="demo-gallery">
                                <ul id="lightgallery">
                                    <li data-responsive="{{url('image_document/'.$document->image)}} 375, {{url('image_document/'.$document->image)}} 480, {{url('image_document/'.$document->image)}} 800"
                                        data-src="{{url('image_document/'.$document->image)}}"
                                        data-sub-html="<h4>Bìa tài liệu</h4>">
                                        <a>
                                            <img class="img-responsive"
                                                 src="{{url('image_document/'.$document->image)}}">
                                            <div class="demo-gallery-poster">
                                                <img src="{{url('image_document/'.$document->image)}}"
                                                     alt="Ảnh bìa"
                                                     title="Bìa trước" id="frontcover">
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="contentDocument">
                            <h3>{{$document->name}}</h3>
                            <div class="row">
                                @if($document->sale != 0)
                                    <div class="col-lg-6 col-12">
                                        <h4>{{$document->sale}} VNĐ</h4>
                                        <del>
                                            <span>{{$document->price}} VNĐ</span>
                                        </del>
                                    </div>
                                    <div class="col-lg-6 col-12" id="saleoff">
                                        <p>-{{round(($document->price - $document->sale)/ $document->price, 2) * 100}}
                                            %</p>
                                    </div>
                                @else
                                    <div class="col-lg-6 col-12">
                                        <h4>{{$document->price}} VNĐ</h4>
                                    </div>
                                @endif
                            </div>
                            <hr>
                            <div class="descriptionDocument">
                                <h5>Giới thiệu:</h5>
                                <p>{{$document->introduce}}</p>
                            </div>

                            <form action="{{url('user/document/add_document-'. $document->id)}}" method="post"
                                  id="form_number_document">
                                <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                <div class="row" id="quantity">
                                    <div class="col-lg-3 col-12 hover_btn" id="btn_buy_whole">
                                        <a id="buy_whole"
                                           href="{{url('user/transaction/document/buy_document/'. $document->id)}}">
                                            <input type="button" id="input_buy_whole"
                                                   style="height: 3.5em; padding: 2px; width: 100%"
                                                   value="Mua ngay">
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
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="detailDocument">
                            <h6>Thông tin chi tiết</h6>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6 col-12">Hình thức:</div>
                                <div class="col-lg-6 col-12">Bìa mềm</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">Giá bìa:</div>
                                <div class="col-lg-6 col-12">{{$document->price}}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">Giá đã sale:</div>
                                @if($document->sale == 0)
                                    <div class="col-lg-6 col-12">Không có</div>
                                @else
                                    <div class="col-lg-6 col-12">{{$document->sale}}</div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">Tác giả:</div>
                                <div class="col-lg-6 col-12">{{$document->author}}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">Số trang:</div>
                                <div class="col-lg-6 col-12">{{$document->pages}}</div>
                            </div>
                            @if($document->status == 0)
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

    </script>

@endsection
