<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 8/14/2018
 * Time: 12:00 PM
 */

namespace App\DAO\DaoStudent;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class RegisterBuyDocumentDao
{
    /**
     * dang ky mua tai lieu, whole
     * @param $request
     * @param $books
     * @param $total
     * @param $code
     * @param $is_ebook
     * @return \Exception|\Ramsey\Uuid\UuidInterface
     */
    public function buy_all_document_in_cart($request, $documents, $total, $code, $is_ebook){
        DB::beginTransaction();
        try{
            $type_payment = $request['payment'];
            $type_transaction = 2;
            $customer_name = $request['customer_name'];
            $phone = $request['phone'];
            $email = $request['email'];
            $address = $request['address'];
            $note = $request['note'];
            $id = Uuid::uuid4();
            //dang ky mua sach
            DB::table('transaction')
                ->insert([
                    'id' => $id,
                    'id_user'=> Auth::user()->id,
                    'type_payment' => $type_payment,
                    'phone' => $phone,
                    'email'=> $email,
                    'address'=> $address,
                    'customer_name' => $customer_name,
                    'note'=> $note,
                    'price' => $total,
                    'item' => $documents,
                    'created_at' => date('Y-m-d: H:i:s'),
                    'updated_at' => date('Y-m-d: H:i:s'),
                    'code' => $code,
                    'type_item' => $is_ebook,
                    'type_transaction' => $type_transaction
                ]);

            //xoa sach trong gio
            $rs = DB::table('cart_book')
                ->where('id_user', Auth::user()->id)
                ->delete();
            DB::commit();
            if($rs){
                return $id;
            }else{
                return $rs;
            }
        }catch (\Exception $ex){
            DB::rollback();
            return $ex;
        }
    }

    /**
     * dang ky mua tai lieu
     * @param $request
     * @param $books
     * @param $total
     * @param $code
     * @param $is_ebook
     * @return \Exception|\Ramsey\Uuid\UuidInterface
     */
    public function register_buy_document($request, $documents, $total, $code, $type_item){
        try{
            $type_payment = $request['payment'];
            $type_transaction = 2;
            $customer_name = $request['customer_name'];
            $phone = $request['phone'];
            $email = $request['email'];
            $address = $request['address'];
            $note = $request['note'];
            $id = Uuid::uuid4();
            //dang ky mua tai lieu
            $rs = DB::table('transaction')
                ->insert([
                    'id' => $id,
                    'id_user'=> Auth::user()->id,
                    'type_payment' => $type_payment,
                    'phone' => $phone,
                    'email'=> $email,
                    'address'=> $address,
                    'customer_name' => $customer_name,
                    'note'=> $note,
                    'price' => $total,
                    'item' => $documents,
                    'created_at' => date('Y-m-d: H:i:s'),
                    'updated_at' => date('Y-m-d: H:i:s'),
                    'code' => $code,
                    'type_item' => $type_item,
                    'type_transaction' => $type_transaction
                ]);
            if($rs){
                return $id;
            }else{
                return $rs;
            }
        }catch (\Exception $ex){
            return $ex;
        }
    }
}