<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 6/13/2018
 * Time: 4:39 PM
 */

namespace App\DAO\DaoAdmin;


use Illuminate\Support\Facades\DB;

class DaoSubject
{

    /**
     * get list subject
     * @param $name
     * @return \Exception
     */
    public function get_list_subject($name)
    {
        try {
            if ($name == "") {
                return DB::table('subject')
                    ->where('status', 1);
            } else {
                return DB::table('subject')
                    ->where('status', 1)
                    ->where('name', 'like', "$name%");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}