@extends('user.layout.home')
@section('content')
    <style>
        .option-box-wrap {
            width: 100%;
            display: table;
            background: #fff;
            padding-top: 10px;
        }

        .option-box .btn-group.sort-box {
            margin-bottom: 0;
            margin-right: 10px;
        }

        .option-box .btn-group.sort-box > span {
            color: #4a4a4a;
            font-size: 14px;
        }

        .sort-box ul.sort-list li a {
            font-weight: 400;
            color: #898989;
            padding: 9px 10px 11px;
            display: inline-block;
            font-size: 14px;
        }

        .sort-box ul.sort-list li {
            display: inline-block;
            font-size: 0;
            vertical-align: middle;
        }

        .sort-box ul.sort-list {
            display: inline-block;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .learnedu-sidebar .search {
            position: relative;
        }

        .search input {
            width: 100%;
            height: 52px;
            box-shadow: none;
            text-shadow: none;
            border: none;
            border: 1px solid #00B16A;
            font-size: 16px;
            color: #6c6c6c;
            padding: 0 48px 0 20px;
        }

        .search .button {
            position: absolute;
            right: 0;
            top: 0;
            width: 50px;
            height: 52px;
            line-height: 52px;
            box-shadow: none;
            text-shadow: none;
            text-align: center;
            border: none;
            font-size: 15px;
            color: #fff;
            -webkit-transition: all 0.4s ease;
            -moz-transition: all 0.4s ease;
            transition: all 0.4s ease;
            border-radius: 0px;
            background-color: #00B16A;
        }

        .search .button:hover {
            background: #2ecc71;
            color: #00000b;
        }

        .option-box span {
            line-height: 3.5;
            font-style: italic;
            font-weight: bold;
        }

        #buybt {
            background: green;
            line-height: 1.5;
            color: white;
            padding: 5px;
        }

        #info ul li {
            padding-bottom: 5px;
        }

        #info i {
            padding-right: 5px;
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

        h6.blog-title{
            display: -webkit-box;
            line-height: 1.5em;
            height: 3em;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

    </style>
    <section>
        <div class="" style="margin: 25px 40px 10px 40px;">
            <div class="row">
                <div class="col-lg-3 col-12">
                    <div class="learnedu-sidebar left">
                        <!-- Categories -->
                        <div class="single-widget categories">
                            <h3 class="title">Danh mục sản phẩm</h3>
                            <ul>
                                @for($i=0;$i<5;$i++)
                                    <li><a href="#"><i class="fa fa-book"></i>Sách Toán</a></li>
                                @endfor
                            </ul>
                        </div>
                        <!--/ End Categories -->
                        <!-- Tác giả -->
                        <div class="single-widget categories">
                            <h3 class="title">Tác giả nổi tiếng</h3>
                            <ul>
                                @for($i=0;$i<5;$i++)
                                    <li><a href="#"><i class="fa fa-user-secret"></i>Tên tác giả</a></li>
                                @endfor
                            </ul>
                        </div>
                        <!--/ End Tác giả -->
                    </div>
                </div>
                <div class="col-lg-9 col-12">
                    <div class="topContent">
                        <div class="option-box">
                            <div class="sort-box-holder">
                                <div class="btn-group pull-left sort-box">
                                    <span class="show">Ưu tiên xem: </span>
                                    <ul class="sort-list">
                                        <li class=""
                                            data-order="newest">
                                            <a href="javascript:void(0);">HÀNG MỚI</a>
                                        </li>
                                        <li class="" data-order="top_seller">
                                            <a href="javascript:void(0);">BÁN CHẠY</a>
                                        </li>
                                        <li class=""
                                            data-order="discount_percent,desc">
                                            <a href="javascript:void(0);">GIẢM GIÁ NHIỀU</a>
                                        </li>

                                        <li class="" data-order="price,asc">
                                            <a href="javascript:void(0);">GIÁ THẤP</a>
                                        </li>
                                        <li class="" data-order="price,desc">
                                            <a href="javascript:void(0);">GIÁ CAO</a>
                                        </li>

                                        <li class="" data-order="position">
                                            <a href="javascript:void(0);">CHỌN LỌC</a>
                                        </li>
                                        <li class="">
                                            <div class="search">
                                                <form action="{{url('user/book/search-%20')}}" method="post">
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                    <div class="form">
                                                        <input type="text" placeholder="Tìm kiếm sản phẩm ..."
                                                               name="search_book">
                                                        <button class="button"><i class="fa fa-search"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div style="clear: both; padding-bottom: 15px;"></div>
                        <div class="row" style="border-top: #2ecc71 1px double">
                            @foreach($book as $value)
                                <div class="col-lg-4 col-12" style="padding: 10px 5px 0px 5px; height: 100%;">
                                    <div class="" style="border: 1px solid #e6e6e6;">
                                        <div style="text-align: center;">
                                            <h6 class="blog-title">{{$value->name}}</h6>
                                            <p style="line-height: 2;">{{$value->author}}</p>
                                        </div>
                                        <div class="row" style="height: 250px;">
                                            <div class="col-lg-7 col-12">
                                                <img src="{{url('image_book/'. $value->previous_image)}}"
                                                     alt="Ảnh bìa cuốn sách" width="100%" height="100%">
                                            </div>
                                            <div id="info" class="col-lg-5 col-12">
                                                <ul>
                                                    @if($value->type_book == 0)
                                                        <li style="color: #00b3ee;"><i>Miễn phí</i>
                                                        </li>
                                                    @else
                                                        <li style="color: #00b3ee;"><i
                                                                    class="fa fa-money"> {{$value->price}} VNĐ</i>
                                                        </li>
                                                    @endif
                                                    @if($value->status == 0)
                                                        <li style="color: #00B069;"><i class="fa fa-cubes">Hết hàng</i>
                                                        </li>
                                                    @else
                                                        <li style="color: #00B069;"><i class="fa fa-cubes">Còn hàng</i>
                                                        </li>
                                                    @endif
                                                    <li style="color: #7a43b6">
                                                        <a href="{{url('user/transaction/book/buy_ebook/'. $value->id)}}">
                                                            <i class="fa fa-cart-plus">Mua ngay ebook</i>
                                                        </a>
                                                    </li>
                                                    <li style="color: #2a435c"><i class="fa fa-eye"> {{$value->seen}}
                                                            lượt xem</i>
                                                    </li>
                                                    <li style="padding-top: 5px;">
                                                        <button onclick="location.href='{{url('user/book/detail/'. $value->id)}}'"
                                                                id="buybt">
                                                            <i class="fa fa-arrow-circle-right"></i>Xem chi tiết
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div style="clear: both"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row" style="padding-top: 50px">
                            <div class="col-12">
                                <!-- Start Pagination -->
                            {{$book->render()}}
                            <!--/ End Pagination -->
                            </div>
                        </div>
                    </div>
                    <div class="row"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
