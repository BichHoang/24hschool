<?php

namespace App\Http\Controllers\User;

use App\DAO\DaoStudent\BookDao;
use App\Http\System\SystemStringParameter;
use App\TblBook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class BookController extends Controller
{
    protected $_db_book;

    public function __construct()
    {
        $this->_db_book = new BookDao();
    }

    /**
     * get all
     * @return $this|\Exception
     */
    public function get_all_book()
    {
        try {
            $book = $this->_db_book->get_all_book();
            $book_send = $book->paginate(SystemStringParameter::PER_PAGE_BOOK());
            return view('user.book.show_book')
                ->with('book', $book_send);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function get_detail_book($id_book)
    {
        try {
            $book = $this->_db_book->get_one_book($id_book);
            $seen = $book->seen;
            $increment_seen_book = TblBook::find($id_book)->increment('seen');

            if (is_null($book) || $book instanceof \Exception) {
                return redirect()->back()->with('message_notification', "Đã có lỗi xảy ra. Hãy thử lại sau");
            } else {
                return view('user.book.detail')
                    ->with('book', $book);
            }

        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function get_search_book($keyword)
    {
        try {
            $keyword = trim($keyword, " ");
            $book = $this->_db_book->search_book($keyword);
            $book_send = $book->paginate(SystemStringParameter::PER_PAGE_BOOK());
            return view('user.book.show_book')
                ->with('book', $book_send);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function post_search_book(Request $request, $keyword){
        try{
            $search = trim($request['search_book'], " ");
            if($search == ""){
                return redirect('user/book/search-%20')
                    ->with('message_notification', "Bạn vừa nhập vào một khoảng trắng");
            }else{
                return redirect('user/book/search-'. $search);
            }
        }catch (\Exception $ex){
            return $ex;
        }
    }
}
