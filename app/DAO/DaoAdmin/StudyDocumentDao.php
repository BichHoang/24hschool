<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 8/15/2018
 * Time: 12:11 AM
 */

namespace App\DAO\DaoAdmin;


use Illuminate\Support\Facades\DB;

class StudyDocumentDao
{

    /**
     * lay thong tin cua mot tai lieu
     * @param $id_document
     * @return \Exception
     */
    public function get_one_document($id_document)
    {
        try {
            return DB::table('study_document')
                ->where('id', $id_document)
                ->first();
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}