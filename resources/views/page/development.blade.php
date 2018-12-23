@extends('user.layout.home')

@section('content')
    <style>
        .pagination {
            padding-bottom: 15px;
            float: right;
        }

        .pagination li.active {
            padding: 12px 25px;
            border: none;
            display: block;
            background: #00B16A;
            color: white;
        }

        .pagination li.disabled {
            padding: 12px 25px;
            border: none;
            display: block;
            background: #f6f6f6;
            color: #252525;
        }

        .pagination li {
            padding: 12px 25px;
            border: none;
            display: block;
            background: #f6f6f6;
            color: #252525;
            margin-right: 5px;
        }
    </style>

    <!-- History -->
    <section class="">
        <table border="1" style="border: double slategray;text-align: center; line-height: 2;">
            <tr>
                <th colspan="10" style="font-size: 25px;background-color: antiquewhite;">Tính năng đang trong quá trính phát triển
                </th>
            </tr>
            <th style="height: 100px;">Bạn sẽ nhận được thông báo khi tính năng phát triển xong. Xin cảm ơn</th>
        </table>
    </section>
    <!--/ End History -->
@endsection
@section('script')
    <script>
        $(window).load(function () {
            var s = $(window).height();
            var h = s - 300;
            if ($("section").height() < h) {
                $("section").height(h);
            }
        });
    </script>
@endsection