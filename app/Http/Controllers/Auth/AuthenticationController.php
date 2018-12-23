<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{
    public function login_get()
    {
        return view('login');
    }

    public function login_post(Request $request)
    {
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
            return 1000;
            $errors = "";
            if ($user["status"] == '2') {
                return redirect()->back()->with('message_notification', "Tài khoản hoặc mật khẩu không đúng");
            }
            //admin
            if ($user["role"] == 9) {
                session()->regenerate();
                return redirect('admin/home');
            }
            //manager
            if ($user["role"] == 5) {
                session()->regenerate();
                return redirect('manager/home');
            }
            //employee
            if ($user["role"] == 1) {
                session()->regenerate();
                return redirect('employee/home');
            }

            return redirect()->back()->with('message_notification', "Tài khoản hoặc mật khẩu không đúng");
        } else {

            return redirect()->back()->with('message_notification', "Tài khoản hoặc mật khẩu không đúng");
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect("login");
    }
}
