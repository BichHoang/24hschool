<?php

namespace App\Http\Controllers\Admin;

use App\DAO\DaoAdmin\StudyDocumentDao;
use App\DAO\DaoAdmin\TransactionDao;
use App\DAO\DaoAdmin\BookDao;
use App\Http\System\SystemStringParameter;
use App\Jobs\SendNotifyEmail;
use App\Mail\NotifyOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
    protected $db_transaction;
    protected $db_book;
    protected $db_document;

    public function __construct()
    {
        $this->db_transaction = new TransactionDao();
        $this->db_book = new BookDao();
        $this->db_document = new StudyDocumentDao();
    }


//-------------------------------------------- giao dich sach --------------------------------------------------
    /**
     * hien thi danh sach giao dich sach da ket thuc
     * @param $search
     * @return \Exception
     */
    public function get_list_transaction_book_success($search)
    {
        try {
            $page = Input::get('page');
            if ($page < 1) {
                $page = 1;
            }
            $start = ($page - 1) * SystemStringParameter::PER_PAGE_BOOK();
            $search = trim($search, " ");
            $data = $this->db_transaction->get_all_transaction($search);
            $count = count($data->get());
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_BOOK());
            return view('admin.transaction.book.')
                ->with('start', $start)
                ->with('count', $count)
                ->with('data', $data_send)
                ->with('search_old', $search);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * tim kiem giao dich
     * @param Request $request
     * @param $search
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_list_transaction_book_success(Request $request, $search)
    {
        try {
            $search = trim($request['txt_search'], " ");
            if ($search == "") {
                return redirect('admin/transaction/all-%20')
                    ->with('message_notification', "Bạn vừa nhập vào một khoảng trắng");
            } else {
                return redirect('admin/transaction/all-' . $search)
                    ->with('message_success', "Tìm kiếm thành công");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * hien thi danh sach nguoi dung dang ky mua sach
     * @param $search
     * @return \Exception
     */
    public function get_list_user_register_buy_book($search)
    {
        try {
            $page = Input::get('page');
            if ($page < 1) {
                $page = 1;
            }
            $start = ($page - 1) * SystemStringParameter::PER_PAGE_BOOK();
            $search = trim($search, " ");
            $data = $this->db_transaction->get_list_register_buy_book($search);
            $count = count($data->get());
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_BOOK());
            return view('admin.transaction.book.register_buy_book')
                ->with('start', $start)
                ->with('count', $count)
                ->with('data', $data_send)
                ->with('search_old', $search);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * tim kiem giao dich lien quan den sach
     * @param Request $request
     * @param $search
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_list_user_register_buy_book(Request $request, $search)
    {
        try {
            $search = trim($request['txt_search'], " ");
            if ($search == "") {
                return redirect('admin/transaction/book/list_register-%20')
                    ->with('message_notification', "Bạn vừa nhập vào một khoảng trắng");
            } else {
                return redirect('admin/transaction/book/list_register-' . $search)
                    ->with('message_success', "Tìm kiếm thành công");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * xem chi tiet giao dich sach
     * @param $id_transaction
     * @return $this|\Exception
     */
    public function get_detail_transaction_book($id_transaction)
    {
        try {
            $data = $this->db_transaction->get_detail_transaction($id_transaction);
            $book = null;
            $data->book = json_decode($data->item);
            foreach ($data->book as $item) {
                $value = $this->db_book->get_one_book($item->id_book);
                $value->number = $item->number;
                $value->price_sale = $item->price_sale;
                $book[] = $value;
            }
            return view('admin.transaction.book.detail')
                ->with('data', $data)
                ->with('book', $book);

        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * hien thi danh sach nguoi dung dang ky mua tai lieu
     * @param $search
     * @return \Exception
     */
    public function get_list_user_register_buy_document($search)
    {
        try {
            $page = Input::get('page');
            if ($page < 1) {
                $page = 1;
            }
            $start = ($page - 1) * SystemStringParameter::PER_PAGE_DOCUMENT();
            $search = trim($search, " ");
            $data = $this->db_transaction->get_register_buy_document($search);
            $count = count($data->get());
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_DOCUMENT());
            return view('admin.transaction.document.register_buy_document')
                ->with('start', $start)
                ->with('count', $count)
                ->with('data', $data_send)
                ->with('search_old', $search);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * tim kiem giao dich lien quan den tai lieu
     * @param Request $request
     * @param $search
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_list_user_register_buy_document(Request $request, $search)
    {
        try {
            $search = trim($request['txt_search'], " ");
            if ($search == "") {
                return redirect('admin/transaction/document/list_register-%20')
                    ->with('message_notification', "Bạn vừa nhập vào một khoảng trắng");
            } else {
                return redirect('admin/transaction/document/list_register-' . $search)
                    ->with('message_success', "Tìm kiếm thành công");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * xem chi tiet giao dich tai lieu
     * @param $id_transaction
     * @return $this|\Exception
     */
    public function get_detail_transaction_document($id_transaction)
    {
        try {
            $data = $this->db_transaction->get_detail_transaction($id_transaction);
            $document = null;
            $data->document = json_decode($data->item);
            foreach ($data->document as $item) {
                $value = $this->db_document->get_one_document($item->id_document);
                $value->number = $item->number;
                $value->price_sale = $item->price_sale;
                $document[] = $value;
            }
            return view('admin.transaction.document.detail')
                ->with('data', $data)
                ->with('document', $document);

        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * nhan giao dich
     * @param $id_transaction
     * @param Request $request
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function confirm_received_transaction($id_transaction)
    {
        try {
            $rs_confirm = $this->db_transaction->confirm_transaction_received($id_transaction);
            $transaction = $this->db_transaction->get_detail_transaction($id_transaction);
            if (is_numeric($rs_confirm) && $rs_confirm >= 0) {
                //thong bao cho nguoi dung ve don hang
                $view_email = "user.transaction.email_notify.order_transported";
                $this->dispatch(new SendNotifyEmail($transaction->email, $view_email, $transaction));
                return redirect()->back()->with('message_success', "Nhận giao dịch thành công");
            }
            return redirect()->back()->with('message_notification', "Nhận giao dịch thất bại");
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * tu choi nhan giao dich
     * @param $id_transaction
     * @param Request $request
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_notify_deny_receive_transaction($id_transaction, Request $request)
    {
        try {
            $reason_deny_receive = trim($request['reason'], " ");
            $rs = $this->db_transaction->deny_receive_transaction($id_transaction, $reason_deny_receive);
            $transaction = $this->db_transaction->get_detail_transaction($id_transaction);
            if (is_numeric($rs) && $rs >= 0) {
                //thong bao cho nguoi dung ve don hang
                $view_email = "user.transaction.email_notify.deny_order";
                $this->dispatch(new SendNotifyEmail($transaction->email, $view_email, $transaction));
                return redirect()->back()->with('message_success', "Từ chối nhận giao dịch thành công");
            }
            return redirect()->back()->with('message_notification', "Từ chối nhận giao dịch thất bại");

        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * thong bao giao dich hoan tat thanh cong
     * @param $id_transaction
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function notify_transaction_success($id_transaction)
    {
        try {
            $rs = $this->db_transaction->confirm_transaction_success($id_transaction);
            $transaction = $this->db_transaction->get_detail_transaction($id_transaction);
            if (is_numeric($rs) && $rs >= 0) {
                //thong bao cho nguoi dung ve don hang
                $view_email = "user.transaction.email_notify.order_success";
                $this->dispatch(new SendNotifyEmail($transaction->email, $view_email, $transaction));
                return redirect()->back()->with('message_success', "Hoàn tất giao dịch");
            }
            return redirect()->back()->with('message_notification', "Giao dịch chưa hoàn tất");
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * thong bao giao dich that bai
     * @param $id_transaction
     * @param Request $request
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_notify_transaction_fail($id_transaction, Request $request)
    {
        try {
            $reason_fail = trim($request['reason'], " ");
            $rs = $this->db_transaction->notify_transaction_fail($id_transaction, $reason_fail);
            $transaction = $this->db_transaction->get_detail_transaction($id_transaction);
            if ($rs) {
                //thong bao cho nguoi dung ve don hang
                $view_email = "user.transaction.email_notify.order_fail";
                $this->dispatch(new SendNotifyEmail($transaction->email, $view_email, $transaction));
                return redirect()->back()->with('message_success', "Thông báo giao dịch thất bại hoàn tất");
            }
            return redirect()->back()->with('message_notification', "Đã có lỗi xảy ra");
        } catch (\Exception $ex) {
            return $ex;
        }
    }

}
