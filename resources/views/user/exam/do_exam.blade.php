@extends('user.layout.homeShortHeaderFooter')
<style>
    @media screen and (max-width: 990px) {
        .boxAnswer {
            width: 50%;
            position: static;
            border: lavender 1px outset;
            padding: 10px;
        }

        .divAnswer {
            overflow: scroll;
            width: 100%;
        }

        .col-12 {
            flex: auto;
        }

        .col-12, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-9 {
            width: auto;
        }
    }

    .sectionExam {
        padding: 20px 30px 25px 40px;
    }

    .contentExam {
        border: lavender 1px outset;
        padding: 15px;
        text-align: center;
    }

    .contentExam h4 {
        color: #2ecc71;
        line-height: 3;
    }

    .contentExam span {
        font-style: italic;
        color: #c4e3f3;
    }

    .boxAnswer {
        width: 20%;
        position: fixed;
        border: lavender 1px outset;
        padding: 10px;
    }

    .boxAnswer table tr th {
        width: 20px !important;
    }

    .boxAnswer p {
        display: inline;
    }

    .divAnswer {
        overflow: scroll;
        width: 100%;
    }
</style>
@section('content')

    @if(Auth::check())
        <!-- Blogs -->
        <section class="sectionExam">
            <div class="containerExam">
                <div class="row">
                    <div class="col-lg-9 col-12">
                        <!-- Single Exam -->
                        <div class="singleExam">
                            <div class="contentExam" style="text-align: center">
                                <h4 class="blog-title"><a href="#">{{$exam->name}}</a></h4>
                                <div class="row" style="padding-bottom: 15px">
                                    <div class="col-lg-4">
                                        <p style="float: left; padding-left: 100px;"><span
                                                    style="font-style: italic">Thời gian: </span>{{$exam->time}} phút.
                                        </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <p style="float: left; padding-left: 100px; "><span
                                                    style="font-style: italic">Số câu hỏi: </span>{{$exam->number_of_questions}}
                                            câu.</p>
                                    </div>
                                    <div class="col-lg-4">
                                        <p style="float: left; padding-left: 100px;"><span
                                                    style="font-style: italic">Người đăng: </span>{{$exam->lecturer_name}}
                                        </p>
                                    </div>
                                </div>
                                <iframe src="{{url('user/file_exam='. $exam->name_briefly)}}#toolbar=0&navpanes=0&view=fitH,100"
                                        width="100%" height="650"></iframe>
                            </div>
                        </div>
                        <!-- End Single Blog -->
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="boxAnswer">
                            <!-- Categories -->
                            <form action="" method="post" class="" id="form_answer">
                                <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                <input type="hidden" name="fetch_time" value="{{$fetch_time}}">
                                <input type="hidden" name="comment" id="comment">
                                <input type="hidden" name="errors" id="errors">
                                <div class="">
                                    <p class="title" style="float: left;"><strong> Bài làm:</strong></p>
                                    <div style="text-align: right; padding-bottom: 10px;">
                                        <input style="line-height: 1.5;
                                        font-size: 20px;
                                        padding-left: 10px;
                                        padding-right: 10px;
                                        background-color: greenyellow;color: darkred;"
                                               type="submit" value="Nộp bài" class="submit_exam"/>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2 col-12">
                                            <p>Câu</p>
                                        </div>
                                        <div class="col-lg-1 col-12">
                                            <p>A</p>
                                        </div>
                                        <div class="col-lg-1 col-12">
                                            <p>B</p>
                                        </div>
                                        <div class="col-lg-1 col-12">
                                            <p>C</p>
                                        </div>
                                        <div class="col-lg-1 col-12">
                                            <p>D</p>
                                        </div>
                                        <div class="col-lg-4 col-12">
                                            <p>Báo lỗi</p>
                                        </div>
                                    </div>

                                    <div class="divAnswer" id="divAnswer">
                                        @for($num = 1; $num <= ($exam->number_of_questions); $num++ )
                                            <div class="row">
                                                @if($num < 10)
                                                    <div class="col-lg-2 col-12">
                                                        <p style="display: inline"><strong>0{{$num}}. </strong></p>
                                                    </div>
                                                @else
                                                    <div class="col-lg-2 col-12">
                                                        <p style="display: inline"><strong>{{$num}}. </strong></p>
                                                    </div>
                                                @endif
                                                <div class="col-lg-1 col-12">
                                                    <input type="radio" id="answerA{{$num}}" name="{{$num}}"
                                                           value="1" class="rdbtAns">
                                                </div>
                                                <div class="col-lg-1 col-12">
                                                    <input type="radio" id="answerB{{$num}}" name="{{$num}}"
                                                           value="2"
                                                           class="rdbtAns">
                                                </div>
                                                <div class="col-lg-1 col-12">
                                                    <input type="radio" id="answerC{{$num}}" name="{{$num}}"
                                                           value="3"
                                                           class="rdbtAns">
                                                </div>
                                                <div class="col-lg-1 col-12">
                                                    <input type="radio" id="answerD{{$num}}" name="{{$num}}"
                                                           value="4"
                                                           class="rdbtAns">
                                                </div>
                                                <div class="col-lg-1 col-12"></div>
                                                <div class="col-lg-2 col-12">
                                                    <a onclick="reportQuestion({{$num}})">
                                                        <i class="fa fa-warning" style="font-size:15px;color:red"
                                                           title="Báo lỗi câu hỏi"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endfor
                                        <div style="clear: both;"></div>
                                    </div>

                                    <!-- Clock -->
                                    <div style="padding-top: 20px; border-top: 1px solid greenyellow">
                                        <!-- Clock-->
                                        <div>
                                            <div class="">
                                                <div class="countdown">
                                                    <div class="bloc-time hours" id="hour"
                                                         data-init-value="{{floor(($exam->time)/60)}}">
                                                        @if(($exam->time)/60 < 10)
                                                            <div class="figure hours hours-1">
                                                                <span class="top">0</span>
                                                                <span class="top-back">
                                                              <span>0</span>
                                                            </span>
                                                                <span class="bottom">0</span>
                                                                <span class="bottom-back">
                                                              <span>0</span>
                                                            </span>
                                                            </div>

                                                            <div class="figure hours hours-2">
                                                                <span class="top">{{FLOOR(($exam->time)/60)}}</span>
                                                                <span class="top-back">
                                                              <span>{{FLOOR(($exam->time)/60)}}</span>
                                                            </span>
                                                                <span class="bottom">{{FLOOR(($exam->time)/60)}}</span>
                                                                <span class="bottom-back">
                                                              <span>{{FLOOR(($exam->time)/60)}}</span>
                                                            </span>
                                                            </div>
                                                        @else
                                                            <div class="figure hours hours-1">
                                                                <span class="top">{{FLOOR((($exam->time)/60)/10)}}</span>
                                                                <span class="top-back">
                                                              <span>{{FLOOR((($exam->time)/60)/10)}}</span>
                                                            </span>
                                                                <span class="bottom">{{FLOOR((($exam->time)/60)/10)}}</span>
                                                                <span class="bottom-back">
                                                              <span>{{FLOOR((($exam->time)/60)/10)}}</span>
                                                            </span>
                                                            </div>

                                                            <div class="figure hours hours-2">
                                                                <span class="top">{{(($exam->time)/60)%10}}</span>
                                                                <span class="top-back">
                                                              <span>{{(($exam->time)/60)%10}}</span>
                                                            </span>
                                                                <span class="bottom">{{(($exam->time)/60)%10}}</span>
                                                                <span class="bottom-back">
                                                              <span>{{(($exam->time)/60)%10}}</span>
                                                            </span>
                                                            </div>
                                                        @endif
                                                        <span class="count-title"
                                                              style="line-height: 2.5;">Giờ</span>
                                                    </div>
                                                    <div class="bloc-time min"
                                                         data-init-value="{{($exam->time)%60}}">
                                                        @if(($exam->time)%60 < 10)

                                                            <div class="figure min min-1">
                                                                <span class="top">0</span>
                                                                <span class="top-back">
                                                              <span>0</span>
                                                            </span>
                                                                <span class="bottom">0</span>
                                                                <span class="bottom-back">
                                                              <span>0</span>
                                                            </span>
                                                            </div>

                                                            <div class="figure min min-2">
                                                                <span class="top">{{FLOOR(($exam->time)%60)}}</span>
                                                                <span class="top-back">
                                                              <span>{{FLOOR(($exam->time)%60)}}</span>
                                                            </span>
                                                                <span class="bottom">{{FLOOR(($exam->time)%60)}}</span>
                                                                <span class="bottom-back">
                                                              <span>{{FLOOR(($exam->time)%60)}}</span>
                                                            </span>
                                                            </div>
                                                        @else
                                                            <div class="figure min min-1">
                                                                <span class="top">{{FLOOR((($exam->time)%60)/10)}}</span>
                                                                <span class="top-back">
                                                              <span>{{FLOOR((($exam->time)%60)/10)}}</span>
                                                            </span>
                                                                <span class="bottom">{{FLOOR((($exam->time)%60)/10)}}</span>
                                                                <span class="bottom-back">
                                                              <span>{{FLOOR((($exam->time)%60)/10)}}</span>
                                                            </span>
                                                            </div>

                                                            <div class="figure min min-2">
                                                                <span class="top">{{(($exam->time)%60)%10}}</span>
                                                                <span class="top-back">
                                                              <span>{{(($exam->time)%60)%10}}</span>
                                                            </span>
                                                                <span class="bottom">{{(($exam->time)%60)%10}}</span>
                                                                <span class="bottom-back">
                                                              <span>{{(($exam->time)%60)%10}}</span>
                                                            </span>
                                                            </div>
                                                        @endif
                                                        <span class="count-title"
                                                              style="line-height: 2.5;">Phút</span>
                                                    </div>
                                                    {{--<div style="clear:both;"></div>--}}

                                                    <div class="bloc-time sec" data-init-value="0">


                                                        <div class="figure sec sec-1">
                                                            <span id="second1" class="top">0</span>
                                                            <span class="top-back">
                                                          <span>0</span>
                                                        </span>
                                                            <span class="bottom">0</span>
                                                            <span class="bottom-back">
                                                          <span>0</span>
                                                        </span>
                                                        </div>

                                                        <div class="figure sec sec-2">
                                                            <span class="top">0</span>
                                                            <span class="top-back">
                                                          <span>0</span>
                                                        </span>
                                                            <span class="bottom">0</span>
                                                            <span class="bottom-back">
                                                          <span>0</span>
                                                        </span>
                                                        </div>

                                                        <span class="count-title"
                                                              style="line-height: 2.5;">Giây</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="clear: both"></div>
                                        </div>
                                        <!-- / End Colock-->
                                    </div>
                                    <!--/ End Clock -->
                                </div>
                            </form>
                            <!--/ End Categories -->
                        </div>
                        <!--/ End Categories -->

                    </div>
                </div>
            </div>
        </section>
        <!--/ End Blogs -->
    @else
        <div style="height: 78vh;">
            <p style="text-align: center;padding-top: 35vh"><a href="{{ url('/login')}}" style="color: red;">Đăng
                    nhập</a> để thực hiện chức
                năng này</p>

        </div>

    @endif
@endsection

@section('script')
    <script>
        window.onbeforeunload = function (e) {
            var dialogText = 'chua duoc luu';
            e.returnValue = dialogText;
            return dialogText;
        };

        $('input.submit_exam').confirm({
            columnClass: 'col-md-4',
            icon: 'fa fa-bullhorn',
            title: "Nộp bài thi",
            content: '' +
            '<form action="post" class="formName">' +
            '<div class="form-group">' +
            '<label>Nhận xét của bạn về đề thi</label>' +
            '<textarea class="comment_of_user form-control" required ></textarea>' +
            '</div>' +
            '</form>',
            type: 'blue',
            typeAnimated: true,
            draggable: false,
            buttons: {
                ok: {
                    text: 'Nộp bài thôi!!',
                    btnClass: 'btn-blue',
                    action: function () {
                        var comment = this.$content.find('.comment_of_user').val();
                        if (!comment) {
                            $.alert('Xin hãy nhập nhận xét cho đề thi');
                            return false;
                        }
                        window.onbeforeunload = null;
                        $('#comment').val(comment);
                        $('#form_answer').submit();
                    }
                },
                cancel: {
                    text: "Đùa thôi chưa xong",
                    action: function () {
                        return;
                    }
                }
            }
        });

        function reportQuestion(number) {
            var txt = document.getElementById("errors").value;
            var r = prompt("Bạn muốn báo lỗi câu hỏi số " + number + " ?");
            if (r != null) {
                if (txt == "") {
                    $.alert("Bạn chưa nhập ý kiến của mình.");
                } else {
                    document.getElementById("errors").value = txt + "<br> Câu số " + number + ":" + r;
                    $.alert("Cảm ơn ý kiến đóng góp của bạn.");
                }
            }
        }

        function checkSubmit(t, number) {
            window.onbeforeunload = null;
            var checkedradio;
            var count = 0;

            for (i = 1; i <= number; i++) {
                var check = false;
                var answerA = "answerA" + i;
                var answerB = "answerB" + i;
                var answerC = "answerC" + i;
                var answerD = "answerD" + i;
                if (document.getElementById(answerA).checked || document.getElementById(answerB).checked
                    || document.getElementById(answerC).checked || document.getElementById(answerD).checked) {
                    check = true;
                }
                if (check) {
                    count++;
                }

            }
            if (count < number) {
                var r = confirm("Bạn chưa làm xong. Bạn có muốn nộp bài?");
                if (r = true) {

                } else {

                }
            } else {
                return true;
            }
        }

        $(window).load(function () {
            var s = $(window).height();
            var header = $('header').height();
            var footer = $('footer').height();
            var h = s - (footer + header + 250);
            if ($("#divAnswer").height() > h) {
                $("#divAnswer").height(h);
            }
            // document.getElementById("#divAnswer").top = header + 10;
        });
    </script>
@endsection
