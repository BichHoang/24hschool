<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 8/15/2018
 * Time: 12:11 AM
 */

namespace App\DAO\DaoAdmin;


use Illuminate\Support\Facades\DB;

class BookDao
{

    /**
     * lay thong tin cua mot cuon sach
     * @param $id_book
     * @return \Exception
     */
    public function get_one_book($id_book)
    {
        try {
            return DB::table('book')
                ->where('id', $id_book)
                ->first();
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}