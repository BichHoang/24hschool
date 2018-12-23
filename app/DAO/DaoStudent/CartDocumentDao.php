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

class CartDocumentDao
{
    public function get_cart_document()
    {
        try {
            return DB::table('cart_document')
                ->where('id_user', Auth::user()->id)
                ->join('study_document', 'cart_document.id_document', 'study_document.id')
                ->select('cart_document.*', 'study_document.name', 'study_document.price', 'study_document.sale',
                    'study_document.image', 'study_document.type_document')
                ->orderBy('cart_document.created_at', 'desc');
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * add document into your cart
     * @param $id_book
     * @param $request
     * @return \Exception
     */
    public function add_document($id_document)
    {
        try {
            return DB::table('cart_document')
                ->insert([
                    'id' => Uuid::uuid4(),
                    'id_user' => Auth::user()->id,
                    'id_document' => $id_document,
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
    public function delete_document($id_cart)
    {
        try {
            return DB::table('cart_document')
                ->where('id', $id_cart)
                ->delete();
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * xoa tat ca tai lieu trong gio
     * @return \Exception
     */
    public function delete_all_document(){
        try{
            return DB::table('cart_document')
                ->where('id_user', Auth::user()->id)
                ->delete();
        }catch (\Exception $ex){
            return $ex;
        }
    }
}