<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 7/13/2018
 * Time: 11:47 AM
 */

namespace App\DAO\DaoStudent;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class ExamHistoryDao
{
    /**
     * get one exam history of user by id_exam_history
     * @param $id_exam_history
     * @return \Exception
     */
    public function get_one_exam_history($id_exam_history)
    {
        try {
            return DB::table('exam_history')
                ->where('exam_history.id', $id_exam_history)
                ->join('exam', 'exam_history.id_exam', 'exam.id')
                ->where('exam_history.id_user', Auth::user()->id)
                ->select('exam_history.*', 'exam.number_of_questions as number_of_questions', 'exam.name as exam_name',
                    'exam.explain_file_name as file_explain')
                ->first();
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * save exam history of student do exam
     * @param $id_exam
     * @param $point
     * @param $fetch_time
     * @param $answer_of_user_json
     * @param $type_exam
     * @param $time_send_answer
     * @param $total_right_answer
     * @param $exam
     * @param $total_time
     * @return \Exception
     */
    public function save_exam_history_free($id_exam, $point, $fetch_time, $answer_of_user_json, $type_exam, $time_send_answer,
                                           $total_right_answer, $exam, $total_time, $comment, $link)
    {
        try {
            $actual_test_time_ss = $total_time % 60;
            $actual_test_time_mm = ($total_time - $actual_test_time_ss) / 60;
            $id = Uuid::uuid4();
            $time_to_send_result = date('Y-m-d: H:i:s', $time_send_answer + 86400);
            $rs = DB::table('exam_history')->insert([
                'id' => $id,
                'id_exam' => $id_exam,
                'id_user' => Auth::user()->id,
                'point' => $point,
                'link' => $link,
                'fetch_time' => $fetch_time,
                'answer' => $answer_of_user_json,
                'type_exam' => $type_exam,
                'time_to_send_result' => $time_to_send_result,
                'time_send_answer' => $time_send_answer,
                'total_right_answer' => $total_right_answer,
                'actual_test_time_mm' => $actual_test_time_mm,
                'actual_test_time_ss' => $actual_test_time_ss,
                'class' => $exam->class_name,
                'subject' => $exam->subject_name,
                'level' => $exam->level_name,
                'comment' => $comment,
                'created_at' => date('Y-m-d :H:i:s'),
                'updated_at' => date('Y-m-d :H:i:s'),
            ]);
            if ($rs) {
                return $id;
            } else {
                return 0;
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * get history do exam of user
     * @param $id_user
     * @return \Exception
     */
    public function get_list_exam_history($id_user)
    {
        try {
            return DB::table('exam_history')
                ->where('exam_history.id_user', $id_user)
                ->join('exam', 'exam_history.id_exam', 'exam.id')
                ->select('exam_history.*', 'exam.number_of_questions', 'exam.name as exam_name',
                    'exam.explain_file_name as file_explain')
                ->orderBy('created_at', 'desc');
        } catch (\Exception $ex) {
            return $ex;
        }
    }


}