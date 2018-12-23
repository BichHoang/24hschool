<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 8/9/2018
 * Time: 9:52 AM
 */

namespace App\DAO\DaoAdmin;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use App\Http\System\ConstSystem;

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
     * lay thong tin danh sach dang ky mua sach
     * @param $search
     * @return \Exception
     */
    public function get_list_register_buy_book($search)
    {
        try {
            if ($search == "") {
                return DB::table('transaction')
                    ->where('transaction.status', '<>', TRANSACTION_HIDE)
                    ->where('transaction.status', '<>', TRANSACTION_SUCCESS)
                    ->where('transaction.status', '<>', TRANSACTION_FAIL)
                    ->where('transaction.status', '<>', CUSTOMER_CANCEL_TRANSACTION)
                    ->where('transaction.type_transaction', 1)
                    ->join('user', 'transaction.id_user', 'user.id')
                    ->select('transaction.*', 'user.full_name as full_name')
                    ->orderBy('transaction.status', 'asc');
            } else {
                return DB::table('transaction')
                    ->where('transaction.status', '<>', TRANSACTION_HIDE)
                    ->where('transaction.status', '<>', TRANSACTION_SUCCESS)
                    ->where('transaction.status', '<>', TRANSACTION_FAIL)
                    ->where('transaction.status', '<>', CUSTOMER_CANCEL_TRANSACTION)
                    ->where('transaction.type_transaction', 1)
                    ->join('user', 'transaction.id_user', 'user.id')
                    ->where(function ($query) use ($search) {
                        $query->where('transaction.customer_name', 'like', "%$search%")
                            ->orWhere('transaction.phone', 'like', "%$search%")
                            ->orWhere('transaction.email', 'like', "%$search%")
                            ->orWhere('transaction.code', 'like', "%$search%");
                    })
                    ->select('transaction.*', 'user.full_name')
                    ->orderBy('transaction.status', 'asc');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * lay thong tin danh sach giao dich sach thanh cong
     * @param $search
     * @return \Exception
     */
    public function get_transaction_book_success($search)
    {
        try {
            if ($search == "") {
                return DB::table('transaction')
                    ->where('transaction.status', TRANSACTION_SUCCESS)
                    ->where('transaction.type_transaction', 1)
                    ->join('user', 'transaction.id_user', 'user.id')
                    ->select('transaction.*', 'user.full_name as full_name')
                    ->orderBy('transaction.status', 'asc');
            } else {
                return DB::table('transaction')
                    ->where('transaction.status', TRANSACTION_SUCCESS)
                    ->where('transaction.type_transaction', 1)
                    ->join('user', 'transaction.id_user', 'user.id')
                    ->where(function ($query) use ($search) {
                        $query->where('transaction.customer_name', 'like', "%$search%")
                            ->orWhere('transaction.phone', 'like', "%$search%")
                            ->orWhere('transaction.email', 'like', "%$search%")
                            ->orWhere('transaction.code', 'like', "%$search%");
                    })
                    ->select('transaction.*', 'user.full_name')
                    ->orderBy('transaction.status', 'asc');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * lay thong tin danh sach giao dich sach that bai
     * @param $search
     * @return \Exception
     */
    public function get_transaction_book_fail($search)
    {
        try {
            if ($search == "") {
                return DB::table('transaction')
                    ->where('transaction.status', TRANSACTION_FAIL)
                    ->where('transaction.type_transaction', 1)
                    ->join('user', 'transaction.id_user', 'user.id')
                    ->select('transaction.*', 'user.full_name as full_name')
                    ->orderBy('transaction.status', 'asc');
            } else {
                return DB::table('transaction')
                    ->where('transaction.status', TRANSACTION_FAIL)
                    ->where('transaction.type_transaction', 1)
                    ->join('user', 'transaction.id_user', 'user.id')
                    ->where(function ($query) use ($search) {
                        $query->where('transaction.customer_name', 'like', "%$search%")
                            ->orWhere('transaction.phone', 'like', "%$search%")
                            ->orWhere('transaction.email', 'like', "%$search%")
                            ->orWhere('transaction.code', 'like', "%$search%");
                    })
                    ->select('transaction.*', 'user.full_name')
                    ->orderBy('transaction.status', 'asc');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * lay thong tin danh sach giao dich sach bi nguoi dung huy
     * @param $search
     * @return \Exception
     */
    public function get_transaction_book_user_cancel($search)
    {
        try {
            if ($search == "") {
                return DB::table('transaction')
                    ->where('transaction.status', CUSTOMER_CANCEL_TRANSACTION)
                    ->where('transaction.type_transaction', 1)
                    ->join('user', 'transaction.id_user', 'user.id')
                    ->select('transaction.*', 'user.full_name as full_name')
                    ->orderBy('transaction.status', 'asc');
            } else {
                return DB::table('transaction')
                    ->where('transaction.status', CUSTOMER_CANCEL_TRANSACTION)
                    ->where('transaction.type_transaction', 1)
                    ->join('user', 'transaction.id_user', 'user.id')
                    ->where(function ($query) use ($search) {
                        $query->where('transaction.customer_name', 'like', "%$search%")
                            ->orWhere('transaction.phone', 'like', "%$search%")
                            ->orWhere('transaction.email', 'like', "%$search%")
                            ->orWhere('transaction.code', 'like', "%$search%");
                    })
                    ->select('transaction.*', 'user.full_name')
                    ->orderBy('transaction.status', 'asc');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * lay thong tin danh sach dang ky mua tai lieu
     * @return \Exception
     */
    public function get_register_buy_document($search)
    {
        try {
            if ($search == "") {
                return DB::table('transaction')
                    ->where('transaction.status', '<>', TRANSACTION_HIDE)
                    ->where('transaction.status', '<>', TRANSACTION_SUCCESS)
                    ->where('transaction.status', '<>', TRANSACTION_FAIL)
                    ->where('transaction.status', '<>', CUSTOMER_CANCEL_TRANSACTION)
                    ->where('transaction.type_transaction', 2)
                    ->join('user', 'transaction.id_user', 'user.id')
                    ->select('transaction.*', 'user.full_name as full_name')
                    ->orderBy('transaction.status', 'asc');
            } else {
                return DB::table('transaction')
                    ->where('transaction.status', '<>', TRANSACTION_HIDE)
                    ->where('transaction.status', '<>', TRANSACTION_SUCCESS)
                    ->where('transaction.status', '<>', TRANSACTION_FAIL)
                    ->where('transaction.status', '<>', CUSTOMER_CANCEL_TRANSACTION)
                    ->where('transaction.type_transaction', 2)
                    ->join('user', 'transaction.id_user', 'user.id')
                    ->where(function ($query) use ($search) {
                        $query->where('transaction.customer_name', 'like', "%$search%")
                            ->orWhere('transaction.phone', 'like', "%$search%")
                            ->orWhere('transaction.email', 'like', "%$search%")
                            ->orWhere('transaction.code', 'like', "%$search%");
                    })
                    ->select('transaction.*', 'user.full_name')
                    ->orderBy('transaction.status', 'asc');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * lay thong tin danh sach giao dich tai lieu thanh cong
     * @return \Exception
     */
    public function get_transaction_document_success($search)
    {
        try {
            if ($search == "") {
                return DB::table('transaction')
                    ->where('transaction.status', TRANSACTION_SUCCESS)
                    ->where('transaction.type_transaction', 2)
                    ->join('user', 'transaction.id_user', 'user.id')
                    ->select('transaction.*', 'user.full_name as full_name')
                    ->orderBy('transaction.status', 'asc');
            } else {
                return DB::table('transaction')
                    ->where('transaction.status', TRANSACTION_SUCCESS)
                    ->where('transaction.type_transaction', 2)
                    ->join('user', 'transaction.id_user', 'user.id')
                    ->where(function ($query) use ($search) {
                        $query->where('transaction.customer_name', 'like', "%$search%")
                            ->orWhere('transaction.phone', 'like', "%$search%")
                            ->orWhere('transaction.email', 'like', "%$search%")
                            ->orWhere('transaction.code', 'like', "%$search%");
                    })
                    ->select('transaction.*', 'user.full_name')
                    ->orderBy('transaction.status', 'asc');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * lay thong tin danh sach giao dich tai lieu that bai
     * @return \Exception
     */
    public function get_transaction_document_fail($search)
    {
        try {
            if ($search == "") {
                return DB::table('transaction')
                    ->where('transaction.status', TRANSACTION_FAIL)
                    ->where('transaction.type_transaction', 2)
                    ->join('user', 'transaction.id_user', 'user.id')
                    ->select('transaction.*', 'user.full_name as full_name')
                    ->orderBy('transaction.status', 'asc');
            } else {
                return DB::table('transaction')
                    ->where('transaction.status', TRANSACTION_FAIL)
                    ->where('transaction.type_transaction', 2)
                    ->join('user', 'transaction.id_user', 'user.id')
                    ->where(function ($query) use ($search) {
                        $query->where('transaction.customer_name', 'like', "%$search%")
                            ->orWhere('transaction.phone', 'like', "%$search%")
                            ->orWhere('transaction.email', 'like', "%$search%")
                            ->orWhere('transaction.code', 'like', "%$search%");
                    })
                    ->select('transaction.*', 'user.full_name')
                    ->orderBy('transaction.status', 'asc');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * lay thong tin danh sach giao dich tai lieu bi nguoi dung huy
     * @return \Exception
     */
    public function get_transaction_document_user_cancel($search)
    {
        try {
            if ($search == "") {
                return DB::table('transaction')
                    ->where('transaction.status', CUSTOMER_CANCEL_TRANSACTION)
                    ->where('transaction.type_transaction', 2)
                    ->join('user', 'transaction.id_user', 'user.id')
                    ->select('transaction.*', 'user.full_name as full_name')
                    ->orderBy('transaction.status', 'asc');
            } else {
                return DB::table('transaction')
                    ->where('transaction.status', CUSTOMER_CANCEL_TRANSACTION)
                    ->where('transaction.type_transaction', 2)
                    ->join('user', 'transaction.id_user', 'user.id')
                    ->where(function ($query) use ($search) {
                        $query->where('transaction.customer_name', 'like', "%$search%")
                            ->orWhere('transaction.phone', 'like', "%$search%")
                            ->orWhere('transaction.email', 'like', "%$search%")
                            ->orWhere('transaction.code', 'like', "%$search%");
                    })
                    ->select('transaction.*', 'user.full_name')
                    ->orderBy('transaction.status', 'asc');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * lay ra thong tin chi tiet cua mot giao dich
     * @param $id_transaction
     * @return \Exception
     */
    public function get_detail_transaction($id_transaction)
    {
        try {
            return DB::table('transaction')
                ->where('transaction.id', $id_transaction)
                ->first();
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * received transaction
     * @param $id_transaction
     * @return \Exception
     */
    public function confirm_transaction_received($id_transaction)
    {
        try {
            return DB::table('transaction')
                ->where('id', $id_transaction)
                ->update([
                    'status' => constant('TRANSACTION_HANDING'),
                    'id_user_confirmed' => Auth::user()->id,
                    'updated_at' => date('Y-m-d :H:i:s')
                ]);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * bao khong nhan giao dich cung voi nguyen nhan khong nhan giao dich
     * @param $id_transaction
     * @param $reason_cancel
     * @return bool|\Exception
     */
    public function deny_receive_transaction($id_transaction, $reason_deny)
    {
        DB::beginTransaction();
        try {
            //bao hong
            DB::table('transaction')
                ->where('id', $id_transaction)
                ->update([
                    'status' => TRANSACTION_FAIL,
                    'updated_at' => date('Y-m-d :H:i:s')
                ]);
            //ly do hong
            $reason_deny = "Không nhận giao dịch này do: ". $reason_deny;
            $rs = DB::table('reason_cancel_transaction')
                ->insert([
                    'id' => Uuid::uuid4(),
                    'type_reason_cancel' => REASON_DENY_RECEIVE_TRANSACTION,
                    'id_transaction' => $id_transaction,
                    'id_user_cancel' => Auth::user()->id,
                    'reason_cancel' => $reason_deny,
                    'created_at' => date('y-m-d :H:i:s'),
                    'updated_at' => date('y-m-d :H:i:s')
                ]);
            DB::commit();
            return $rs;
        } catch (\Exception $ex) {
            DB::rollback();
            return $ex;
        }
    }

    /**
     *xac nhan giao dich thanh cong
     * @param $id_transaction
     * @return \Exception
     */
    public function confirm_transaction_success($id_transaction)
    {
        try {
            return DB::table('transaction')
                ->where('id', $id_transaction)
                ->update([
                    'status' => TRANSACTION_SUCCESS,
                    'updated_at' => date('Y-m-d :H:i:s')
                ]);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * thong bao giao dich that bai cung voi nguyen nhan that bai
     * @param $id_transaction
     * @param $reason_transaction_fail
     * @return bool|\Exception
     */
    public function notify_transaction_fail($id_transaction, $reason_transaction_fail){
        DB::beginTransaction();
        try{
            //bao giao dich that bai
            DB::table('transaction')
                ->where('id', $id_transaction)
                ->update([
                    'status' => TRANSACTION_FAIL,
                    'updated_at' => date('Y-m-d :H:i:s')
                ]);
            //ly do hong
            $reason_transaction_fail = "Giao dịch thất bại do: ". $reason_transaction_fail;
            $rs = DB::table('reason_cancel_transaction')
                ->insert([
                    'id' => Uuid::uuid4(),
                    'type_reason_cancel' => REASON_TRANSACTION_FAIL,
                    'id_transaction' => $id_transaction,
                    'id_user_cancel' => Auth::user()->id,
                    'reason_cancel' => $reason_transaction_fail,
                    'created_at' => date('y-m-d :H:i:s'),
                    'updated_at' => date('y-m-d :H:i:s')
                ]);
            DB::commit();
            return $rs;
        } catch (\Exception $ex) {
            DB::rollback();
            return $ex;
        }
    }
}