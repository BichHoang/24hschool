<?php

namespace App\Http\Controllers\User;

use App\DAO\DaoStudent\ExamDaoUser;
use App\DAO\DaoStudent\ExamHistoryDao;
use App\TblSubject;
use App\TblType_book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ExamHistoryController extends Controller
{
    private $_db_exam_history;
    private $_db_exam;

    public function __construct()
    {
        $type_book = TblType_book::all();
        $subject = TblSubject::all();
        if (Auth::check()) {
            $user = Auth::user();
            view()->share('user', $user);
        }
        view()->share('type_book', $type_book);
        view()->share('subject', $subject);
        $this->_db_exam_history = new ExamHistoryDao();
        $this->_db_exam = new ExamDaoUser();
    }

    /**
     * display list history do exam of user
     * @return $this|\Exception
     */
    public function get_list_exam_history(){
        try{
            $exam_history = $this->_db_exam_history->get_list_exam_history(Auth::user()->id);
            $exam_history_send = $exam_history->paginate(10);

            return view('user.exam.history')
                ->with('exam_history', $exam_history_send);
        }catch (\Exception $ex){
            return $ex;
        }
    }


    /**
     * display view history for user
     * @param $id_exam_history
     * @return $this|\Exception|\Illuminate\Http\RedirectResponse
     */
    public function get_one_exam_history($id_exam_history){
        try{
            $exam_history = $this->_db_exam_history->get_one_exam_history($id_exam_history);
            if(is_null($exam_history)){
                return redirect()->back()->with('message_notification', 'Rất tiếc, Lịch sử không tồn tại');
            }else{
                return view('user.exam.detail_result')
                    ->with('exam_history', $exam_history);
            }
        }catch (\Exception $ex){
            return $ex;
        }
    }
}
