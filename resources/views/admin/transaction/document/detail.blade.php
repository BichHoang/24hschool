@extends('layout.admin')
@section('content')
    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Chi tiết giao dịch</strong>
                        </div>
                        @if(isset($data) && $data != null && count($data)!= 0 )
                            <div class="card-header" style="margin-top: 10px; margin-bottom: 10px;">
                                <div class="col-lg-4" style="float: left!important; margin-top: 20px;">
                                    <div class="row" style="padding: 5px">
                                        Mã hóa đơn: <b>{{$data->code}}</b>
                                    </div>
                                    <div class="row" style="padding: 5px">
                                        Tên học sinh: <b>{{$data->customer_name}}</b>
                                    </div>
                                    <div class="row" style="padding: 5px">
                                        Địa chỉ: <b>{{$data->address}}</b>
                                    </div>
                                    <div class="row" style="padding: 5px">
                                        Số điện thoại: <b>{{$data->phone}}</b>
                                    </div>
                                    <div class="row" style="padding: 5px">
                                        @if($data->type_payment == 1)
                                            Hình thức thanh toán: <b>Ship COD</b>
                                        @elseif($data->type_payment == 2)
                                            Hình thức thanh toán: <b>Chuyển khoản</b>
                                        @endif
                                    </div>

                                    <div class="row" style="padding: 5px">
                                        @if(empty($data->note))
                                            Ghi chú: <b>Không có ghi chú</b>
                                        @else
                                            Ghi chú: <b>{{$data->note}}</b>
                                        @endif
                                    </div>
                                    <div class="row" style="padding: 5px">
                                        @if($data->status == 0 || $data->status == 1)
                                            Trạng thái đơn: <b>Giao dịch chưa được xử lý</b>
                                        @elseif($data->status == 3)
                                            Trạng thái đơn: <b>Khách hàng hủy giao dịch</b>
                                        @elseif($data->status == 5)
                                            Trạng thái đơn: <b>Giao dịch đã được nhận</b>
                                        @elseif($data->status == 2 || $data->status == 9)
                                            Trạng thái đơn: <b>Giao dịch thành công</b>
                                        @elseif($data->status > 9)
                                            Trạng thái đơn: <b>Giao dịch thất bại</b>
                                        @endif
                                    </div>

                                    @if($data->status >= 0 && $data->status <= 2)
                                        <div class="row">
                                            <div style="width: 45%">
                                                <a class="receive"
                                                   href="{{url('admin/transaction/notify_receive/'. $data->id)}}">
                                                    <button class="btn-success">
                                                        Nhận đơn
                                                    </button>
                                                </a>
                                            </div>
                                            <div style="width:45%">
                                                <form action="{{url('admin/transaction/notify_deny_receive/'. $data->id)}}"
                                                      method="post" id="form_reason">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="reason" id="reason">
                                                    <a class="deny_receive">
                                                        <button type="submit" class="btn-warning">
                                                            Không nhận đơn
                                                        </button>
                                                    </a>
                                                </form>
                                            </div>
                                        </div>
                                    @elseif($data->status == 5)
                                        <div class="row">
                                            <div style="width: 45%">
                                                <a class="order_success"
                                                   href="{{url('admin/transaction/notify_success/'. $data->id)}}">
                                                    <button class="btn-success">
                                                        Báo thành công
                                                    </button>
                                                </a>
                                            </div>
                                            <div style="width:45%">
                                                <form action="{{url('admin/transaction/notify_fail/'. $data->id)}}"
                                                      method="post" id="form_reason">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="reason" id="reason">
                                                    <a class="order_fail">
                                                        <button type="submit" class="btn-warning">
                                                            Báo đơn hỏng
                                                        </button>
                                                    </a>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th style="width: 10%">STT</th>
                                        <th style="width: 30%;">Tên sách</th>
                                        <th style="width: 15%;">Số lượng</th>
                                        <th style="width: 15%;">Giá bán</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($document as $index => $row)
                                        <tr>
                                            <td>{{$index + 1}}</td>
                                            <td>{{$row->name}}</td>
                                            <td>{{$row->number}}</td>
                                            <td>{{$row->price_sale}} VNĐ</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                <div class="col-lg-4 text-lg-left" style="float: right!important; margin-top: 20px;">
                                    Không có thông tin giao dịch
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div><!-- .animated -->
    </div><!-- .content -->
@endsection
@section('script')
    <script>
        $(document).ready(function () {

            //nhan don hang nay
            $('a.receive').confirm({
                columnClass: 'col-md-6',
                icon: 'fa fa-bullhorn',
                title: "Nhận đơn hàng",
                content: "Bạn có chấp nhận đơn hàng này ?",
                type: 'blue',
                typeAnimated: true,
                draggable: false,
                buttons: {
                    receive: {
                        text: 'Nhận đơn hàng này',
                        btnClass: 'btn-blue',
                        action: function () {
                            location.href = this.$target.attr('href');
                        }
                    },
                    cancel: {
                        text: "Hủy bỏ",
                        btnClass: 'btn-brown',
                        action: function () {
                            return;
                        }
                    }
                }
            });

            //tu choi nhan don hang nay
            $('a.deny_receive').confirm({
                columnClass: 'col-md-6',
                icon: 'fa fa-bullhorn',
                title: "Từ chối nhận đơn hàng",
                content:
                '<form action="post" class="formName">' +
                '<div class="form-group">' +
                '<label>Xin hãy nhập lý do từ chối nhận đơn hàng:</label>' +
                '<textarea class="reason form-control" required ></textarea>' +
                '</div>' +
                '</form>',
                type: 'red',
                typeAnimated: true,
                draggable: false,
                buttons: {
                    deny_receive: {
                        text: 'Từ chối đơn này',
                        btnClass: 'btn-red',
                        action: function () {
                            var comment = this.$content.find('.reason').val();
                            if (!comment) {
                                $.alert('Xin hãy nhập lý do từ chối nhận đơn hàng này');
                                return false;
                            }
                            $('#reason').val(comment);
                            $('#form_reason').submit();
                        }
                    },
                    cancel: {
                        text: "Hủy bỏ",
                        btnClass: 'btn-brown',
                        action: function () {
                            return;
                        }
                    }
                }
            });

            //don hang thanh cong
            $('a.order_success').confirm({
                columnClass: 'col-md-6',
                icon: 'fa fa-bullhorn',
                title: "Thông báo đơn hoàn thành thành công",
                content: "Đơn hàng này đã kết thúc thành công ?",
                type: 'blue',
                typeAnimated: true,
                draggable: false,
                buttons: {
                    success: {
                        text: 'Thành công',
                        btnClass: 'btn-blue',
                        action: function () {
                            location.href = this.$target.attr('href');
                        }
                    },
                    cancel: {
                        text: "Hủy bỏ",
                        btnClass: 'btn-brown',
                        action: function () {
                            return;
                        }
                    }
                }
            });

            //thong bao don hang that bai
            $('a.order_fail').confirm({
                columnClass: 'col-md-6',
                icon: 'fa fa-bullhorn',
                title: "Thông báo đơn hàng thất bại",
                content:
                '<form action="post" class="formName">' +
                '<div class="form-group">' +
                '<label>Xin hãy nhập lý do đơn hàng thất bại:</label>' +
                '<textarea class="reason form-control" required ></textarea>' +
                '</div>' +
                '</form>',
                type: 'red',
                typeAnimated: true,
                draggable: false,
                buttons: {
                    fail: {
                        text: 'Thất bại',
                        btnClass: 'btn-red',
                        action: function () {
                            var comment = this.$content.find('.reason').val();
                            if (!comment) {
                                $.alert('Xin hãy nhập lý do đơn hàng thất bại');
                                return false;
                            }
                            $('#reason').val(comment);
                            $('#form_reason').submit();
                        }
                    },
                    cancel: {
                        text: "Hủy bỏ",
                        btnClass: 'btn-brown',
                        action: function () {
                            return;
                        }
                    }
                }
            });
        });
    </script>

@endsection

