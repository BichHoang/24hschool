<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 7/20/2018
 * Time: 4:28 PM
 */

namespace App\DAO\DaoStudent;


use Illuminate\Support\Facades\DB;

class BookDao
{

    public function get_all_book()
    {
        try {
            return DB::table('book');
        } catch (\Exception $ex) {
            return $ex;
        }
    }

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

    /**
     * tim kiem sach
     * @param $keyword
     * @return \Exception
     */
    public function search_book($keyword)
    {
        try {
            if ($keyword == "") {
                return DB::table('book')
                    ->join('user', 'book.id_lecturer', 'user.id')
                    ->select('book.*', 'user.full_name')
                    ->orderBy('created_at', 'desc');
            } else {
                return DB::table('book')
                    ->join('user', 'book.id_lecturer', 'user.id')
                    ->where(function ($query) use ($keyword) {
                        $query->where('book.name', 'like', "%$keyword%")
                            ->orWhere('user.full_name', 'like', "%$keyword%");
                    })
                    ->select('book.*', 'user.full_name')
                    ->orderBy('created_at', 'desc');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}