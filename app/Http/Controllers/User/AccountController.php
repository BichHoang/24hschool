<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\TblType_book;
use App\User;
use DateTime;
use App\DAO\DaoStudent\AccountDaoUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    private $_db_student_user;

    function __construct()
    {
        $type_book = TblType_book::all();
        view()->share('type_book', $type_book);
        $this->_db_student_user = new AccountDaoUser();
    }

    /**
     * display view account information
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get_user_information()
    {
        return view('user.account.infor');
    }

    /**
     * update user information
     * @param Request $request
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_user_information(Request $request)
    {
        try {
            //update full_name
            if ($request->has('fullname') && !empty($request['fullname'])) {
                $fullName = $request->input('fullname');
                $rs = $this->_db_student_user->update_full_name($fullName);
                if(is_numeric($rs) && $rs == 1){
                    return redirect()->back()
                        ->with('message_success', "Thay đổi họ tên thành công");
                }else{
                    return redirect()->back()
                        ->with('message_notification', "Thay đổi họ tên thất bại");
                }
            }

            //update birthday
            if ($request->has('birthday') && !empty($request['birthday'])) {
                $birthday = $request->input('birthday');
                $rs = $this->_db_student_user->update_birthday($birthday);
                if(is_numeric($rs) && $rs == 1){
                    return redirect()->back()
                        ->with('message_success', "Thay đổi ngày sinh thành công");
                }else{
                    return redirect()->back()
                        ->with('message_notification', "Thay đổi ngày sinh thất bại");
                }
            }

            //update phone
            if ($request->has('phone') && !empty($request['phone'])) {
                $phone = $request->input('phone');
                $rs = $this->_db_student_user->update_phone($phone);
                if(is_numeric($rs) && $rs == 1){
                    return redirect()->back()
                        ->with('message_success', "Thay đổi số điện thoại thành công");
                }else{
                    return redirect()->back()
                        ->with('message_notification', "Thay đổi số điện thoại thất bại");
                }
            }

            //update school
            if ($request->has('at_school') && !empty($request['at_school'])) {
                $school = $request['at_school'];
                $rs = $this->_db_student_user->update_at_school($school);
                if(is_numeric($rs) && $rs == 1){
                    return redirect()->back()
                        ->with('message_success', "Thay đổi trường học thành công");
                }else{
                    return redirect()->back()
                        ->with('message_notification', "Thay đổi trường học  thất bại");
                }
            }

            //update facebook
            if ($request->has('facebook') && !empty($request['facebook'])) {
                $facebook = $request->input('facebook');
                $rs = $this->_db_student_user->update_facebook($facebook);
                if(is_numeric($rs) && $rs == 1){
                    return redirect()->back()
                        ->with('message_success', "Thay đổi facebook thành công");
                }else{
                    return redirect()->back()
                        ->with('message_notification', "Thay đổi facebook thất bại");
                }
            }
            //update avatar
            if ($request->hasFile('img_avatar')) {
                $file = $request->file('img_avatar');
                $idUser = Auth::user()->id;
                $extension = $file->getClientOriginalExtension();
                $fileName = time() . '_' . $idUser . $extension;
                $file->move('avatar', $fileName);
                $rs = $this->_db_student_user->upload_avatar($fileName);
                if(is_numeric($rs) && $rs == 1){
                    return redirect()->back()
                        ->with('message_success', "Thay đổi avatar thành công");
                }else{
                    return redirect()->back()
                        ->with('message_notification', "Thay đổi avatar thất bại");
                }
            }
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    /**
     * change password of user was logged
     * @param Request $request
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_user_password(Request $request)
    {
        try {
            $old_password = $request['old_password'];
            $new_password = $request['new_password'];
            $repassword = $request['repassword'];
            if (Hash::check($old_password, Auth::user()->password)) {
                if ($new_password == $repassword) {
                    $rs = $this->_db_student_user->update_password($new_password);
                    if (is_numeric($rs) && $rs == 1) {
                        return redirect()->back()->with('message_success', "Thay đổi mật khẩu thành công");
                    } else {
                        return redirect()->back()->with('message_notification', "Thay đổi mật khẩu thất bại");
                    }
                } else {
                    return redirect()->back()->with('message_notification', "Nhập lại mật khẩu không chính xác");
                }
            }
            return redirect()->back()
                ->with('message_notification', "Nhập sai mật khẩu cũ");

        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * display for user complete personal information
     * @return \Exception
     */
    public function get_complete_information(){
        try{
            $user = Auth::user();
            $full_name = $user->full_name;
            $birthday = $user->birthday;
            $phone = $user->phone;
            $at_school = $user->at_school;

            return view('user.account.complete_information')
                ->with('full_name', $full_name)
                ->with('birthday', $birthday)
                ->with('phone', $phone)
                ->with('at_school', $at_school);
        }catch (\Exception $exception ){
            return $exception;
        }
    }

    /**
     * save personal information
     * @param Request $request
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_complete_information(Request $request){
        try{
            if($request->has('full_name')){
                $full_name = $request['full_name'];
                $this->_db_student_user->update_full_name($full_name);
            }
            if($request->has('phone')){
                $phone = $request['phone'];
                $this->_db_student_user->update_phone($phone);
            }
            if($request->has('at_school')){
                $at_school = $request['at_school'];
                $this->_db_student_user->update_at_school($at_school);
            }
            if($request->has('birthday')){
                $birthday = $request['birthday'];
                $this->_db_student_user->update_birthday($birthday);
            }
            $this->_db_student_user->update_complete_infor(Auth::user()->id);
            return redirect('user/exam/exam_free')
                ->with('message_success', "Hoàn thiện thông tin cá nhân");
        }catch (\Exception $exception){
            return $exception;
        }
    }
}
