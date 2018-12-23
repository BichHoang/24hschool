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

    @if(Auth::check())

        <!-- History -->
        <section class="">
            <div class="container">
                @if(isset($exam_history) && $exam_history != null && count($exam_history) > 0)
                    <div class="row" id="history">
                        <div class="col-12" style="padding-top: 30px;">
                            <table border="1" style="border: double slategray;text-align: center; line-height: 2;">
                                <tr>
                                    <th colspan="10" style="font-size: 25px;background-color: antiquewhite;">LỊCH SỬ THI
                                    </th>
                                </tr>
                                <tr style="background-color: #f6f6f6; font-size: 17px;">
                                    <th>STT</th>
                                    <th>Ngày thi</th>
                                    <th style="width: 250px">Tên đề thi</th>
                                    <th>Số câu hỏi</th>
                                    <th>Thời gian làm bài</th>
                                    <th>Số lần thi lại</th>
                                    <th>Đáp án và file giải thich</th>
                                    <th>Thi lại</th>
                                </tr>
                                @foreach($exam_history as $index => $value)
                                    <tr>
                                        <td>{{$index + 1}}</td>
                                        <td>{{date('d/m/Y', $value->fetch_time)}}</td>
                                        <td>{{$value->exam_name}}</td>
                                        <td>{{$value->number_of_questions}}</td>
                                        <td>{{$value->actual_test_time_mm}} phút {{$value->actual_test_time_ss}}giây
                                        </td>
                                        <td>{{$value->retest}}</td>
                                        @if(time() >= strtotime($value->time_to_send_result) )
                                            <td>
                                                <a href="{{url('user/detail_result/'. $value->id)}}" style="color: #00B069;">
                                                    <i class="fa fa-hand-o-right" style="padding-right: 5px;"></i>Đáp án chi tiết
                                                </a>
                                            </td>
                                        @else
                                            <td>
                                                <a style="color: #ff2e44;">
                                                    <i class="fa fa-allergies" style="padding-right: 5px;"></i>Chưa có đáp án
                                                </a>
                                            </td>
                                        @endif
                                        <td>
                                            <a href="#" style="color: #00B069;">
                                                <i class="fa fa-repeat" style="padding-right: 5px;"></i>Thi lại
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>


                        </div>
                    </div>
                    <div class="row" id="page">
                        <div class="col-12">
                            <!-- Start Pagination -->
                        {{$exam_history->render()}}
                        <!--/ End Pagination -->
                        </div>
                    </div>
                @else
                    <table border="1" style="border: double slategray;text-align: center; line-height: 2;">
                        <tr>
                            <th colspan="10" style="font-size: 25px;background-color: antiquewhite;">LỊCH SỬ THI
                            </th>
                        </tr>
                        <th style="height: 100px;">Không có thông tin lịch sử thi</th>
                    </table>

                @endif

                {{--<!-- Show History-->--}}
                {{--<div class="row" id="showHistory" style="display: none;">--}}
                {{--<div style="padding-top: 20px;padding-bottom: 15px;">--}}
                {{--<a href="#" style="font-style: italic; font-size: 20px; color: #00B069; border-bottom: #00aced 1px double">--}}
                {{--<i class="fa fa-hand-o-right" style="padding-right: 5px;">Xem lịch sử thi</i>--}}
                {{--</a>--}}

                {{--</div>--}}
                {{--</div>--}}
                {{--<!--\End Show History-->--}}

            </div>
        </section>
        <!--/ End History -->
    @else
        <div style="height: 28vh;">
            <p style="text-align: center;padding-top: 10vh"><a href="{{ url('/login')}}" style="color: red;">Đăng
                    nhập</a> để thực hiện chức
                năng này</p>

        </div>
    @endif

@endsection
@section('script')
    <script>
        $(window).load(function() {
            var s = $(window).height();
            var h = s - 465;
            if($("section").height() < h){
                $("section").height(h);
            }
        });
    </script>
@endsection