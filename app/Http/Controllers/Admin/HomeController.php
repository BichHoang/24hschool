<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 6/13/2018
 * Time: 9:19 AM
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function home(){
        try{
            return view('admin.home')->with('message_success', "Đăng nhập thành công");
        }catch (\Exception $ex){
            return redirect()->back()->with('message_notification', "Đăng nhập thất bại");
        }
    }
}