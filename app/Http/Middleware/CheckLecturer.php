<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckLecturer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $lecturer = Auth::user();
        if ($lecturer->role == 5) {
            return $next($request);
        } else {
            return redirect('login')->with(["message_notification" =>"Bạn phải đăng nhập với tư cách giáo viên"]);
        }
    }
}
