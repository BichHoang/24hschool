<?php

namespace App\Http\Controllers\User;

use App\DAO\DaoStudent\BookDao;
use App\DAO\DaoStudent\CartBookDao;
use App\DAO\DaoStudent\RegisterBuyBookDao;
use App\DAO\DaoStudent\TransactionDao;
use App\Http\Controllers\Controller;
use App\Http\System\StringRandom;
use App\Http\System\SystemStringParameter;
use App\Jobs\SendNotifyEmail;
use App\Mail\MailForgotPassword;
use App\Mail\NotifyOrder;
use App\TblBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RegisterBuyBookController extends Controller
{
    protected $_db_register_buy_book;
    protected $_db_cart_book;
    protected $_db_book;
    protected $_db_transaction;

    public function __construct()
    {
        $this->_db_register_buy_book = new RegisterBuyBookDao();
        $this->_db_cart_book = new CartBookDao();
        $this->_db_book = new BookDao();
        $this->_db_transaction = new TransactionDao();
    }

    /**
     * gui di dang ky mua sach, tat ca sach trong gio
     * @param Request $request
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_register_buy_book(Request $request)
    {
        try {
            $cart_book = $this->_db_cart_book->get_cart_book()->get();
            $price = $this->calculator_price_cart_book($cart_book);
            $total = $price + count($cart_book);
            $books = null;
            foreach ($cart_book as $book) {
                $item = null;
                $item['id_book'] = $book->id_book;
                $item['number'] = $book->number;
                $item['price_sale'] = 0;
                if ($book->type_book == 1){
                    if($book->sale == 0 || $book->sale == ""){
                        $item['price_sale'] = $book->price;
                    }else{
                        $item['price_sale'] = $book->sale;
                    }
                }
                $books[] = $item;
                TblBook::find($book->id_book)->increment('bought', $book->number);
            }
            $books = json_encode($books);
            $code = StringRandom::generate_random_code();
            $is_ebook = 0;
            $register_buy_book = $this->_db_register_buy_book
                ->buy_all_book_in_cart($request, $books, $price, $code, $is_ebook);
            if (!($register_buy_book instanceof \Exception)) {
                $transaction = $this->_db_transaction->get_detail_transaction($register_buy_book);
                //gui mail thong bao dang ky mua hang cho nguoi dung
                $view_email = "user.transaction.email_notify.register_buy_item";
                $this->dispatch(new SendNotifyEmail($transaction->email, $view_email, $transaction));
                return redirect('user/transaction/all')
                    ->with('message_success', "Đặt mua sách thành công. Hãy chờ nhân viên của 24hSchool liên lạc lại. Xin cám ơn");
            } else {
                return redirect()->back()->with('message_notification', "Đặt mua sách thất bại. Hãy thử lại sau");
            }

        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * view for register buy ebook
     * @param $id_book
     * @return \Exception
     */
    public function get_register_buy_ebook($id_book)
    {
        try {
            $book = $this->_db_book->get_one_book($id_book);
            $total = 0;
            $price = 0;
            if ($book->type_book == 1) {
                $price = $book->price_of_ebook;
                $total = $book->price_of_ebook;
            }
            $is_ebook = 1;
            return view('user.transaction.book.form_info', [
                'book' => $book,
                'total' => $total,
                'price' => $price,
                'is_ebook' => $is_ebook,
            ]);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * send request buy ebook of user
     * @param Request $request
     * @param $id_book
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_register_buy_ebook(Request $request, $id_book)
    {
        try {
            $book = $this->_db_book->get_one_book($id_book);
            if ($book->status == 0) {
                return redirect()->back()
                    ->with('message_notification', "Xin lỗi. Hàng đã hết. Xin mua vào lần sau");
            }
            $total = 0;
            if ($book->type_book == 1) {
                $total = $book->price_of_ebook;
            }
            $item['id_book'] = $book->id;
            $item['number'] = 1;
            $item['price_sale'] = $total;
            $books[] = $item;
            //tang so luot mua them 1 don vi
            $increment_buy_book = TblBook::find($id_book)->increment('bought');

            $books = json_encode($books);
            $code = StringRandom::generate_random_code();
            $is_ebook = 1;
            $register_buy_book = $this->_db_register_buy_book
                ->register_buy_book($request, $books, $total, $code, $is_ebook);
            if (!($register_buy_book instanceof \Exception)) {
                $transaction = $this->_db_transaction->get_detail_transaction($register_buy_book);
                //gui mail thong bao mua san pham
                $view_email = "user.transaction.email_notify.register_buy_item";
                $this->dispatch(new SendNotifyEmail($transaction->email, $view_email, $transaction));
                return redirect('user/transaction/all')
                    ->with('message_success', "Đặt mua sách thành công. Hãy chờ nhân viên của 24hSchool liên lạc lại. Xin cám ơn");
            } else {
                return redirect()->back()->with('message_notification', "Đặt mua sách thất bại. Hãy thử lại sau");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * display view for user enter user's info for buy book
     * @param $id_book
     * @return \Exception|float|int
     */
    public function get_register_buy_whole($id_book)
    {
        try {
            $book = $this->_db_book->get_one_book($id_book);
            $is_ebook = 2;
            $ship = 30000;
            $price = 0;
            $total = 0;
            if ($book->type_book == 1) {
                $price = $book->price + $book->price_of_ebook * 0.5;
            }
            $total = $ship + $price;
            return view('user.transaction.book.form_info', [
                'book' => $book,
                'price' => $price,
                'total' => $total,
                'is_ebook' => $is_ebook,
                'ship' => $ship
            ]);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * send request buy whole book
     * @param Request $request
     * @param $id_book
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_register_buy_whole(Request $request, $id_book)
    {
        try {
            $book = $this->_db_book->get_one_book($id_book);
            if ($book->status == 0) {
                return redirect()->back()
                    ->with('message_notification', "Xin lỗi. Hàng đã hết. Xin mua vào lần sau");
            }
            $price = 0;
            if ($book->type_book == 1) {
                if ($book->sale == 0) {
                    $price = $book->price + $book->price_of_ebook * 0.5;
                } else {
                    $price = $book->sale + $book->price_of_ebook * 0.5;
                }
            }
            $total = $price + 30000;

            $item['id_book'] = $book->id;
            $item['number'] = 1;
            $item['price_sale'] = $price;
            $books[] = $item;
            //tang so luot mua them 1 don vi
            $increment_buy_book = TblBook::find($id_book)->increment('bought');

            $books = json_encode($books);
            $code = StringRandom::generate_random_code();
            $is_ebook = 2;
            $register_buy_book = $this->_db_register_buy_book
                ->register_buy_book($request, $books, $total, $code, $is_ebook);
            if (!($register_buy_book instanceof \Exception)) {
                $transaction = $this->_db_transaction->get_detail_transaction($register_buy_book);
                //gui mail thong bao mua san pham
                $view_email = "user.transaction.email_notify.register_buy_item";
                $this->dispatch(new SendNotifyEmail($transaction->email, $view_email, $transaction));
                return redirect('user/transaction/all')
                    ->with('message_success', "Đặt mua sách thành công. Hãy chờ nhân viên của 24hSchool liên lạc lại. Xin cám ơn");
            } else {
                return redirect()->back()->with('message_notification', "Đặt mua sách thất bại. Hãy thử lại sau");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * tinh gia tien cua sach trong gio
     * @param $cart_book
     * @return \Exception|float|int
     */
    public function calculator_price_cart_book($cart_book)
    {
        try {
            $price = 0;
            foreach ($cart_book as $book) {
                $number_of_book = $book->number;
                if ($book->type_book == 1) {
                    if ($book->sale == 0 || $book->sale == "") {
                        $price += ($book->price * $number_of_book);
                    } else {
                        $price += ($book->sale * $number_of_book);
                    }
                }
            }
            return $price;
        } catch (\Exception $ex) {
            return $ex;
        }
    }

}
