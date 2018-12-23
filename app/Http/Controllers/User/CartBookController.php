<?php

namespace App\Http\Controllers\User;

use App\DAO\DaoStudent\BookDao;
use App\DAO\DaoStudent\CartBookDao;
use App\Http\System\SystemStringParameter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartBookController extends Controller
{
    protected $_db_book;

    protected $_db_cart_book;

    public function __construct()
    {
        $this->_db_book = new BookDao();
        $this->_db_cart_book = new CartBookDao();
    }

    /**
     * lay ra danh sach sach trong gio hang cua nguoi dung
     * @return \Exception
     */
    public function get_cart_book()
    {
        try {
            $book = $this->_db_cart_book->get_cart_book();
            $count = count($book->get());
            $price = $this->calculator_price_book();
            $ship = $count* 30000;
            $total = $price + $ship;
            $book_send = $book->paginate(SystemStringParameter::PER_PAGE_BOOK());
            return view('user.book.cart')
                ->with('data', $book_send)
                ->with('count', $count)
                ->with('price', $price)
                ->with('total', $total)
                ->with('ship', $ship);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * them sach vao gio hang
     * @param $id_book
     * @param Request $request
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function add_book_into_cart($id_book, Request $request)
    {
        try {
            $rs = $this->_db_cart_book->add_book($id_book, $request);
            if ($rs) {
                return redirect('user/book/my_cart')
                    ->with('message_success', "Thêm sách vào giỏ hàng thành công");
            } else {
                return redirect()->back()
                    ->with('message_notification', "Thêm sách vào giỏ hàng thất bại. Vui lòng thử lại sau");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * xoa mot cuon sach trong gio hang cua nguoi dung
     * @param $id_book
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function delete_book_from_cart($id_book)
    {
        try {
            $rs = $this->_db_cart_book->delete_book($id_book);
            if (is_numeric($rs) && $rs == 1) {
                return redirect()->back()
                    ->with('message_success', "Xóa đặt hàng sản phẩm thành công");
            } else {
                return redirect()->back()
                    ->with('message_notification', "Xóa sản phẩm thất bại. Vui lòng thử lại sau");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * xoa tat ca gio hang cua nguoi dung
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function delete_all_book_of_user()
    {
        try {
            $rs = $this->_db_cart_book->delete_all_book();
            if (is_numeric($rs) && $rs > 0) {
                return redirect()->back()
                    ->with('message_success', "Xóa đặt hàng sản phẩm thành công");
            } else {
                return redirect()->back()
                    ->with('message_notification', "Xóa sản phẩm thất bại. Vui lòng thử lại sau");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * tinh gia tri cua gio hang
     * @return \Exception|float|int
     */
    public function calculator_price_book(){
        try{
            $cart_book = $this->_db_cart_book->get_cart_book()->get();
            $price = 0;
            foreach($cart_book as $book){
                $number_of_book = $book->number;
                if($book->type_book == 1){
                    if($book->sale == 0){
                        $price += ($book->price * $number_of_book);
                    }else{
                        $price += ($book->sale * $number_of_book);
                    }
                }
            }
            return $price;
        }catch (\Exception $ex){
            return $ex;
        }
    }
}
