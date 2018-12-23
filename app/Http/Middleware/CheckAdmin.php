<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
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
        $admin = Auth::user();
        if ($admin->role == 9) {
            return $next($request);
        } else {
            return redirect('login')->with(["message_notification" =>"Bạn phải đăng nhập với tư cách admin"]);
        }
    }
}
