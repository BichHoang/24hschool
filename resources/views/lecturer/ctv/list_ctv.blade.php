@extends('layout.lecturer')
@section('content')
    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Danh sách cộng tác viên của bạn</strong>
                        </div>
                        @if(isset($data) && $data != null && count($data)!= 0 )
                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                <div class="col-lg-4 text-lg-left" style="float: right!important; margin-top: 20px;">
                                    <form action="" method="post">
                                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">

                                        @if(isset($search_old))
                                            <input type="text" name="txt_search" class="col-lg-6"
                                                   placeholder="Tìm kiếm cộng tác viên" value="{{$search_old}}"
                                                   required>
                                        @else
                                            <input type="text" name="txt_search" class="col-lg-6"
                                                   placeholder="Tìm kiếm cộng tác viên" required>
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
                                        <th scope="col">Họ và tên</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Số điện thoại</th>
                                        <th scope="col">Ngày sinh</th>
                                        <th scope="col">Ngày tạo</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $index => $row)
                                        <tr>
                                            <td>{{$start + $index + 1}}</td>
                                            <td>{{$row->full_name}}</td>
                                            <td>{{$row->email}}</td>
                                            <td>{{$row->phone}}</td>
                                            @if(is_null($row->birthday))
                                                <td>Không biết</td>
                                            @else
                                                <td>{{date('d/m/Y', strtotime($row->birthday))}}</td>
                                            @endif
                                            <td>{{date('H:i:s d/m/Y', $row->created_at)}}</td>
                                            <td>
                                                <a href="{{url('lecturer/ctv/list_exam='.$row->id)}}">
                                                    <input type="button" alt="Đề đã được duyệt" class="btn btn-success"
                                                           value="Các đề đã duyệt">
                                                </a>
                                                <a href="#">
                                                    <input type="button" alt="Tạm thời khóa" class="btn btn-warning"
                                                           value="Xóa">
                                                </a>
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
                                               placeholder="Tìm kiếm cộng tác viên">
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
