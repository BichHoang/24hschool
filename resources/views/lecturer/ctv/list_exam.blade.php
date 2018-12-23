@extends('layout.lecturer')
@section('content')
    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Danh sách đề thi được duyệt của {{$ctv->full_name}}</strong>
                        </div>
                        @if(isset($data) && $data != null && count($data)!= 0 )
                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                <div class="col-lg-4 text-lg-left" style="float: right!important; margin-top: 20px;">
                                    <form action="" method="post">
                                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">

                                        @if(isset($search_old))
                                            <input type="text" name="txt_search" id="txt_search" class="col-lg-6"
                                                   placeholder="Tìm kiếm đề thi" value="{{$search_old}}" required>
                                        @else
                                            <input type="text" name="txt_search" id="txt_search_1" class="col-lg-6"
                                                   placeholder="Tìm kiếm đề thi" required>
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
                                        <th scope="col" style="width: 20px">STT</th>
                                        <th scope="col" style="width: 150px;">Tên đề thi</th>
                                        <th scope="col" style="width: 80px;">Lớp</th>
                                        <th scope="col" style="width: 100px;">Môn học</th>
                                        <th scope="col" style="width: 100px;">Mức độ</th>
                                        <th scope="col" style="width: 200px;">Ngày duyệt</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $index => $row)
                                        <tr>
                                            <td>{{$start + $index + 1}}</td>
                                            <td>{{$row->name}}</td>
                                            <td>{{$row->class_name}}</td>
                                            <td>{{$row->subject_name}}</td>
                                            <td>{{$row->level_name}}</td>
                                            <td>{{date('H:i:s d/m/Y', strtotime($row->date_approved))}}</td>
                                            <td>
                                                <a href="{{url('lecturer/ctv/exam_detail='.$row->id)}}">
                                                    <button style="background-color: #00acc1; color: #000000">
                                                        Xem chi tiết
                                                    </button>
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

                                        <input type="text" name="txt_search" id="txt_search_2" class="col-lg-6"
                                               placeholder="Tìm kiếm lớp">
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
