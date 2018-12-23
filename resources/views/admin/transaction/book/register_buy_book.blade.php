@extends('layout.admin')
@section('content')
    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Danh sách đăng ký mua sách</strong>
                        </div>
                        @if(isset($data) && $data != null && count($data)!= 0 )
                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                <div class="col-lg-4 text-lg-left" style="float: right!important; margin-top: 20px;">
                                    <form action="" method="post">
                                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">

                                        @if(isset($search_old))
                                            <input type="text" name="txt_search" class="col-lg-6"
                                                   placeholder="Tìm kiếm" value="{{$search_old}}" required>
                                        @else
                                            <input type="text" name="txt_search" class="col-lg-6"
                                                   placeholder="Tìm kiếm " required>
                                        @endif
                                        <input type="submit" name="btn_submit" id="btn_submit" class="col-lg-5"
                                               value="Tìm kiếm">

                                        <div class="row text-left"
                                             style="margin-top: 10px; margin-bottom: 5px; margin-left: 1.5%">
                                            <label style="margin-top: 10px; font-weight: normal; text-align: right; font-size: 15px;">
                                        <span style="color: #000000; font-weight:bold;">{{$start+1}}
                                            - {{$start+count($data)}}

                                        </span>trong tổng số: <span style="color: #E57373; font-weight:bold;">{{$count}}
                                        </span></label>
                                        </div>

                                    </form>
                                </div>
                                <div class="col-lg-8 text-lg-right" style="float: right!important;">
                                    {!! $data->render() !!}
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Mã hóa đơn</th>
                                        <th scope="col">Loại giao dịch</th>
                                        <th scope="col">Tên học sinh</th>
                                        <th scope="col">Tổng hóa đơn</th>
                                        <th scope="col">Ngày đặt mua</th>
                                        <th scope="col">Tình trạng</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $index => $row)
                                        <tr>
                                            <td>{{$start + $index + 1}}</td>
                                            <td>{{$row->code}}</td>
                                            @if($row->type_transaction == 1)
                                                @if($row->type_item == 0)
                                                    <td>Mua sách</td>
                                                @elseif($row->type_item == 1)
                                                    <td>Mua ebook</td>
                                                @elseif($row->type_item == 2)
                                                    <td>Mua trọn bộ sách</td>
                                                @endif
                                            @elseif($row->type_transaction == 2)
                                                @if($row->type_item == 0)
                                                    <td>Mua tài liệu giấy</td>
                                                @elseif($row->type_item == 1)
                                                    <td>Mua tài liệu mềm</td>
                                                @elseif($row->type_item == 2)
                                                    <td>Mua trọn bộ tài liệu</td>
                                                @endif
                                            @endif

                                            <td>{{$row->customer_name}}</td>
                                            <td>{{$row->price}}</td>
                                            <td>{{date('H:i d/m/Y', strtotime($row->created_at))}}</td>
                                            @if($row->status == 0 || $row->status == 1)
                                                <td>Giao dịch chưa được xử lý</td>
                                            @elseif($row->status == 5)
                                                <td>Giao dịch đã xử lý xong. Chờ kết quả</td>
                                            @endif
                                            <td>
                                                <button onclick="location.href='{{url('admin/transaction/book/detail_transaction/'. $row->id)}}'">
                                                    Xem chi tiết
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        @else
                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                <div class="col-lg-4 text-lg-left" style="float: right!important; margin-top: 20px;">
                                    <form action="" method="post">
                                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">

                                        <input type="text" name="txt_search" class="col-lg-6"
                                               placeholder="Tìm kiếm">
                                        <input type="submit" name="btn_submit" id="btn_submit" class="col-lg-5"
                                               value="Tìm kiếm">

                                    </form>
                                </div>
                            </div>
                            @if(isset($search_old))
                                <h3>Không có dữ liệu cho tìm kiếm {{"\"".$search_old. "\""}}</h3>
                            @else
                                <h3>Không có dữ liệu</h3>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div><!-- .animated -->
    </div><!-- .content -->
@endsection
