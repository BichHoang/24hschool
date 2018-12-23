@extends('layout.lecturer')
@section('content')
    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Danh mục tài liệu học tập của bạn</strong>
                        </div>
                        @if(isset($document) && $document != null && count($document)!= 0 )
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
                                            - {{$start+count($document)}}

                                        </span>trong tổng số: <span style="color: #E57373; font-weight:bold;">{{$count}}
                                        </span></label>
                                        </div>

                                    </form>
                                </div>
                                <div class="col-lg-8 text-lg-right" style="float: right!important;">
                                    {!! $document->render() !!}
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Tên sách</th>
                                        <th scope="col">Giới thiệu</th>
                                        <th scope="col">Giá bán</th>
                                        <th scope="col">Giá sale</th>
                                        <th scope="col">Đã mua</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($document as $index => $row)
                                        <tr>
                                            <td>{{$start + $index + 1}}</td>
                                            <td>{{$row->name}}</td>
                                            <td>{{$row->introduce}}</td>
                                            <td>{{$row->price}}</td>
                                            <td>{{$row->sale}}</td>
                                            <td>{{$row->bought}}</td>
                                            <td>
                                                <a href="{{url('lecturer/study_document/detail/'.$row->id)}}">
                                                    <input type="button" alt="" class="btn btn-success"
                                                           value="Xem chi tiết">
                                                </a>
                                                <a href="#">
                                                    <input type="button" class="btn btn-warning" value="Xóa">
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
                                               placeholder="Tìm kiếm sách">
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
