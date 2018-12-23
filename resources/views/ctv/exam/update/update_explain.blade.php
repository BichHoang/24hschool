@extends('layout.ctv')
@section('content')
    <section class="content-header">
        <h2 id="title_border">
            Đổi file giải thích của đề thi "{{$exam->name}}"
        </h2>
    </section>

    <form enctype="multipart/form-data" method="post" action="" id="my_form">
        <input type="hidden" name="_token" value="<?= csrf_token() ?>">

        <div class="panel-heading row" style="padding-top: 1em">
            <div class="col-lg-2"></div>
            <div class="col-lg-2">
                <label style="font-weight: normal; font-size: 15px"> File giải thích <b style="color: #ff2e44">(*)</b> </label>
            </div>
            <div class="col-lg-6">
                <input name="file_explain" type="file" class="input-sm" autocomplete="off" accept=".pdf"
                       required style="width: 300px">
            </div>
        </div>

        <div class="panel-heading row" style="padding-top: 2em">
            <div class="col-lg-4"></div>
            <div class="col-lg-2">
                <input style="background-color: #34ce57" type="submit" value="Lưu file" id="btn_save" name="save">
            </div>
            <div class="col-lg-2">
                <input type="button" value="Trở về" id="btn_enter_answer" name="enter_answer"
                       onclick="location.href='{{url()->previous()}}'">
            </div>
        </div>

    </form>

@endsection