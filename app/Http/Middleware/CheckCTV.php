<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckCTV
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
        $ctv = Auth::user();
        if($ctv->role == 4){
            return $next($request);
        }else{
            return redirect('login')->with('message_notification', "Bạn phải chưa truy cập với tư cách cộng tác viên");
        }
    }
}
