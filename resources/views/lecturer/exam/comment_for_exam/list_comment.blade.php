@extends('layout.lecturer')
@section('content')
    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Danh sách comment của đề thi "{{$exam->name}}"</strong>
                        </div>
                        @if(isset($comment) && $comment != null && count($comment)!= 0 )
                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                <div class="col-lg-4 text-lg-left" style="float: right!important; margin-top: 20px;">
                                    <div class="row text-left"
                                         style="margin-top: 10px; margin-bottom: 5px; margin-left: 1.5%">
                                        <label style="margin-top: 10px; font-weight: normal; text-align: right; font-size: 15px;">
                                        <span style="color: #000000; font-weight:bold;">{{$start+1}}
                                            - {{$start+count($comment)}}
                                        </span>trong tổng số: <span style="color: #E57373; font-weight:bold;">{{$count}}
                                        </span></label>
                                    </div>
                                </div>
                                <div class="col-lg-8 text-lg-right" style="float: right!important;">
                                    {!! $comment->render() !!}
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" style="width: 20px">STT</th>
                                        <th scope="col" style="width: 100px;">Trạng thái</th>
                                        <th scope="col" style="width: 350px;">Nội dung comment</th>
                                        <th scope="col" style="width: 130px;">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($comment as $index => $row)
                                        <tr>
                                            <td>{{$start + $index + 1}}</td>
                                            @if($row->status == 0)
                                                <td>Chưa xem</td>
                                            @elseif($row->status == 1)
                                                <td>Đã xem</td>
                                            @endif
                                            <td>{{$row->comment}}</td>
                                            <td>
                                                <a href="{{url('lecturer/exam/exam_need_modify/detail_comment='. $row->id)}}">
                                                    <button class="btn btn-primary">
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
                            <h3>Không có dữ liệu</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div><!-- .animated -->
    </div><!-- .content -->

@endsection
