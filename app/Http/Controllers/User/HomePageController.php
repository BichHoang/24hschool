<?php

namespace App\Http\Controllers\User;

use App\TblExam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\TblTopic;
use App\TblType_book;

class HomePageController extends Controller
{
    public function getIndex(){
    	$type_book = TblType_book::all();
    	$exam = TblExam::all();
        return view('user.homepage.index')
            ->with('type_book', $type_book)
            ->with('exam', $exam);
    }
}
