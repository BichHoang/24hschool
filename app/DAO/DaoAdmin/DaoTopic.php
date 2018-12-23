<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 6/13/2018
 * Time: 5:02 PM
 */

namespace App\DAO\DaoAdmin;


use Illuminate\Support\Facades\DB;

class DaoTopic
{
    public function list_topic($name){
        try{
            if($name == ""){
                return DB::table('topic')
                    ->where('status', 1);
            }else{
                return DB::table('topic')
                    ->where('status', 1)
                    ->where('name', 'like', "$name%");
            }
        }catch (\Exception $ex){
            return $ex;
        }
    }
}