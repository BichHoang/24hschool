<?php

namespace App\Http\Controllers\User;

use App\DAO\DaoStudent\ClassDao;
use App\DAO\DaoStudent\ErrorsExamDao;
use App\DAO\DaoStudent\ExamDaoUser;
use App\DAO\DaoStudent\ExamHistoryDao;
use App\DAO\DaoStudent\SubjectDao;
use App\Http\System\SystemStringParameter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\TblType_book;
use App\User;
use App\TblSubject;
use App\TblExam;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller implements ShouldQueue
{
    private $_db_exam_user;
    private $_db_exam_history;
    private $_db_error;
    private $_db_subject;
    private $_db_class;

    function __construct()
    {
        $type_book = TblType_book::all();
        $this->_db_subject = new SubjectDao();
        $this->_db_exam_user = new ExamDaoUser();
        $this->_db_class = new ClassDao();
        $subject = $this->_db_subject->get_subject_and_number_exam();
        $class = $this->_db_class->get_class_and_number_exam();
        $most_exam = $this->_db_exam_user->get_list_most_exam();
        $newest_exam = $this->_db_exam_user->get_list_new_exam();

        if (Auth::check()) {
            $user = Auth::user();
            view()->share('user', $user);
        }
        view()->share('type_book', $type_book);
        view()->share('subject', $subject);
        view()->share('class', $class);
        view()->share('most_exam', $most_exam);
        view()->share('newest_exam', $newest_exam);
        $this->_db_exam_history = new ExamHistoryDao();
        $this->_db_error = new ErrorsExamDao();
    }

    /**
     * display list exam free for user
     * @return $this
     */
    function get_list_exam_free()
    {
        try {
            $data = $this->_db_exam_user->get_list_exam_free();
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_EXAM());
            return view('user.exam.show')
                ->with('data', $data_send);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * search in all exam
     * @param $search
     * @return $this|\Exception
     */
    public function get_search_exam($search)
    {
        try {
            $search = trim($search, " ");
            $data = $this->_db_exam_user->get_list_exam_for_search($search);
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_EXAM());
            return view('user.exam.show')
                ->with('data', $data_send);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function post_search_exam(Request $request, $search)
    {
        try {
            $search = trim($request['search'], " ");
            if ($search == "") {
                return redirect('user/exam/search-%20');
            } else {
                return redirect('user/exam/search-' . $search);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * show list exam bought by coin
     * @return $this|\Exception
     */
    function get_list_exam_coin()
    {
        try {
            $data = $this->_db_exam_user->get_list_exam_coin();
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_EXAM());
            return view('user.exam.show')
                ->with('data', $data_send);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * show view for user do exam free
     * @param $id_exam
     * @return $this
     */
    function get_do_exam_free($id_exam)
    {
        try {
            $exam = $this->_db_exam_user->get_one_exam_free($id_exam);
            if (is_null($exam)) {
                return redirect()->back()
                    ->with('message_notification', "Không thể làm đề thi mất phí");
            }
            $fetch_time = time();
            return view('user.exam.do_exam')
                ->with('exam', $exam)
                ->with('fetch_time', $fetch_time);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * send answer to server and send result for user
     * @param Request $request
     * @param $id_exam
     * @return \Exception|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post_do_exam_free(Request $request, $id_exam)
    {
        try {
            $type_exam = 1;
            $exam = $this->_db_exam_user->get_one_exam_free($id_exam);
            $right_answer = json_decode($exam->list_answer);
            $time_send_answer = time();
            $fetch_time = $request['fetch_time'] + 5;
            $total_time = $time_send_answer - $fetch_time;

            //check qua thoi gian nop bai
            if ($total_time > ($exam->time * 60 + 10)) {
                return redirect('/')->with('message_notification', "Hết thời gian làm bài, không thể nộp");
            }

            $answer_of_user = $this->get_answer_from_task($exam->number_of_questions, $request);
            $answer_of_user_json = json_encode($answer_of_user);
            //check right answer
            $total_right_answer = 0;
            foreach ($right_answer as $index => $value) {
                if ($value->answer == $answer_of_user[$index]['answer']) {
                    $total_right_answer++;
                }
            }
            $point = round(($total_right_answer / $exam->number_of_questions) * 10, 2);
            $comment = $request['comment'];
            $link = $this->choose_video_link($point);
            $errors = trim($request['errors'], " ");
            if ($errors != null && $errors != "") {
                $ss = $this->_db_error->save_errors($errors, $id_exam, Auth::user()->id);
            }
            $rs = $this->_db_exam_history->save_exam_history_free($id_exam, $point, $fetch_time, $answer_of_user_json,
                $type_exam, $time_send_answer, $total_right_answer, $exam, $total_time, $comment, $link);
            $rs_exam_increment = $this->_db_exam_user->increment_joined($exam);
            if (!is_numeric($rs)) {
                $exam_history = $this->_db_exam_history->get_one_exam_history($rs);
                return view('user.exam.exam_free.result_do_exam_free')
                    ->with('exam', $exam)
                    ->with('exam_history', $exam_history);
            } else {
                return redirect('exam/all')->with('message_notification', "Nộp bài thất bại");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * show view for user do exam free
     * @param $id_exam
     * @return $this
     */
    function get_do_exam_coin($id_exam)
    {
        try {
            return view('page.development');
            $exam = $this->_db_exam_user->get_one_exam_free($id_exam);
            if (is_null($exam)) {
                return redirect()->back()
                    ->with('message_notification', "Không thể làm đề thi mất phí");
            }
            $fetch_time = time();
            return view('user.exam.do_exam')
                ->with('exam', $exam)
                ->with('fetch_time', $fetch_time);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * send answer to server and send result for user
     * @param Request $request
     * @param $id_exam
     * @return \Exception|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post_do_exam_coin(Request $request, $id_exam)
    {
        try {
            $type_exam = 1;
            $exam = $this->_db_exam_user->get_one_exam_free($id_exam);
            $right_answer = json_decode($exam->list_answer);
            $time_send_answer = time();
            $fetch_time = $request['fetch_time'];
            $total_time = $time_send_answer - $fetch_time;

            //check qua thoi gian nop bai
            if ($total_time > ($exam->time * 60 + 5)) {
                return redirect('/')->with('message_notification', "Hết thời gian làm bài, không thể nộp");
            }

            $answer_of_user = $this->get_answer_from_task($exam->number_of_questions, $request);
            $answer_of_user_json = json_encode($answer_of_user);
            //check right answer
            $total_right_answer = 0;
            foreach ($right_answer as $index => $value) {
                if ($value->answer == $answer_of_user[$index]['answer']) {
                    $total_right_answer++;
                }
            }
            $point = round($total_right_answer / $exam->number_of_questions, 2);
            $comment = $request['comment'];
            $link = $this->choose_video_link($point);
            $errors = trim($request['errors'], " ");
            if ($errors != null && $errors != "") {
                $ss = $this->_db_error->save_errors($errors, $id_exam, Auth::user()->id);
            }
            $rs = $this->_db_exam_history->save_exam_history_free($id_exam, $point, $fetch_time, $answer_of_user_json,
                $type_exam, $time_send_answer, $total_right_answer, $exam, $total_time, $comment, $link);
            $rs_exam_increment = $this->_db_exam_user->increment_joined($exam);
            if (!is_numeric($rs)) {
                $exam_history = $this->_db_exam_history->get_one_exam_history($rs);
                return view('user.exam.result_do_exam_free')
                    ->with('exam', $exam)
                    ->with('exam_history', $exam_history);
            } else {
                return redirect('exam/all')->with('message_notification', "Nộp bài thất bại");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * video dinh huong phu hop voi hoc sinh sau khi lam bai
     * @param $point
     * @return \Exception|int
     */
    public function choose_video_link($point)
    {
        try {
            $basic = 1;
            $normal = 2;
            $hard = 3;
            if ($point < 5) {
                $video = $this->_db_exam_user->get_a_video($basic);
                return $video->link;
            } else if ($point < 8) {
                $video = $this->_db_exam_user->get_a_video($normal);
                return $video->link;
            } else {
                $video = $this->_db_exam_user->get_a_video($hard);
                return $video->link;
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * get list answer of user
     * @param $number_of_questions
     * @param $request
     * @return \Exception
     */
    public function get_answer_from_task($number_of_questions, $request)
    {
        try {
            $answer_of_user = null;
            for ($index = 1; $index <= $number_of_questions; $index++) {
                if ($request[$index] <= 4 && $request[$index] >= 1) {
                    $answer_of_user[] = [
                        'stt' => $index,
                        'answer' => $request[$index]
                    ];
                } else {
                    $answer_of_user[] = [
                        'stt' => $index,
                        'answer' => 0
                    ];
                }
            }
            return $answer_of_user;
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * get all exam by subject
     * @param $id_subject
     * @return $this|\Exception
     */
    public function get_exam_by_subject($slug, $id_subject)
    {
        try {
            $data = $this->_db_exam_user->get_list_exam_by_subject($id_subject);
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_EXAM());
            return view('user.exam.show')
                ->with('data', $data_send);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * get all exam by class
     * @param $slug
     * @param $id_class
     * @return $this|\Exception
     */
    public function get_exam_by_class($slug, $id_class)
    {
        try {
            $data = $this->_db_exam_user->get_list_exam_by_class($id_class);
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_EXAM());
            return view('user.exam.show')
                ->with('data', $data_send);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

}
