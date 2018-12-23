<?php

namespace App\Http\Controllers\Auth;

use App\DAO\DaoStudent\AccountDaoUser;
use App\Http\Controllers\Controller;
use App\Mail\MailForgotPassword;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    protected $_db_user;

    public function __construct()
    {
        $this->_db_user = new AccountDaoUser();
    }

    /**
     * display view forget password
     * @return \Exception|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get_forgot_password()
    {
        try {
            return view('auth.passwords.email');
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * send email for user
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function post_forgot_password(Request $request)
    {
        $this->validate($request,
            [
                'email' => 'required|email|exists:user,email'
            ],
            [
                'email.required' => "Hãy nhập vào email của bạn",
                'email.email' => "Email không đúng định dạng",
                'email.exists' => "Email này không tồn tại"
            ]);
        try {
            $email = $request['email'];
            $password = str_random(6);
            Mail::to($email)->queue(new MailForgotPassword($password));
            $rs = $this->_db_user->forgot_password($email, $password);
            if (is_numeric($rs) && $rs == 1) {
                return redirect('login')
                    ->with('message_success', 'Lấy lại mật khẩu thành công, xem mật khẩu được gửi trnog mail');
            } else {
                return redirect('login')->with('message_notification', 'Lấy lại mật khẩu thất bại');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}
