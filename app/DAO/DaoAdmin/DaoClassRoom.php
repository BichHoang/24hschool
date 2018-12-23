<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 6/13/2018
 * Time: 2:56 PM
 */

namespace App\DAO\DaoAdmin;


use Illuminate\Support\Facades\DB;

class DaoClassRoom
{
    /**
     * get list class room
     * @param $name : use for finding
     * @return \Exception
     */
    public function get_list_class_room($name)
    {
        try {
            if ($name == "") {
                return DB::table('class_room')
                    ->where('status', 1);
            } else {
                return DB::table('class_room')
                    ->where('status', 1)
                    ->where('name','like', "$name%");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}