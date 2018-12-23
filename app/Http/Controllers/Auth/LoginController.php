<?php

namespace App\Http\Controllers\Auth;

use App\DAO\DaoStudent\ExamDaoUser;
use App\DAO\DaoStudent\SubjectDao;
use App\Http\Controllers\Controller;
use App\TblType_book;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    protected $maxAttempts = 5;
    protected $decayMinutes = 5;

    private $_db_exam_user;
    private $_db_subject;

    public function __construct()
    {
        $type_book = TblType_book::all();
        $this->_db_subject = new SubjectDao();
        $this->_db_exam_user = new ExamDaoUser();
        $subject = $this->_db_subject->get_subject_and_number_exam();
        $most_exam = $this->_db_exam_user->get_list_most_exam();
        $newest_exam = $this->_db_exam_user->get_list_new_exam();

        view()->share('type_book', $type_book);
        view()->share('subject', $subject);
        view()->share('most_exam', $most_exam);
        view()->share('newest_exam', $newest_exam);
    }

    /**
     * show view login
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login_get()
    {   
        Auth::logout();
        return view('auth.login');
    }

    /**
     * send email and password for check logging in
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login_post(Request $request)
    {
        try {
            $email = $request['txf_email'];
            $password = $request['txf_password'];

            $is_remember = false;

            $login = [
                'email' => $email,
                'password' => $password
            ];

            if (isset($request["cb_remember"])) {
                $is_remember = $request["cb_remember"];
            }

            if (Auth::attempt($login, $is_remember)) {
                $user = Auth::user();
                if ($user["status"] == 2) {
                    return redirect()->back()->with('message_notification', "Tài khoản đã bị khóa");
                }
                //admin
                if ($user["role"] == 9) {
                    session()->regenerate();
                    return redirect('admin/home')->with('message_success', 'Đăng nhập thành công với tư cách admin');
                }
                //lecturer
                if ($user["role"] == 5) {
                    session()->regenerate();
                    return redirect('lecturer/home')->with('message_success', 'Đăng nhập thành công với tư cách giao vien');
                }
                //CTV
                if ($user["role"] == 4) {
                    session()->regenerate();
                    return redirect('ctv/home')->with('message_success', 'Đăng nhập thành công với tư cách ctv');
                }

                //user
                if ($user["role"] == 0) {
                    session()->regenerate();
                    return redirect('user/exam/exam_free');
                }

                return redirect()->back()->with('message_notification', "Tài khoản không đủ quyền");
            } else {
                return redirect()->back()->with('message_notification', "Tài khoản hoặc mật khẩu không đúng");
            }
        } catch (\Exception $exception) {
            if ($exception instanceof TokenMismatchException) {
                return redirect('login')->with('status', 'Token hết hạn. Vui lòng thử lại.');
            } else {
                return view('errors.404');
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect("login");
    }

    public function logout_user()
    {
        Auth::logout();
        return redirect("/");
    }
}
