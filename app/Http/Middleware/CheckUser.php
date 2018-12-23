<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user->role == 0) {
            if ($user->full_name == null ||
                $user->birthday == null ||
                $user->phone == null ||
                $user->at_school == null) {

                return redirect('user/complete_information')
                    ->with('message_notification', "Bạn hãy hoàn thành phần thông tin cá nhân");
            } else {
                return $next($request);
            }
        } else {
            return redirect('login')->with('message_notification', "Bạn phải đăng nhập để dùng dịch vụ");
        }

    }
}
