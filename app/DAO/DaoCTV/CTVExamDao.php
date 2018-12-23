<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 6/15/2018
 * Time: 10:42 AM
 */

namespace App\DAO\DaoCTV;


use App\Http\System\Convert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

define("EXAM_APPROVED_INTO_WEB", 1);
define("EXAM_APPROVED_INTO_EXAM_DIRECTORY", 2);
define("EXAM_NOT_ANSWER", 3);
define("EXAM_NEED_MODIFY", 4);
define("EXAM_HAVE_ANSWER", 5);
define("EXAM_WAITING_APPROVE", 6);

define("NOT_SEND", 0);
define("REQUEST_APPROVE", 1);
define("REQUEST_END", 4);


class CTVExamDao
{
    /**
     * save file exam and file explain
     *
     * @param $request
     * @param $exam_briefly
     * @param $explain_file_name
     * @return \Exception
     */
    public function upload_exam_and_explain($request, $exam_briefly, $explain_file_name)
    {
        try {
            $slug= Convert::to_slug($request['exam_name']);
            $id = Uuid::uuid4();
            $rs = DB::table('exam')->insert([
                'id' => $id,
                'status' => EXAM_NOT_ANSWER,
                'name' => $request['exam_name'],
                'name_briefly' => $exam_briefly,
                'explain_file_name' => $explain_file_name,
                'id_class' => $request['class_room'],
                'id_subject' => $request['subject'],
                'number_of_questions' => $request['number_question'],
                'id_level' => $request['level'],
                'id_user_post' => Auth::user()->id,
                'id_lecturer' => Auth::user()->id_lecturer,
                'time' => $request['time'],
                'slug' => $slug,
                'created_at' => date('Y-m-d : H:i:s'),
                'updated_at' => date('Y-m-d : H:i:s')
            ]);
            if($rs){
                return $id;
            }else{
                return 0;
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * get a file exam not exam has been approved
     *
     * @param $id_exam
     * @return \Exception
     */
    public function get_a_exam_file($id_exam)
    {
        try {
            return DB::table('exam')
                ->where('exam.id', $id_exam)
                ->where('user.id', Auth::user()->id)
                ->join('user', 'exam.id_user_post', 'user.id')
                ->join('class_room', 'exam.id_class', 'class_room.id')
                ->join('subject', 'exam.id_subject', 'subject.id')
                ->join('level', 'exam.id_level', 'level.id')
                ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                    'level.name as level_name', 'user.full_name as name_user')
                ->first();
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * get one exam for modification
     * @param $id_exam
     * @return \Exception
     */
    public function get_one_exam_for_modification($id_exam)
    {
        try {
            return DB::table('exam')
                ->where('id', $id_exam)
                ->where('id_user_post', Auth::user()->id)
                ->where('request_approve', '<>', REQUEST_END)
                ->first();
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * get list exam file haven't been answer with keyword
     *
     * @param $name
     * @return \Exception
     */
    public function get_list_exam_not_answer($name)
    {
        try {
            if ($name == "") {
                return DB::table('exam')
                    ->where('exam.status', EXAM_NOT_ANSWER)
                    ->where('exam.id_user_post', Auth::user()->id)
                    ->join('class_room', 'exam.id_class', 'class_room.id')
                    ->join('subject', 'exam.id_subject', 'subject.id')
                    ->join('level', 'exam.id_level', 'level.id')
                    ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                        'level.name as level_name')
                    ->orderBy('created_at', 'desc');
            } else {
                return DB::table('exam')
                    ->where('exam.status', EXAM_NOT_ANSWER)
                    ->where('exam.id_user_post', Auth::user()->id)
                    ->where('exam.name', 'like', "%$name%")
                    ->join('class_room', 'exam.id_class', 'class_room.id')
                    ->join('subject', 'exam.id_subject', 'subject.id')
                    ->join('level', 'exam.id_level', 'level.id')
                    ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                        'level.name as level_name')
                    ->orderBy('created_at', 'desc');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * show list exam have answer and ctv save in their exam directory
     *
     * @param $name
     * @return \Exception
     */
    public function get_list_exam_have_answer($name)
    {
        try {
            if ($name == "") {
                return DB::table('exam')
                    ->where('exam.status', EXAM_HAVE_ANSWER)
                    ->where('exam.id_user_post', Auth::user()->id)
                    ->join('class_room', 'exam.id_class', 'class_room.id')
                    ->join('subject', 'exam.id_subject', 'subject.id')
                    ->join('level', 'exam.id_level', 'level.id')
                    ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                        'level.name as level_name')
                    ->orderBy('created_at', 'desc');
            } else {
                return DB::table('exam')
                    ->where('exam.status', EXAM_HAVE_ANSWER)
                    ->where('exam.id_user_post', Auth::user()->id)
                    ->where('exam.name', 'like', "%$name%")
                    ->join('class_room', 'exam.id_class', 'class_room.id')
                    ->join('subject', 'exam.id_subject', 'subject.id')
                    ->join('level', 'exam.id_level', 'level.id')
                    ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                        'level.name as level_name')
                    ->orderBy('created_at', 'desc');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * get exam is waiting approve
     *
     * @param $name
     * @return \Exception
     */
    public function get_list_exam_waiting_approve($name)
    {
        try {
            if ($name == "") {
                return DB::table('exam')
                    ->where('exam.status', EXAM_WAITING_APPROVE)
                    ->where('exam.id_user_post', Auth::user()->id)
                    ->join('class_room', 'exam.id_class', 'class_room.id')
                    ->join('subject', 'exam.id_subject', 'subject.id')
                    ->join('level', 'exam.id_level', 'level.id')
                    ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                        'level.name as level_name')
                    ->orderBy('date_send_request_approve', 'desc');
            } else {
                return DB::table('exam')
                    ->where('exam.status', EXAM_WAITING_APPROVE)
                    ->where('exam.id_user_post', Auth::user()->id)
                    ->where('exam.name', 'like', "%$name%")
                    ->join('class_room', 'exam.id_class', 'class_room.id')
                    ->join('subject', 'exam.id_subject', 'subject.id')
                    ->join('level', 'exam.id_level', 'level.id')
                    ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                        'level.name as level_name')
                    ->orderBy('date_send_request_approve', 'desc');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * get list exam approved on web
     *
     * @param $name
     * @return \Exception
     */
    public function get_exam_on_web($name)
    {
        try {
            if ($name == "") {
                return DB::table('exam')
                    ->where('exam.status', EXAM_APPROVED_INTO_WEB)
                    ->where('exam.id_user_post', Auth::user()->id)
                    ->join('class_room', 'exam.id_class', 'class_room.id')
                    ->join('subject', 'exam.id_subject', 'subject.id')
                    ->join('level', 'exam.id_level', 'level.id')
                    ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                        'level.name as level_name')
                    ->orderBy('created_at', 'desc');
            } else {
                return DB::table('exam')
                    ->where('exam.status', EXAM_APPROVED_INTO_WEB)
                    ->where('exam.id_user_post', Auth::user()->id)
                    ->where('exam.name', 'like', "%$name%")
                    ->join('class_room', 'exam.id_class', 'class_room.id')
                    ->join('subject', 'exam.id_subject', 'subject.id')
                    ->join('level', 'exam.id_level', 'level.id')
                    ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                        'level.name as level_name')
                    ->orderBy('created_at', 'desc');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * get list exam approved into repository
     *
     * @param $name
     * @return \Exception
     */
    public function get_exam_in_repository($name)
    {
        try {
            if ($name == "") {
                return DB::table('exam')
                    ->where('exam.status', EXAM_APPROVED_INTO_EXAM_DIRECTORY)
                    ->where('exam.id_user_post', Auth::user()->id)
                    ->join('class_room', 'exam.id_class', 'class_room.id')
                    ->join('subject', 'exam.id_subject', 'subject.id')
                    ->join('level', 'exam.id_level', 'level.id')
                    ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                        'level.name as level_name')
                    ->orderBy('created_at', 'desc');
            } else {
                return DB::table('exam')
                    ->where('exam.status', EXAM_APPROVED_INTO_EXAM_DIRECTORY)
                    ->where('exam.id_user_post', Auth::user()->id)
                    ->where('exam.name', 'like', "%$name%")
                    ->join('class_room', 'exam.id_class', 'class_room.id')
                    ->join('subject', 'exam.id_subject', 'subject.id')
                    ->join('level', 'exam.id_level', 'level.id')
                    ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                        'level.name as level_name')
                    ->orderBy('created_at', 'desc');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * get list exam need modify
     *
     * @param $name
     * @return \Exception
     */
    public function get_list_exam_need_modify($name)
    {
        try {
            if ($name == "") {
                return DB::table('exam')
                    ->where('exam.status', EXAM_NEED_MODIFY)
                    ->where('exam.id_user_post', Auth::user()->id)
                    ->join('class_room', 'exam.id_class', 'class_room.id')
                    ->join('subject', 'exam.id_subject', 'subject.id')
                    ->join('level', 'exam.id_level', 'level.id')
                    ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                        'level.name as level_name')
                    ->orderBy('created_at', 'desc');
            } else {
                return DB::table('exam')
                    ->where('exam.status', EXAM_NEED_MODIFY)
                    ->where('exam.id_user_post', Auth::user()->id)
                    ->where('exam.name', 'like', "%$name%")
                    ->join('class_room', 'exam.id_class', 'class_room.id')
                    ->join('subject', 'exam.id_subject', 'subject.id')
                    ->join('level', 'exam.id_level', 'level.id')
                    ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                        'level.name as level_name')
                    ->orderBy('created_at', 'desc');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }


    /**
     * save answer for exam hasn't not answer
     *
     * @param $id_exam
     * @param $list_answer
     * @return \Exception
     */
    public function save_answer($id_exam, $list_answer)
    {
        try {
            return DB::table('exam')
                ->where('id', $id_exam)
                ->update([
                    'status' => EXAM_HAVE_ANSWER,
                    'list_answer' => $list_answer,
                    'updated_at' => date('Y-m-d : H:i:s')
                ]);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * send request for admin approve exam
     *
     * @param $id_exam
     * @return \Exception|int
     */
    public function send_approve_request($id_exam)
    {
        try {
            return DB::table('exam')
                ->where('id', $id_exam)
                ->update([
                    'status' => EXAM_WAITING_APPROVE,
                    'request_approve' => REQUEST_APPROVE,
                    'date_send_request_approve' => date('Y-m-d :H:i:s')
                ]);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * send requets for admin approve again
     * @param $id_exam
     * @return \Exception
     */
    public function send_approve_again($id_exam)
    {
        try {
            return DB::table('exam')
                ->where('id', $id_exam)
                ->update([
                    'status' => EXAM_WAITING_APPROVE,
                ]);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * delete one exam
     * @param $id_exam
     * @return \Exception
     */
    public function delete_exam($id_exam)
    {
        try {
            return DB::table('exam')
                ->where('id', $id_exam)
                ->delete();
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * cancel send request approve
     * @param $id_exam
     * @return \Exception
     */
    public function cancel_send_approve($id_exam)
    {
        try {
            return DB::table('exam')
                ->where('id', $id_exam)
                ->update([
                    'status' => EXAM_HAVE_ANSWER,
                    'request_approve' => REQUEST_APPROVE
                ]);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * get list of comment of a exam by id_exam
     *
     * @param $id_exam
     * @return \Exception
     */
    public function get_list_comment_of_exam($id_exam)
    {
        try {
            return DB::table('comment_for_exam')
                ->join('exam', 'comment_for_exam.id_exam', 'exam.id')
                ->where('comment_for_exam.id_exam', $id_exam)
                ->where('exam.id_user_post', Auth::user()->id)
                ->select('comment_for_exam.*')
                ->orderBy('status', 'ASC')
                ->orderBy('id', 'DESC');
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     *
     * get detail one comment of a exam
     * @param $id_comment
     * @return \Exception
     */
    public function get_detail_comment($id_comment)
    {
        try {
            DB::table('comment_for_exam')
                ->where('id', $id_comment)
                ->update([
                    'status' => 1,
                    'updated_at' => date('Y-m-d:H:i:s')
                ]);

            return DB::table('comment_for_exam')
                ->where('comment_for_exam.id', $id_comment)
                ->first();
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * update exam file
     *
     * @param $id_exam
     * @param $name_briefly
     * @return \Exception
     */
    public function update_exam_file($id_exam, $name_briefly)
    {
        try {
            return DB::table('exam')
                ->where('exam.id', $id_exam)
                ->update([
                    'name_briefly' => $name_briefly,
                    'updated_at' => date('Y-m-d:H:i:s')
                ]);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * update explain file
     *
     * @param $id_exam
     * @param $explain_file_name
     * @return \Exception
     */
    public function update_explain_file($id_exam, $explain_file_name)
    {
        try {
            return DB::table('exam')
                ->where('exam.id', $id_exam)
                ->update([
                    'explain_file_name' => $explain_file_name,
                    'updated_at' => date('Y-m-d:H:i:s')
                ]);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * update exam information
     *
     * @param $id_exam
     * @param $request
     * @return \Exception
     */
    public function update_exam_info($id_exam, $request)
    {
        try {
            return DB::table('exam')
                ->where('exam.id', $id_exam)
                ->update([
                    'name' => $request['exam_name'],
                    'id_class' => $request['class_room'],
                    'id_subject' => $request['subject'],
                    'id_level' => $request['level'],
                    'time' => $request['time'],
                    'updated_at' => date('Y-m-d:H:i:s')
                ]);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * update list answer of exam
     *
     * @param $id_exam
     * @param $list_answer
     * @return \Exception
     */
    public function update_list_answer($id_exam, $list_answer)
    {
        try {
            return DB::table('exam')
                ->where('exam.id', $id_exam)
                ->update([
                    'list_answer' => $list_answer,
                    'updated_at' => date('Y-m-d:H:i:s')
                ]);
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}