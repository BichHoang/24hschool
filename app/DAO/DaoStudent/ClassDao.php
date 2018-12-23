<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 8/2/2018
 * Time: 10:09 AM
 */

namespace App\DAO\DaoStudent;


use Illuminate\Support\Facades\DB;

class ClassDao
{
    public function get_class_and_number_exam()
    {
        try {
            return DB::table('exam')
                ->rightJoin('class_room', function ($query) {
                    $query->where(function ($query) {
                        $query->where('exam.status', 1)
                            ->orWhere('exam.status', 2);
                    })
                        ->on('class_room.id', 'exam.id_class');
                })
                ->groupBy('class_room.id')
                ->distinct()
                ->select('class_room.*', DB::raw('count(exam.id) as exam_count'))
                ->orderBy('class_room.created_at', 'asc')
                ->get();

        } catch (\Exception $ex) {
            return $ex;
        }
    }
}