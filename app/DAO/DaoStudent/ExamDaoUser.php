<?php
/**
 * Created by PhpStorm.
 * User: hoang bich
 * Date: 6/21/2018
 * Time: 7:19 PM
 */

namespace App\DAO\DaoStudent;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;


class ExamDaoUser
{
    /**
     * show all exam is free
     * @return mixed
     */
    public function get_list_exam_free()
    {
        return DB::table('exam')
            ->where('exam.status', '1')
            ->join('user', 'exam.id_lecturer', 'user.id')
            ->join('class_room', 'exam.id_class', 'class_room.id')
            ->join('subject', 'exam.id_subject', 'subject.id')
            ->join('level', 'exam.id_level', 'level.id')
            ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                'level.name as level_name', 'user.full_name as lecturer_name')
            ->orderBy('created_at', 'desc');
    }

    /**
     * get a exam for user do exam
     * @param $id_exam
     * @return \Exception
     */
    public function get_one_exam_free($id_exam)
    {
        try {
            return DB::table('exam')
                ->where('exam.id', $id_exam)
                ->where('exam.status', 1)
                ->join('user', 'exam.id_lecturer', 'user.id')
                ->join('class_room', 'exam.id_class', 'class_room.id')
                ->join('subject', 'exam.id_subject', 'subject.id')
                ->join('level', 'exam.id_level', 'level.id')
                ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                    'level.name as level_name', 'user.full_name as lecturer_name')
                ->first();
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * show all exam bought by coin
     * @return mixed
     */
    public function get_list_exam_coin()
    {
        return DB::table('exam')
            ->where('exam.status', '2')
            ->join('user', 'exam.id_lecturer', 'user.id')
            ->join('class_room', 'exam.id_class', 'class_room.id')
            ->join('subject', 'exam.id_subject', 'subject.id')
            ->join('level', 'exam.id_level', 'level.id')
            ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                'level.name as level_name', 'user.full_name as lecturer_name')
            ->orderBy('created_at', 'desc');
    }

    /**
     * get a exam for user do exam
     * @param $id_exam
     * @return \Exception
     */
    public function get_one_exam_coin($id_exam)
    {
        try {
            return DB::table('exam')
                ->where('exam.id', $id_exam)
                ->where('exam.status', 2)
                ->join('user', 'exam.id_lecturer', 'user.id')
                ->join('class_room', 'exam.id_class', 'class_room.id')
                ->join('subject', 'exam.id_subject', 'subject.id')
                ->join('level', 'exam.id_level', 'level.id')
                ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                    'level.name as level_name', 'user.full_name as lecturer_name')
                ->first();
        } catch (\Exception $ex) {
            return $ex;
        }
    }


    /**
     * get list of exam is done most
     * @return \Exception
     */
    public function get_list_most_exam()
    {
        try {
            return DB::table('exam')
                ->where('exam.status', 1)
                ->orWhere('exam.status', 2)
                ->orderBy('exam.joined', 'desc')
                ->limit(5)
                ->select('exam.name', 'exam.image', 'exam.joined', 'exam.id', 'exam.status')
                ->get();
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * get list newest exams
     * @return \Exception
     */
    public function get_list_new_exam()
    {
        try {
            return DB::table('exam')
                ->where('exam.status', 1)
                ->orWhere('exam.status', 2)
                ->orderBy('exam.created_at', 'desc')
                ->limit(5)
                ->select('exam.name', 'exam.image', 'exam.joined', 'exam.created_at', 'exam.id', 'exam.status')
                ->get();
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * increment joined of exam
     * @param $exam
     * @return \Exception
     */
    public function increment_joined($exam)
    {
        try {
            $joined = $exam->joined;
            if ($joined == null || $joined == "") {
                $joined = 0;
            }
            $joined++;
            return DB::table('exam')
                ->where('id', $exam->id)
                ->update([
                    'joined' => $joined
                ]);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * get one video by id_video
     * @param $id_video
     * @return \Exception
     */
    public function get_a_video($id_video)
    {
        try {
            return DB::table('oriented_video')
                ->where('id', $id_video)
                ->first();
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * get all exam by subject
     * @param $id_subject
     * @return \Exception
     */
    public function get_list_exam_by_subject($id_subject)
    {
        try {
            return DB::table('exam')
                ->where('exam.id_subject', $id_subject)
                ->where(function ($query) {
                    $query->where('exam.status', 1)
                        ->orWhere('exam.status', 2);
                })
                ->join('user', 'exam.id_lecturer', 'user.id')
                ->join('class_room', 'exam.id_class', 'class_room.id')
                ->join('subject', 'exam.id_subject', 'subject.id')
                ->join('level', 'exam.id_level', 'level.id')
                ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                    'level.name as level_name', 'user.full_name as lecturer_name')
                ->orderBy('created_at', 'desc');
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function get_list_exam_by_class($id_class)
    {
        try {
            return DB::table('exam')
                ->where('exam.id_class', $id_class)
                ->where(function ($query) {
                    $query->where('exam.status', 1)
                        ->orWhere('exam.status', 2);
                })
                ->join('user', 'exam.id_lecturer', 'user.id')
                ->join('class_room', 'exam.id_class', 'class_room.id')
                ->join('subject', 'exam.id_subject', 'subject.id')
                ->join('level', 'exam.id_level', 'level.id')
                ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                    'level.name as level_name', 'user.full_name as lecturer_name')
                ->orderBy('created_at', 'desc');
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function get_list_exam_for_search($search)
    {
        try {
            if ($search == "") {
                return DB::table('exam')
                    ->where(function ($query) {
                        $query->where('exam.status', 1)
                            ->orWhere('exam.status', 2);
                    })
                    ->join('user', 'exam.id_lecturer', 'user.id')
                    ->join('class_room', 'exam.id_class', 'class_room.id')
                    ->join('subject', 'exam.id_subject', 'subject.id')
                    ->join('level', 'exam.id_level', 'level.id')
                    ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                        'level.name as level_name', 'user.full_name as lecturer_name')
                    ->orderBy('exam.created_at', 'desc');
            } else {
                return DB::table('exam')
                    ->where(function ($query) {
                        $query->where('exam.status', 1)
                            ->orWhere('exam.status', 2);
                    })
                    ->where('exam.name', 'like', "%$search%")
                    ->join('user', 'exam.id_lecturer', 'user.id')
                    ->join('class_room', 'exam.id_class', 'class_room.id')
                    ->join('subject', 'exam.id_subject', 'subject.id')
                    ->join('level', 'exam.id_level', 'level.id')
                    ->select('exam.*', 'class_room.name as class_name', 'subject.name as subject_name',
                        'level.name as level_name', 'user.full_name as lecturer_name')
                    ->orderBy('exam.created_at', 'desc');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

}