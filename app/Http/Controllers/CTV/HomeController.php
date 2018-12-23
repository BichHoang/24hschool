<?php

namespace App\Http\Controllers\CTV;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function home(){
        try{
            return view('ctv.home')->with('message_success',"Đăng nhập thành công");
        }catch (\Exception $ex){
            return redirect('maintenance');
        }
    }
}
