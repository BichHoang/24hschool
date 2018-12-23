@extends('user.layout.home')
@section('content')
    <style>

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
                @if(count($data) >= 0 )
                    <div class="col-lg-9 col-12">
                        <div class="row">
                            <div class="col-12" id="boxCart">
                                <div style="margin: 15px;">
                                    <div>
                                        <h4>Các giao dịch của bạn</h4>
                                        <hr>
                                    </div>
                                    <div class="row" id="headContent">
                                        <div class="col-lg-1 col-12">STT</div>
                                        <div class="col-lg-2 col-12">Mã giao dịch</div>
                                        <div class="col-lg-2 col-12">Thời gian giao dịch</div>
                                        <div class="col-lg-2 col-12">Giá của giao dịch</div>
                                        <div class="col-lg-2 col-12">Tình trạng giao dịch</div>
                                        <div class="col-lg-3 col-12">Hành động</div>
                                    </div>
                                    <hr>
                                    @foreach($data as $index => $transaction)
                                        <div class="row" id="contentCart">
                                            <div class="col-lg-1 col-12">{{$index +1}}</div>
                                            <div class="col-lg-2 col-12">
                                                {{$transaction->code}}
                                            </div>
                                            <div class="col-lg-2 col-12" id="nameProduct">
                                                {{date('H:i d/m/Y', strtotime($transaction->created_at))}}
                                            </div>

                                            <div class="col-lg-2 col-12">
                                                {{$transaction->price}} VNĐ
                                            </div>

                                            @if($transaction->status == 1 || $transaction->status == 0)
                                                <div class="col-lg-2 col-12">Giao dịch đang được xử lý</div>
                                            @elseif($transaction->status == 5)
                                                <div class="col-lg-2 col-12">Món hàng đang được vận chuyển</div>
                                            @elseif($transaction->status == 9)
                                                <div class="col-lg-2 col-12">Giao dịch thành công</div>
                                            @elseif($transaction->status >= 10)
                                                <div class="col-lg-2 col-12">Giao dịch thất bại</div>
                                            @endif

                                            <div class="col-lg-3 col-12">
                                                @if($transaction->type_transaction == 1)
                                                    <a href="{{url('user/transaction/book/detail/'. $transaction->id)}}">
                                                        <button class="btn-success" title="Xem chi tiết giao dichj">
                                                            Xem
                                                        </button>
                                                    </a>
                                                @elseif($transaction->type_transaction == 2)
                                                    <a href="{{url('user/transaction/document/detail/'. $transaction->id)}}">
                                                        <button class="btn-success" title="Xem chi tiết giao dịch">
                                                            Xem
                                                        </button>
                                                    </a>
                                                @endif

                                                @if($transaction->status == 0 || $transaction->status == 1)
                                                    <a class="cancel_transaction"
                                                       href="{{url('user/transaction/cancel_transaction/'. $transaction->id)}}">
                                                        <button title="Hủy bỏ giao dịch">
                                                            Hủy giao dịch
                                                        </button>
                                                    </a>
                                                @elseif($transaction->status == 9 || $transaction->status == 10)
                                                    <a class="delete_transaction"
                                                    href="{{url('user/transaction/delete_transaction/'. $transaction->id)}}">
                                                        <button title="Xóa lịch sử giao dịch">
                                                            Xóa giao dịch
                                                        </button>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                    <div class="row" style="padding-top: 50px">
                                        <div class="col-12">
                                            <!-- Start Pagination -->
                                        {{$data->render()}}
                                        <!--/ End Pagination -->
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row"></div>
                    </div>
                @else

                @endif
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('a.cancel_transaction').confirm({
                icon: 'fa fa-bullhorn',
                content: "Bạn có muốn hủy bỏ giao dịch này?",
                title: "Hủy giao dịch",
                type: 'red',
                typeAnimated: true,
                draggable: false,
                buttons: {
                    hide_transaction: {
                        text: 'Hủy giao dịch',
                        btnClass: 'btn-red',
                        action: function () {
                            location.href = this.$target.attr('href');
                        }
                    },
                    huy_bo: {
                        text: 'Hủy bỏ',
                        action: function () {
                            return;
                        }
                    }
                }
            });

            $('a.delete_transaction').confirm({
                icon: 'fa fa-bullhorn',
                content: "Bạn có muốn xóa lịch sử giao dịch này?",
                title: "Xóa giao dịch",
                type: 'red',
                typeAnimated: true,
                draggable: false,
                buttons: {
                    hide_transaction: {
                        text: 'Xóa giao dịch',
                        btnClass: 'btn-red',
                        action: function () {
                            location.href = this.$target.attr('href');
                        }
                    },
                    huy_bo: {
                        text: 'Hủy bỏ',
                        action: function () {
                            return;
                        }
                    }
                }
            });
        });
    </script>
@endsection
