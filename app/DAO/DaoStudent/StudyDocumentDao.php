<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 7/20/2018
 * Time: 4:31 PM
 */

namespace App\DAO\DaoStudent;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudyDocumentDao
{
    /**
     * get all study document for user
     * @return \Exception
     */
    public function all_study_document(){
        try{
            return DB::table('study_document')
                ->join('user', 'study_document.id_lecturer', 'user.id')
                ->select('study_document.*', 'user.full_name as author');
        }catch (\Exception $ex){
            return $ex;
        }
    }
    /**
     * lay thong tin mot tai lieu hoc tap
     * @param $document_name
     * @return \Exception
     */
    public function get_one_document($id_document){
        try{
            return DB::table('study_document')
                ->where('study_document.id', $id_document)
                ->join('user', 'study_document.id_lecturer', 'user.id')
                ->select('study_document.*', 'user.full_name as author')
                ->first();
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * tim kiem tai lieu hoc tap
     * @param $keyword
     * @return \Exception
     */
    public function search_document($keyword)
    {
        try {
            if ($keyword == "") {
                return DB::table('study_document')
                    ->join('user', 'study_document.id_lecturer', 'user.id')
                    ->select('study_document.*', 'user.full_name as author')
                    ->orderBy('created_at', 'desc');
            } else {
                return DB::table('study_document')
                    ->join('user', 'study_document.id_lecturer', 'user.id')
                    ->where(function ($query) use ($keyword) {
                        $query->where('study_document.name', 'like', "%$keyword%")
                            ->orWhere('user.full_name', 'like', "%$keyword%");
                    })
                    ->select('study_document.*', 'user.full_name as author')
                    ->orderBy('created_at', 'desc');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

}