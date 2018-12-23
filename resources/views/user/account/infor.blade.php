@extends('user.layout.home')

@section('content')
    @if(Auth::check())
        <div>
            <section class="courses single section" style=" padding: 0px 0;">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="single-main">
                                <div class="row">
                                    <div class="col-lg-4 col-12">
                                        <!-- Single Course -->
                                        <div class="single-course">
                                            <style>
                                                .hidden_show {
                                                    visibility: hidden;
                                                }
                                            </style>
                                            <form enctype="multipart/form-data" method="post" action=""
                                                  onsubmit="return check(this)">
                                                <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                                <!-- Tải ảnh lên -->
                                                <div style="display: none">
                                                    {{$image_path = public_path().'/avatar/'.$avatar = Auth::user()->avatar}}
                                                </div>

                                                @if(Auth::user()->avatar == null ||(!is_file($image_path)))
                                                    <div id="img_show" class="">
                                                        <img id="img_avatar" style="max-width: 100%;height: 290px;"
                                                             src="{{asset('avatar/no_user.png')}}"
                                                             alt="avatar">
                                                    </div>
                                                @else
                                                    <div id="img_show" class="">
                                                        <img id="img_avatar" style="max-width: 100%;height: 290px;"
                                                             src="{{asset('avatar/'. Auth::user()->avatar)}}"
                                                             alt="avatar">
                                                    </div>
                                                @endif
                                                <input name="img_avatar" type="file" id="img_user"
                                                       required style="height:0; width:0; visibility:hidden">
                                                <p style="text-align: center;padding-bottom: 5px;">
                                                    <i class="fa fa-camera" style="padding-right: 10px;"></i><input
                                                            type="button"
                                                            class="btn btn-warning text-center"
                                                            onclick="showImagePreview();"
                                                            value="Đổi ảnh đại diện"/>
                                                </p>

                                                <div id="bt_save_cancel" class="panel-heading row"
                                                     style="padding-top: 1em; display: none;">
                                                    <p style="text-align: center;">
                                                        <input class="btn btn-primary" type="submit" value="Lưu"
                                                               id="btn_save_new" name="btn_save_new">
                                                        <input class="btn btn-basic" type="reset" onclick="btCancel();"
                                                               value="Hủy"
                                                               id="btn_cancel_new" name="btn_cancel_new">
                                                    </p>
                                                </div>

                                            </form>
                                            <div id="divpa" style="padding-bottom: 15px; padding-top: 8px;">
                                                <i class="fa fa-key" style=" padding-left: 15px; "></i>
                                                <span class="label" style="font-size: 17px;"> Mật khẩu:</span>
                                                <p onclick="editPass()"
                                                   style="float: right; padding-left: 10px; padding-right: 15px;"><i
                                                            class="fa fa-pencil-square-o"></i> Chỉnh sửa</p>
                                                <span class="" style="font-weight: bold; float: right;">*********</span>
                                            </div>
                                        </div>
                                        <!--/ End Single Course -->
                                    </div>
                                    <div class="col-lg-8 col-12" id="info">
                                        <!-- Course Features -->
                                        <div class="">
                                            <div style="line-height: 3; font-size: 15px; font-weight: bold">
                                                <table border="1" style="border: double slategray">
                                                    <thead>
                                                    <tr>
                                                        <th colspan="2" style="text-align: center"><h4
                                                                    style="line-height: 3;">Thông tin cá nhân</h4></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td width="25%" style="padding-left: 15px;">
                                                            <i class="fa fa-pied-piper-alt"></i>
                                                            <span class="label">Họ và tên:</span>
                                                        </td>
                                                        <td style="text-align: right">
                                                            <div id="divFullname">
                                                                {{$user = Auth::user()->full_name}}
                                                                <p class="editUser"
                                                                   style="float: right; padding-left: 10px; color: blue;"
                                                                   onclick="editName();">
                                                                    <i class="fa fa-pencil-square-o"
                                                                       style="padding-right: 5px;">Chỉnh sửa</i>
                                                                </p>
                                                            </div>
                                                            <form method="post" action="">
                                                                <div style="padding-right: 10px; display: none;"
                                                                     id="divEditFullname">
                                                                    <input type="hidden" name="_token"
                                                                           value="<?= csrf_token() ?>">
                                                                    <input type="text" required name="fullname"
                                                                           id="full_name" onkeyup="checkName()"
                                                                           value="{{$user = Auth::user()->full_name}}"/>
                                                                    <input type="submit" value="Lưu lại"
                                                                           style="line-height: 2.5; width: 75px; background-color: green; font-weight: bolder;"/>
                                                                    <input type="reset" value="Hủy"
                                                                           onclick="cancelFullname()"
                                                                           style="line-height: 2.5; width: 75px; background-color: red; font-weight: bolder;"/>
                                                                </div>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left: 15px;">
                                                            <i class="fa fa-birthday-cake"></i>
                                                            <span class="label">Ngày sinh:</span>
                                                        </td>
                                                        <td style="text-align: right">
                                                            <div id="divBirthday">
                                                                {{$user = Auth::user()->birthday}}
                                                                <p style="float: right; padding-left: 10px; color: blue;"
                                                                   onclick="editBirthday();">
                                                                    <i class="fa fa-pencil-square-o"
                                                                       style="padding-right: 5px;">Chỉnh sửa</i>
                                                                </p>
                                                            </div>
                                                            <form method="post">
                                                                <div style="padding-right: 10px; display: none;"
                                                                     id="divEditBirthday">
                                                                    <input type="hidden" name="_token"
                                                                           value="<?= csrf_token() ?>">
                                                                    <input type="date" required name="birthday"
                                                                           min="1990-12-31" max="2010-01-01"
                                                                           value="{{$user = Auth::user()->birthday}}">
                                                                    <input type="submit" value="Lưu lại"
                                                                           style="line-height: 2.5; width: 75px; background-color: green; font-weight: bolder;"/>
                                                                    <input type="reset" value="Hủy"
                                                                           onclick="cancelBirthday()"
                                                                           style="line-height: 2.5; width: 75px; background-color: red; font-weight: bolder;"/>
                                                                </div>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left: 15px;">
                                                            <i class="fa fa-phone"></i>
                                                            <span class="label">Số điện thoại:</span>
                                                        </td>
                                                        <td style="text-align: right">
                                                            <div id="divPhone">
                                                                {{$user = Auth::user()->phone}}
                                                                <p style="float: right; padding-left: 10px; color: blue;"
                                                                   onclick="editPhone();">
                                                                    <i class="fa fa-pencil-square-o"
                                                                       style="padding-right: 5px;">Chỉnh sửa</i>
                                                                </p>
                                                            </div>
                                                            <form method="post">
                                                                <div style="padding-right: 10px; display: none;"
                                                                     id="divEditPhone">
                                                                    <input type="hidden" name="_token"
                                                                           value="<?= csrf_token() ?>">
                                                                    <input type="text" required name="phone" id="phone"
                                                                           onkeyup="check_phone()"
                                                                           value="{{$user = Auth::user()->phone}}">
                                                                    <input type="submit" value="Lưu lại"
                                                                           id="update_phone"
                                                                           style="line-height: 2.5; width: 75px; background-color: green; font-weight: bolder;"/>
                                                                    <input type="reset" value="Hủy"
                                                                           onclick="cancelPhone()"
                                                                           style="line-height: 2.5; width: 75px; background-color: red; font-weight: bolder;"/>
                                                                </div>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left: 15px;">
                                                            <i class="fa fa-graduation-cap"></i>
                                                            <span class="label">Trường học:</span>
                                                        </td>
                                                        <td style="text-align: right">
                                                            <div id="div_school">
                                                                {{Auth::user()->at_school}}
                                                                <p style="float: right; padding-left: 10px; color: blue;"
                                                                   onclick="edit_school();">
                                                                    <i class="fa fa-pencil-square-o"
                                                                       style="padding-right: 5px;">Chỉnh sửa</i>
                                                                </p>
                                                            </div>
                                                            <form method="post">
                                                                <div style="padding-right: 10px; display: none;"
                                                                     id="div_edit_school">
                                                                    <input type="hidden" name="_token"
                                                                           value="<?= csrf_token() ?>">
                                                                    <input type="text" required name="at_school"
                                                                           id="at_school"
                                                                           value="{{Auth::user()->at_school}}">
                                                                    <input type="submit" value="Lưu lại"
                                                                           id="update_school"
                                                                           style="line-height: 2.5; width: 75px; background-color: green; font-weight: bolder;"/>
                                                                    <input type="reset" value="Hủy"
                                                                           onclick="cancel_school()"
                                                                           style="line-height: 2.5; width: 75px; background-color: red; font-weight: bolder;"/>
                                                                </div>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left: 15px;">
                                                            <i class="fa fa-envelope-o"></i>
                                                            <span class="label">Email:</span>
                                                        </td>
                                                        <td style="text-align: right">
                                                            <div>
                                                                {{$user = Auth::user()->email}}
                                                                <p style="float: right; padding-left: 10px; color: red;">
                                                                    @if(Auth::user()->status == 1)
                                                                        <i class="fa fa-warning"
                                                                           style="padding-right: 5px;"
                                                                           title="Chưa xác thực email"></i>
                                                                    @else
                                                                        <i class="fa fa-check-square-o"
                                                                           style="padding-right: 5px; color: green"
                                                                           title="Email đã được xác thực"></i>
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left: 15px;">
                                                            <i class="fa fa-facebook-square"></i>
                                                            <span class="label">Facebook:</span>
                                                        </td>
                                                        <td style="text-align: right">
                                                            <div id="divFacebook">
                                                                <a href="{{$user = Auth::user()->facebook}}"
                                                                   target="_blank">{{$user = Auth::user()->facebook}}</a>
                                                                <p style="float: right; padding-left: 10px; color: blue;"
                                                                   onclick="editFacebook();">
                                                                    <i class="fa fa-pencil-square-o"
                                                                       style="padding-right: 5px;">Chỉnh sửa</i>
                                                                </p>
                                                            </div>
                                                            <form method="post">
                                                                <div style="padding-right: 10px; display: none;"
                                                                     id="divEditFacebook">
                                                                    <input type="hidden" name="_token"
                                                                           value="<?= csrf_token() ?>">
                                                                    <input type="text" required name="facebook"
                                                                           value="{{$user = Auth::user()->facebook}}">
                                                                    <input type="submit" value="Lưu lại"
                                                                           style="line-height: 2.5; width: 75px; background-color: green; font-weight: bolder;"/>
                                                                    <input type="reset" value="Hủy"
                                                                           onclick="cancelFacebook()"
                                                                           style="line-height: 2.5; width: 75px; background-color: red; font-weight: bolder;"/>
                                                                </div>
                                                            </form>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="padding-left: 15px;">
                                                            <i class="fa fa-money"></i>
                                                            <span class="label">Tài khoản:</span>
                                                        </td>
                                                        <td style="text-align: right">
                                                            <div>
                                                                {{$user = Auth::user()->money}}
                                                                <p style="float: right; padding-left: 10px; color: blue;">
                                                                    <i class="fa fa-plus-square"
                                                                       style="padding-right: 5px;"></i>
                                                                    <a href="" style="padding-right: 5px; color: green">Nộp
                                                                        tiền</a>
                                                                </p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="text-align: right; padding-right: 15px;">
                                                            <i class="fa fa-sign-out"></i>
                                                            <a href="{{url('/logout_user')}}"
                                                               style=" color: blue;"><span
                                                                        class="label">Đăng xuất</span></a>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--/ End Course Features -->
                                    </div>

                                    <!--Change Password-->
                                    <div class="col-lg-8 col-12" id="divPass" style="display: none;">
                                        <div class="">
                                            <div style="line-height: 4; font-size: 15px; font-weight: bold">
                                                <form action="{{url('user/account/update_password')}}" method="post">
                                                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                                    <table border="1" style="border: double slategray">
                                                        <thead>
                                                        <tr>
                                                            <th colspan="2" style="text-align: center"><h4
                                                                        style="line-height: 3;">Thay đổi mật khẩu</h4>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <label id="txt_confirm_password"
                                                                   style="color: #ff2e44;"></label>
                                                        </tr>
                                                        </thead>
                                                        <tbody style="text-align: justify">
                                                        <tr>
                                                            <td colspan="2" style="padding-left: 35px;">
                                                                <div style="padding-right: 5px; padding-left: 5px;">
                                                                    <label style="padding-right: 50px;">Nhập mật khẩu
                                                                        cũ:</label>
                                                                    <input type="password" required
                                                                           name="old_password"
                                                                           style="width: 60%; padding-right: 5px;">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="padding-left: 35px;">
                                                                <div style="padding-right: 5px; padding-left: 5px;">
                                                                    <label style="padding-right: 40px;">Nhập mật khẩu
                                                                        mới:</label>
                                                                    <input type="password" required name="new_password"
                                                                           id="new_password"
                                                                           onkeyup="cp()"
                                                                           style="width: 60%; padding-right: 5px;">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="padding-left: 35px;">
                                                                <div style="padding-right: 5px; padding-left: 5px;">
                                                                    <label style="padding-right: 20px;">Nhập lại mật
                                                                        khẩu mới:</label>
                                                                    <input type="password" required id="repassword"
                                                                           name="repassword" onkeyup="cp()"
                                                                           style="width: 60%; padding-right: 5px;">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"
                                                                style="text-align: center; padding-left: 5px;">
                                                                <input type="submit" value="Thay đổi mật khẩu"
                                                                       id="change_password" name="change_password"
                                                                       onclick="check_password()"
                                                                       style="line-height: 2.5; width: 175px; background-color: green; font-weight: bolder;"/>
                                                                <input type="reset" value="Hủy thay đổi mật khẩu"
                                                                       onclick="cancelPass()"
                                                                       style="line-height: 2.5; width: 175px; background-color: red; font-weight: bolder;"/>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--\End Change Password-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @else
        <div style="padding-top: 100px; padding-bottom: 100px;">
            <p style="text-align: center;"><a href="{{ url('/login')}}">Đăng nhập để thực hiện chức năng này</a></p>

        </div>

    @endif

@endsection
@section('script')
    <script>
        //Chọn ảnh lên và xử lí
        var cur_img = document.getElementById('img_avatar').src;

        function showImagePreview() {
            var fileInput = $("#img_user");
            if (fileInput !== null) {
                //Mở cửa sổ và chọn anhr
                fileInput.trigger("click");
                fileInput.change(function () {
                    $('#img_show').removeClass("hidden_show");
                    $('#lb_show').addClass("hidden_show");
                    if (this.files && this.files[0]) {
                        // Sau khi chọn xong ảnh sẽ chuyển ảnh sang mã Base64 và đọc
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#img_avatar').attr('src', e.target.result);
                            $('#img_avatar').attr('width', 150);
                            $('#img_avatar').attr('height', 150);
                        }
                        reader.readAsDataURL(this.files[0])
                        document.getElementById("bt_save_cancel").style.display = 'block';
                    }
                });
            }
        }

        //Cancel upload avatar
        function btCancel() {
            document.getElementById('img_avatar').src = cur_img;
            document.getElementById("bt_save_cancel").style.display = 'none';
        }

        //confirm password
        function cp() {
            var password = document.getElementsByName("new_password")[0].value;
            var confirmPassword = document.getElementsByName("repassword")[0].value;
            if (password != confirmPassword) {
                document.getElementById("change_password").disabled = true;
                document.getElementById("txt_confirm_password").innerHTML = "Nhập lại mật khẩu không chính xác";
            } else {
                document.getElementById("change_password").disabled = false;
                document.getElementById("txt_confirm_password").innerHTML = "";
            }
        }

        //check password
        function check_password() {
            var password = document.getElementById('new_password').value;
            console.log(password.length);
            if (password.length < 6) {
                document.getElementById('change_password').disabled = true;
                $.alert('Mật khẩu lớn hơn hoặc bằng 6 ký tự');
                return false;
            } else {
                document.getElementById('change_password').disabled = false;
            }
        }

        // check images before submit
        function check() {
            if (document.getElementById('img_user').value == "") {
                alert("Vui lòng chọn ảnh làm ảnh đại diện");
                return false;
            }
            if ((document.getElementById('img_user').value.lastIndexOf(".jpg") == -1)
                && (document.getElementById('img_user').value.lastIndexOf(".gif") == -1)
                && (document.getElementById('img_user').value.lastIndexOf(".png") == -1)) {
                alert("File bạn chọn không hợp lệ, vui lòng chọn lại");
                document.getElementById('img_avatar').src = cur_img;
                document.getElementById("bt_save_cancel").style.display = 'none';
                return false
            }
            return true
        }

        function checkName() {
            var name = document.getElementById('full_name').value;
            if (name == "") {
                alert("Bạn không được để trống tên của mình.");
                return false;
            }
            document.getElementById('full_name').value = name;
            return true;
        }

        function check_phone() {
            var phone = document.getElementById('phone').value;
            if (isNaN(phone)) {
                document.getElementById('update_phone').disabled = true;
                alert("Số điện thoại không được chứa ký tự khác số");
                return false;
            }
            document.getElementById('update_phone').disabled = false;
        }

        function editName() {
            document.getElementById('divFullname').style.display = 'none';
            document.getElementById('divEditFullname').style.display = 'inline';
        }

        function cancelFullname() {
            document.getElementById('divFullname').style.display = 'block';
            document.getElementById('divEditFullname').style.display = 'none';
        }

        function editBirthday() {
            document.getElementById('divBirthday').style.display = 'none';
            document.getElementById('divEditBirthday').style.display = 'inline';
        }

        function cancelBirthday() {
            document.getElementById('divBirthday').style.display = 'block';
            document.getElementById('divEditBirthday').style.display = 'none';
        }

        function editPhone() {
            document.getElementById('divPhone').style.display = 'none';
            document.getElementById('divEditPhone').style.display = 'inline';
        }

        function cancelPhone() {
            document.getElementById('divPhone').style.display = 'block';
            document.getElementById('divEditPhone').style.display = 'none';
        }

        function edit_school() {
            document.getElementById('div_school').style.display = 'none';
            document.getElementById('div_edit_school').style.display = 'inline';
        }

        function cancel_school() {
            document.getElementById('div_school').style.display = 'block';
            document.getElementById('div_edit_school').style.display = 'none';
        }

        function editFacebook() {
            document.getElementById('divFacebook').style.display = 'none';
            document.getElementById('divEditFacebook').style.display = 'inline';
        }

        function cancelFacebook() {
            document.getElementById('divFacebook').style.display = 'block';
            document.getElementById('divEditFacebook').style.display = 'none';
        }

        function formatBirthday() {
            var d = document.getElementById('birthday1').value;
            var n = d.toLocaleDateString();
            document.getElementById("birthday2").innerHTML = n;
        }

        function editPass() {
            document.getElementById('info').style.display = 'none';
            document.getElementById('divPass').style.display = 'block';
            document.getElementById('divpa').style.display = 'none';
        }

        function cancelPass() {
            document.getElementById('info').style.display = 'block';
            document.getElementById('divPass').style.display = 'none';
            document.getElementById('divpa').style.display = 'block';
        }
    </script>
@endsection