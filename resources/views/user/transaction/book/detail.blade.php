@extends('user.layout.home')
@section('content')
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
                                        <h4>Chi tiết giao dịch</h4>
                                        <hr>
                                    </div>
                                    <div class="row" id="headContent">
                                        <div class="col-lg-1 col-12">STT</div>
                                        <div class="col-lg-5 col-12">Tên sách</div>
                                        <div class="col-lg-3 col-12">Số lượng</div>
                                        <div class="col-lg-3 col-12">Giá sản phẩm</div>
                                    </div>
                                    <hr>
                                    @foreach($book as $index => $item)
                                        <div class="row" id="contentCart">
                                            <div class="col-lg-1 col-12">{{$index +1}}</div>
                                            <div class="col-lg-5 col-12" id="nameProduct">
                                                {{$item->name}}
                                            </div>

                                            <div class="col-lg-3 col-12">
                                                {{$item->number}}
                                            </div>
                                            <div class="col-lg-3 col-12">
                                                {{$item->price_sale}}
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
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
