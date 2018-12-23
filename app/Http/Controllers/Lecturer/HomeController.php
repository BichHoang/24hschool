<?php

namespace App\Http\Controllers\Lecturer;

use App\TblExam;
use App\TblSubject;
use App\TblTopic;
use App\TblType_book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ramsey\Uuid\Uuid;

class HomeController extends Controller
{
    public function home()
    {
        try {
            return view('lecturer.home')
                ->with('message_success', "Bạn đăng nhập thành công với tư cách giáo viên");
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function test(){
        echo Uuid::uuid4()->toString();
    }
}
