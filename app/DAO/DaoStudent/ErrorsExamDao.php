<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 7/13/2018
 * Time: 4:05 PM
 */

namespace App\DAO\DaoStudent;


use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class ErrorsExamDao
{
    /**
     * save errors of exam sent from the student
     * @param $errors
     * @param $id_exam
     * @param $id_user
     * @return \Exception
     */
    public function save_errors($errors, $id_exam, $id_user){
        try{
            return DB::table('errors_in_exam')->insert([
                'id' => Uuid::uuid4(),
                'id_user' => $id_user,
                'id_exam' => $id_exam,
                'errors' => $errors,
                'created_at' => date('Y-m-d :H:i:s'),
                'updated_at' => date('Y-m-d :H:i:s'),
            ]);
        }catch (\Exception $ex){
            return $ex;
        }
    }

}