<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 6/12/2018
 * Time: 4:59 PM
 */

namespace App\DAO\DaoAdmin;


use Illuminate\Support\Facades\DB;

class DaoUser
{
    /**
     * select student
     * @param $name : use for search
     * @return list student
     */
    public function list_student($name){
        try{
            if ($name == null || $name == "") {
                return DB::table('user')
                    ->where('status','10')
                    ->where('role',0);
            } else {
                return DB::table('user')
                    ->where('status','10')
                    ->where('role',0)
                    ->where(function ($query) use ($name) {
                        $query->where('email', 'like', "$name%")
                            ->orWhere('full_name', 'like', "$name%");
                    });
            }
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * select ctv
     * @param $name : use for search
     * @return list ctv
     */
    public function list_ctv($name){
        try{
            if ($name == null || $name == "") {
                return DB::table('user')
                    ->where('status','10')
                    ->where('role',4);
            } else {
                return DB::table('user')
                    ->where('status','10')
                    ->where('role',4)
                    ->where(function ($query) use ($name) {
                        $query->where('email', 'like', "$name%")
                            ->orWhere('full_name', 'like', "$name%");
                    });
            }
        }catch (\Exception $ex){
            return $ex;
        }
    }
}