<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 8/8/2018
 * Time: 4:48 PM
 */

namespace App\DAO\DaoStudent;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//transaction
define('ADMIN_NOT_SEEN', 0);
define('TRANSACTION_NOT_HANDING', 1);
define('TRANSACTION_HIDE', 2);
define('CUSTOMER_CANCEL_TRANSACTION', 3);
define('TRANSACTION_HANDING', 5);
define('TRANSACTION_SUCCESS', 9);
define('TRANSACTION_FAIL', 10);

define('REASON_DENY_RECEIVE_TRANSACTION', 1);
define('REASON_TRANSACTION_FAIL', 2);

class TransactionDao
{
    /**
     * lay danh sach giao dich sach da thanh cong
     * @return \Exception
     */
    public function get_list_transaction_book_success(){
        try{
            return DB::table('transaction')
                ->where('id_user', Auth::user()->id)
                ->where('type_transaction', 1)
                ->where('status', TRANSACTION_SUCCESS)
                ->orderBy('created_at', 'desc')
                ->get();
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * lay danh sach giao dich tai lieu da thanh cong
     * @return \Exception
     */
    public function get_list_transaction_document_success(){
        try{
            return DB::table('transaction')
                ->where('id_user', Auth::user()->id)
                ->where('type_transaction', 2)
                ->where('status', TRANSACTION_SUCCESS)
                ->orderBy('created_at', 'desc')
                ->get();
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * lay danh sach giao dich cua nguoi dung
     * @return \Exception
     */
    public function get_list_transaction(){
        try{
            return DB::table('transaction')
                ->where('id_user', Auth::user()->id)
                ->where('status', '<>', TRANSACTION_HIDE)
                ->where('status', '<>', CUSTOMER_CANCEL_TRANSACTION)
                ->orderBy('created_at', 'desc');
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * lay thong tin chi tiet cua mot transaction
     * @param $id_transaction
     * @return \Exception
     */
    public function get_detail_transaction($id_transaction){
        try{
            return DB::table('transaction')
                ->where('transaction.id', $id_transaction)
                ->where('status', '<>', TRANSACTION_HIDE)
                ->where('status', '<>', CUSTOMER_CANCEL_TRANSACTION)
                ->first();
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * an giao dich voi nguoi dung
     * @param $id_register
     * @return \Exception
     */
    public function hide_transaction_with_user($id_register){
        try{
            return DB::table('transaction')
                ->where('id', $id_register)
                ->update([
                    'status' => TRANSACTION_HIDE,
                    'updated_at' => date('Y-m-d :H:i:s')
                ]);
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * huy giao dich khi no chua duoc xu ly
     * @param $id_register
     * @return \Exception
     */
    public function cancel_transaction($id_register){
        try{
            return DB::table('transaction')
                ->where('id', $id_register)
                ->update([
                    'status' => CUSTOMER_CANCEL_TRANSACTION,
                    'updated_at' => date('Y-m-d:H:i:s')
                ]);
        }catch (\Exception $ex){
            return $ex;
        }
    }
}