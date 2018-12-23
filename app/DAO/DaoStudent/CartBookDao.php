<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 8/4/2018
 * Time: 5:26 PM
 */

namespace App\DAO\DaoStudent;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class CartBookDao
{
    public function get_cart_book()
    {
        try {
            return DB::table('cart_book')
                ->where('id_user', Auth::user()->id)
                ->join('book', 'cart_book.id_book', 'book.id')
                ->select('cart_book.*', 'book.name', 'book.price', 'book.sale',
                    'book.previous_image', 'book.rear_image', 'book.type_book')
                ->orderBy('cart_book.created_at', 'desc');
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * add book into your cart
     * @param $id_book
     * @param $request
     * @return \Exception
     */
    public function add_book($id_book, $request)
    {
        try {
            return DB::table('cart_book')
                ->insert([
                    'id' => Uuid::uuid4(),
                    'number' => $request['qty'],
                    'id_user' => Auth::user()->id,
                    'id_book' => $id_book,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * delete in your cart
     * @param $id_book
     * @return \Exception
     */
    public function delete_book($id_cart)
    {
        try {
            return DB::table('cart_book')
                ->where('id', $id_cart)
                ->delete();
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function delete_all_book(){
        try{
            return DB::table('cart_book')
                ->where('id_user', Auth::user()->id)
                ->delete();
        }catch (\Exception $ex){
            return $ex;
        }
    }
}