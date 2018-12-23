<?php

namespace App\Http\Controllers\Auth;

use App\DAO\DaoStudent\AccountDaoUser;
use App\TblType_book;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    private $_db_student_user;

    /**
     * create a new instance of  RegisterController
     *
     * RegisterController constructor.
     */
    public function __construct()
    {
        $type_book = TblType_book::all();
        $this->_db_student_user = new AccountDaoUser();
        view()->share('type_book', $type_book);
    }

    /**
     * show view for user register
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function get_register()
    {
        Auth::logout();
        return view('user.homepage.register');
    }

    /**
     * save user when user register
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function post_register(Request $request)
    {
        $this->validate($request,
            [
                'email' => 'required|email|unique:user,email',
                'password' => 'required|min:6|max:20',
                're_password' => 'required|same:password',
                'full_name' => 'required|min:6|max:250'
            ],
            [
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Không đúng định dạng email',
                'email.unique' => 'Email đã có người sử dụng',
                'password.required' => 'Vui lòng nhập mật khẩu',
                're_password.same' => 'Mật khẩu không giống nhau',
                'password.min' => 'Mật khẩu ít nhất 6 kí tự',
                'full_name.min' => 'Họ ít nhất 6 ký tự',
                'full_name.max' => 'Họ tên nhiều nhất 250 ký tự'
            ]);

        try {
            $email = $request->email;
            $full_name = $request->full_name;
            $password = bcrypt($request->password);
            $phone = $request->phone;
            $at_school = $request->at_school;
            $birthday = $request->birthday;

            $rs = $this->_db_student_user->register_user($email, $full_name, $password, $phone, $at_school, $birthday);
            if ($rs) {
                return redirect('login')->with('message_success', 'Tạo tài khoản thành công');
            } else {
                return redirect()->back()->with('success', 'Tạo tài khoản thất bại');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
