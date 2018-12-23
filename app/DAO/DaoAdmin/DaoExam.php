<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 6/14/2018
 * Time: 9:53 AM
 */

namespace App\DAO\DaoAdmin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DaoExam
{

    /**
     * get all exam approved with keyword
     *
     * @param $name
     * @return \Exception
     */
    public function list_exam_approved($name){
        try{
            if($name == ""){
                return DB::table('exam')
                    ->where('status', 1);
            }else{
                return DB::table('exam')
                    ->where('status',1)
                    ->where('name', "$name%");
            }
        }catch (\Exception $ex){
            return $ex;
        }
    }

}