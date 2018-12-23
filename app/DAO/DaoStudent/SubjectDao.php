<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 7/25/2018
 * Time: 10:52 AM
 */

namespace App\DAO\DaoStudent;

use Illuminate\Support\Facades\DB;

class SubjectDao
{
    /**
     * get subject with number exam of it
     * @return \Exception
     */
    public function get_subject_and_number_exam()
    {
        try {
            return DB::table('exam')
                ->rightJoin('subject', function ($query) {
                    $query->where(function ($query) {
                        $query->where('exam.status', 1)
                            ->orWhere('exam.status', 2);
                    })
                        ->on('subject.id', 'exam.id_subject');
                })
                ->groupBy('subject.id')
                ->distinct()
                ->select('subject.*', DB::raw('count(exam.id) as exam_count'))
                ->orderBy('subject.created_at', 'asc')
                ->get();
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}