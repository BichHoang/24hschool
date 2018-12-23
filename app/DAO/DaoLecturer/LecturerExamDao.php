<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 6/20/2018
 * Time: 3:14 PM
 */

namespace App\DAO\DaoLecturer;


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


class LecturerExamDao
{

    /**
     * get id of lecturer have ctv with id = id_ctv
     *
     * @param $id_ctv
     * @return \Exception
     */
    public function get_id_lecturer_of_ctv($id_ctv)
    {
        try {
            $ctv = DB::table('user')
                ->where('id', $id_ctv)
                ->select('user.id_lecturer')
                ->first();
            return $ctv;
        } catch (\Exception $ex) {
            return $ex;
        }
    }

//------------------------------------- create exam --------------------------------------------------------------

    /**
     * save file exam and file explain
     *
     * @param $request
     * @param $exam_briefly
     * @param $explain_file_name
     * @return \Exception
     */
    public function upload_exam_and_explain($request, $exam_briefly, $explain_file_name, $image_name)
    {
        try {
            $slug = Convert::to_slug($request['exam_name']);
            $id = Uuid::uuid4();
            $rs = DB::table('exam')->insert([
                'id' => $id,
                'status' => EXAM_NOT_ANSWER,
                'name' => $request['exam_name'],
                'name_briefly' => $exam_briefly,
                'explain_file_name' => $explain_file_name,
                'image' => $image_name,
                'id_class' => $request['class_room'],
                'id_subject' => $request['subject'],
                'number_of_questions' => $request['number_question'],
                'id_level' => $request['level'],
                'id_user_post' => Auth::user()->id,
                'id_lecturer' => Auth::user()->id,
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
    public function update_exam_info($id_exam, $request, $image)
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
                    'image' => $image,
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
//---------------------------------------------  My Exam ---------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------
    /**
     * get one exam for modification
     * @param $id_exam
     * @return \Exception
     */
    public function get_one_exam_for_modification($id_exam)
    {
        try {
            return DB::table('exam')
                ->where('exam.id', $id_exam)
                ->join('user', 'exam.id_user_post', 'user.id')
                ->where('user.id', Auth::user()->id)
                ->where('request_approve', '<>', REQUEST_END)
                ->select('exam.*')
                ->first();
        } catch (\Exception $ex) {
            return $ex;
        }
    }


    /**
     * get my a exam file was created by this lecturer
     *
     * @param $id_exam
     * @return \Exception
     */
    public function get_a_my_exam_file($id_exam)
    {
        try {
            return DB::table('exam')
                ->where('exam.id', $id_exam)
                ->join('user', 'exam.id_user_post', 'user.id')
                ->where('user.id', Auth::user()->id)
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
     * get list exam file haven't been answer with keyword
     *
     * @param $name
     * @return \Exception
     */
    public function get_my_exam_not_answer($name)
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
     * get list exam file have been answer with keyword
     *
     * @param $name
     * @return \Exception
     */
    public function get_my_exam_have_answer($name)
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
     * get my exam on web by keyword
     *
     * @param $name
     * @return \Exception
     */
    public function get_my_exam_on_web($name)
    {
        try {
            if ($name == "") {
                return DB::table('exam')
                    ->where('exam.status', EXAM_APPROVED_INTO_WEB)
                    ->where('exam.id_user_post', Auth::user()->id)
                    ->join('class_room', 'exam.id_class', 'class_room.id')
                    ->join('subject', 'exam.id_subject', 'subject.id')
                    ->join('level', 'exam.id_level', 'level.id')
                    ->select('exam.*', 'class_room.name as class_name',
                        'subject.name as subject_name',
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
                    ->select('exam.*', 'class_room.name as class_name',
                        'subject.name as subject_name',
                        'level.name as level_name')
                    ->orderBy('created_at', 'desc');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * get my exam in repository
     * @param $name
     * @return \Exception
     */
    public function get_my_exam_in_repository($name)
    {
        try {
            if ($name == "") {
                return DB::table('exam')
                    ->where('exam.status', EXAM_APPROVED_INTO_EXAM_DIRECTORY)
                    ->where('exam.id_user_post', Auth::user()->id)
                    ->join('class_room', 'exam.id_class', 'class_room.id')
                    ->join('subject', 'exam.id_subject', 'subject.id')
                    ->join('level', 'exam.id_level', 'level.id')
                    ->select('exam.*', 'class_room.name as class_name',
                        'subject.name as subject_name',
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
                    ->select('exam.*', 'class_room.name as class_name',
                        'subject.name as subject_name',
                        'level.name as level_name')
                    ->orderBy('created_at', 'desc');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

//-------------    get exam of all this lecturer's ctv for display -----------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------
    /**
     * get exams are waiting approve
     *
     * @param $name
     * @return \Exception
     */
    public function exam_waiting_approve($name)
    {
        try {
            if ($name == "") {
                return DB::table('exam')
                    ->where('exam.status', EXAM_WAITING_APPROVE)
                    ->where('exam.request_approve', REQUEST_APPROVE)
                    ->join('user', 'exam.id_user_post', 'user.id')
                    ->where('user.id_lecturer', Auth::user()->id)
                    ->join('class_room', 'exam.id_class', 'class_room.id')
                    ->join('subject', 'exam.id_subject', 'subject.id')
                    ->join('level', 'exam.id_level', 'level.id')
                    ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                        'level.name as level_name', 'user.full_name as user_name')
                    ->orderBy('created_at', 'desc');
            } else {
                return DB::table('exam')
                    ->where('exam.status', EXAM_WAITING_APPROVE)
                    ->where('exam.request_approve', REQUEST_APPROVE)
                    ->where('exam.name', 'like', "%$name%")
                    ->join('user', 'exam.id_user_post', 'user.id')
                    ->where('user.id_lecturer', Auth::user()->id)
                    ->join('class_room', 'exam.id_class', 'class_room.id')
                    ->join('subject', 'exam.id_subject', 'subject.id')
                    ->join('level', 'exam.id_level', 'level.id')
                    ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                         'level.name as level_name', 'user.full_name as user_name')
                    ->orderBy('created_at', 'desc');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * get exams have been approved to web of all this lecturer's ctv
     *
     * @param $name
     * @return \Exception
     */
    public function exam_approved_to_web($name)
    {
        try {
            if ($name == "") {
                return DB::table('exam')
                    ->where('exam.status', EXAM_APPROVED_INTO_WEB)
                    ->where('exam.request_approve', REQUEST_END)
                    ->join('user', 'exam.id_user_post', 'user.id')
                    ->where('user.id_lecturer', Auth::user()->id)
                    ->join('class_room', 'exam.id_class', 'class_room.id')
                    ->join('subject', 'exam.id_subject', 'subject.id')
                    ->join('level', 'exam.id_level', 'level.id')
                    ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                         'level.name as level_name')
                    ->orderBy('date_approved', 'desc');
            } else {
                return DB::table('exam')
                    ->where('exam.status', EXAM_APPROVED_INTO_WEB)
                    ->where('exam.request_approve', REQUEST_END)
                    ->where('exam.name', 'like', "%$name%")
                    ->join('user', 'exam.id_user_post', 'user.id')
                    ->where('user.id_lecturer', Auth::user()->id)
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
     * get exams have been approved into repository of all this lecturer's ctv
     *
     * @param $name
     * @return \Exception
     */
    public function exam_approved_to_repository($name)
    {
        try {
            if ($name == "") {
                return DB::table('exam')
                    ->where('exam.status', EXAM_APPROVED_INTO_EXAM_DIRECTORY)
                    ->where('exam.request_approve', REQUEST_END)
                    ->join('user', 'exam.id_user_post', 'user.id')
                    ->where('user.id_lecturer', Auth::user()->id)
                    ->join('class_room', 'exam.id_class', 'class_room.id')
                    ->join('subject', 'exam.id_subject', 'subject.id')
                    ->join('level', 'exam.id_level', 'level.id')
                    ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                         'level.name as level_name')
                    ->orderBy('date_approved', 'desc');
            } else {
                return DB::table('exam')
                    ->where('exam.status', EXAM_APPROVED_INTO_EXAM_DIRECTORY)
                    ->where('exam.request_approve', REQUEST_END)
                    ->where('exam.name', 'like', "%$name%")
                    ->join('user', 'exam.id_user_post', 'user.id')
                    ->where('user.id_lecturer', Auth::user()->id)
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
     * get exams need modify of all this lecturer's ctv
     *
     * @param $name
     * @return \Exception
     */
    public function exam_need_modify($name)
    {
        try {
            if ($name == "") {
                return DB::table('exam')
                    ->where('exam.status', EXAM_NEED_MODIFY)
                    ->join('user', 'exam.id_user_post', 'user.id')
                    ->where('user.id_lecturer', Auth::user()->id)
                    ->join('class_room', 'exam.id_class', 'class_room.id')
                    ->join('subject', 'exam.id_subject', 'subject.id')
                    ->join('level', 'exam.id_level', 'level.id')
                    ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                         'level.name as level_name', 'user.full_name as name_user')
                    ->orderBy('created_at', 'desc');
            } else {
                return DB::table('exam')
                    ->where('exam.status', EXAM_NEED_MODIFY)
                    ->where('exam.name', 'like', "%$name%")
                    ->join('user', 'exam.id_user_post', 'user.id')
                    ->where('user.id_lecturer', Auth::user()->id)
                    ->join('class_room', 'exam.id_class', 'class_room.id')
                    ->join('subject', 'exam.id_subject', 'subject.id')
                    ->join('level', 'exam.id_level', 'level.id')
                    ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                        'level.name as level_name', 'user.full_name as name_user')
                    ->orderBy('created_at', 'desc');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }


    /**
     * get information of a exam file with id_exam for something
     *
     * @param $id_exam
     * @return \Exception
     */
    public function get_a_exam_file($id_exam)
    {
        try {
            return DB::table('exam')
                ->where('exam.id', $id_exam)
                ->join('user', 'exam.id_user_post', 'user.id')
                ->where('user.id_lecturer', Auth::user()->id)
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
     * save exam approved into web
     *
     * @param $id_exam
     * @return \Exception
     */
    public function save_exam_to_web($id_exam)
    {
        try {
            return DB::table('exam')
                ->where('id', $id_exam)
                ->update([
                    'status' => EXAM_APPROVED_INTO_WEB,
                    'request_approve' => REQUEST_END,
                    'date_approved' => date('Y-m-d :H:i:s')
                ]);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * save exam approved into repository
     *
     * @param $id_exam
     * @return \Exception
     */
    public function save_exam_to_repository($id_exam)
    {
        try {
            return DB::table('exam')
                ->where('id', $id_exam)
                ->update([
                    'status' => EXAM_APPROVED_INTO_EXAM_DIRECTORY,
                    'request_approve' => REQUEST_END,
                    'date_approved' => date('Y-m-d :H:i:s')
                ]);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * create comment for exam of ctv
     *
     * @param $id_exam
     * @param $comment
     * @return \Exception
     */
    public function save_comment_for_exam($id_exam, $comment)
    {
        try {
            return DB::table('comment_for_exam')->insert([
                'id' => Uuid::uuid4(),
                'id_lecturer' => Auth::user()->id,
                'id_exam' => $id_exam,
                'comment' => $comment,
                'created_at' => date('Y-m-d :H:i:s'),
                'updated_at' => date('Y-m-d :H:i:s')
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
                ->where('id_exam', $id_exam)
                ->where('id_lecturer', Auth::user()->id);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * get a comment of a exam for display detail
     *
     * @param $id_comment
     * @return \Exception
     */
    public function get_a_comment($id_comment)
    {
        try {
            return DB::table('comment_for_exam')
                ->where('id', $id_comment)
                ->where('id_lecturer', Auth::user()->id)
                ->first();
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * update comment of exam by id_comment
     *
     * @param $id_comment
     * @param $comment_new
     * @return \Exception
     */
    public function update_comment($id_comment, $comment_new)
    {
        try {
            return DB::table('comment_for_exam')
                ->where('id', $id_comment)
                ->update([
                    'status' => 0,
                    'comment' => $comment_new,
                    'updated_at' => date('Y-m-d :H:i:s')
                ]);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * change exam is waiting approve to exam need modify
     *
     * @param $id_exam
     * @return \Exception
     */
    public function save_exam_need_modify($id_exam)
    {
        try {
            return DB::table('exam')
                ->where('id', $id_exam)
                ->update([
                    'status' => EXAM_NEED_MODIFY
                ]);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * get list of exam of ctv by id_ctv
     *
     * @param $id_ctv
     * @return \Exception
     */
    public function get_list_exam_of_ctv($id_ctv)
    {
        try {
            return DB::table('exam')
                ->where('exam.request_approve', REQUEST_END)
                ->join('user', 'exam.id_user_post', 'user.id')
                ->where('user.id', $id_ctv)
                ->where('user.id_lecturer', Auth::user()->id)
                ->join('class_room', 'exam.id_class', 'class_room.id')
                ->join('subject', 'exam.id_subject', 'subject.id')
                ->join('level', 'exam.id_level', 'level.id')
                ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                    'level.name as level_name')
                ->orderBy('created_at', 'desc');
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
}