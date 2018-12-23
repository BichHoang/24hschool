<?php

namespace App\Http\Controllers\User;

use App\DAO\DaoStudent\BookDao;
use App\DAO\DaoStudent\StudyDocumentDao;
use App\DAO\DaoStudent\TransactionDao;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ManageFile\FileExam;
use App\Http\System\SystemStringParameter;
use App\Mail\MailForgotPassword;
use App\Mail\NotifyOrder;
use App\TblBook;
use App\TblStudyDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
    protected $_db_transaction;
    protected $_db_book;
    protected $_db_document;
    protected $file;

    public function __construct()
    {
        $this->_db_transaction = new TransactionDao();
        $this->_db_book = new BookDao();
        $this->_db_document = new StudyDocumentDao();
        $this->file = new FileExam();
    }

    /**
     * hien thi danh sach dang ky mua sach va tai lieu cua nguoi dung
     * @return $this|\Exception
     */
    public function get_list_transaction()
    {
        try {
            $data = $this->_db_transaction->get_list_transaction();
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_BOOK());
            foreach ($data_send as $transaction) {
                $transaction->book = json_decode($transaction->item, true);
            }
            return view('user.transaction.list_transaction')
                ->with('data', $data_send);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * hien thi danh sach sach cua nguoi dung da mua
     * @return $this|\Exception|\Illuminate\Http\RedirectResponse
     */
    public function get_my_book()
    {
        try {
            $data = $this->_db_transaction->get_list_transaction_book_success();
            if (is_null($data) || count($data) <= 0) {
                return redirect()->back()->with('message_notification', "Bạn chưa mua cuốn sách nào");
            }
            $id_book = null;
            foreach ($data as $transaction) {
                $transaction->book = json_decode($transaction->item);
                foreach ($transaction->book as $item) {
                    $id_book[] = $item->id_book;
                }
            }
            $book = TblBook::find($id_book);
            return view('user.book.my_book')
                ->with('book', $book);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * nguoi dung xem noi dung cuon sach ma ho da mua
     * @param $id_ebook
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function detail_my_book($id_ebook){
        try{
            $data = $this->_db_transaction->get_list_transaction_book_success();
            if (is_null($data) || count($data) <= 0) {
                return redirect()->back()->with('message_notification', "Bạn chưa mua cuốn sách nào");
            }
            $tag = false;
            foreach ($data as $transaction) {
                if($transaction->type_item == 1 || $transaction->type_item == 2){
                    $transaction->book = json_decode($transaction->item);
                    foreach ($transaction->book as $item) {
                        if(strcmp($item->id_book, $id_ebook) == 0){
                            $tag = true;
                            break;
                        }
                    }
                }
            }
            if($tag){
                $book = $this->_db_book->get_one_book($id_ebook);
                return $this->file->get_file_ebook_for_user($book->ebook);
            }else{
                return redirect()->back()->with('message_notification', "Bạn chưa mua ebook của cuốn sách này");
            }

        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * hien thi danh sach tai lieu da mua
     * @return $this|\Exception|\Illuminate\Http\RedirectResponse
     */
    public function get_my_document(){
        try {
            $data = $this->_db_transaction->get_list_transaction_document_success();
            if (is_null($data) || count($data) <= 0) {
                return redirect()->back()->with('message_notification', "Bạn chưa mua tài liệu nào");
            }
            $id_document = null;
            foreach ($data as $transaction) {
                $transaction->document = json_decode($transaction->item);
                foreach ($transaction->document as $item) {
                    $id_document[] = $item->id_document;
                }
            }
            $document = TblStudyDocument::find($id_document);
            return view('user.document.my_document')
                ->with('document', $document);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * nguoi dung xem noi dung tai lieu ma ho da mua
     * @param $id_ebook
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function detail_my_document($id_document){
        try{
            $data = $this->_db_transaction->get_list_transaction_document_success();
            if (is_null($data) || count($data) <= 0) {
                return redirect()->back()->with('message_notification', "Bạn chưa mua tài liệu nào");
            }
            $tag = false;
            foreach ($data as $transaction) {
                if($transaction->type_item == 1 || $transaction->type_item == 2){
                    $transaction->document = json_decode($transaction->item);
                    foreach ($transaction->document as $item) {
                        if(strcmp($item->id_document, $id_document) == 0){
                            $tag = true;
                            break;
                        }
                    }
                }
            }
            if($tag){
                $document = $this->_db_document->get_one_document($id_document);
                return $this->file->get_file_document_for_user($document->document);
            }else{
                return redirect()->back()->with('message_notification', "Bạn chưa mua tài liệu này");
            }

        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * hien thi chi tiet giao dich sach
     * @param $id_transaction
     * @return $this|\Exception
     */
    public function detail_transaction_book($id_transaction)
    {
        try {
            $data = $this->_db_transaction->get_detail_transaction($id_transaction);
            $book = null;
            $data->book = json_decode($data->item);
            foreach ($data->book as $item) {
                $value = $this->_db_book->get_one_book($item->id_book);
                $value->number = $item->number;
                $value->price_sale = $item->price_sale;
                $book[] = $value;
            }
            return view('user.transaction.book.detail')
                ->with('data', $data)
                ->with('book', $book);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * hien thi chi tiet giao dich tai lieu
     * @param $id_transaction
     * @return $this|\Exception
     */
    public function detail_transaction_document($id_transaction)
    {
        try {
            $data = $this->_db_transaction->get_detail_transaction($id_transaction);
            $document = null;
            $data->document = json_decode($data->item);
            foreach ($data->document as $item) {
                $value = $this->_db_document->get_one_document($item->id_document);
                $value->number = $item->number;
                $value->price_sale = $item->price_sale;
                $document[] = $value;
            }
            return view('user.transaction.document.detail')
                ->with('data', $data)
                ->with('document', $document);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * customer cancel transaction
     * @param $id_transaction
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function cancel_transaction($id_transaction)
    {
        try {
            $transaction = $this->_db_transaction->get_detail_transaction($id_transaction);
            $rs = $this->_db_transaction->cancel_transaction($id_transaction);
            if (is_numeric($rs) && $rs > 0) {
                //gui mail thong bao mua san pham
                $view_email = "user.transaction.email_notify.cancel_order";
                Mail::to($transaction->email)->queue(new NotifyOrder($view_email, $transaction));
                return redirect()->back()->with('message_success', "Giao dịch được hủy thành công");
            } else {
                return redirect()->back()->with('message_notification', "Giao dịch hủy thất bại");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * customer delete transaction history
     * @param $id_transaction
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function hide_transaction_with_customer($id_transaction)
    {
        try {
            $rs = $this->_db_transaction->hide_transaction_with_user($id_transaction);
            if (is_numeric($rs) && $rs > 0) {
                return redirect()->back()->with('message_success', "Xóa lịch sử giao dịch thành công");
            } else {
                return redirect()->back()->with('message_notification', "Xóa lịch sử giao dịch thất bại");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

}
