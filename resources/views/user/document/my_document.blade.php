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
                <div class="col-lg-12 col-12">
                    <div class="topContent">
                        <div style="clear: both; padding-bottom: 15px;"></div>
                        <div class="row" style="border-top: #2ecc71 1px double">
                            @foreach($document as $value)
                                <div class="col-lg-4 col-12" style="padding: 10px 5px 0px 5px; height: 100%;">
                                    <div class="" style="border: 1px solid #e6e6e6;">
                                        <div style="text-align: center;">
                                            <h6 class="blog-title">{{$value->name}}</h6>
                                        </div>
                                        <div class="row" style="height: 250px;">
                                            <div class="col-lg-7 col-12">
                                                <img src="{{url('image_document/'. $value->image)}}"
                                                     alt="Ảnh bìa cuốn sách" width="100%" height="100%">
                                            </div>
                                            <div id="info" class="col-lg-5 col-12">
                                                <ul>
                                                    <li style="padding-top: 5px;">
                                                        <button onclick="location.href='{{url('user/tai-lieu-cua-toi/'. $value->id)}}'"
                                                                id="buybt">
                                                            <i class="fa fa-arrow-circle-right"></i>Xem tài liệu
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
                    </div>
                    <div class="row"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
