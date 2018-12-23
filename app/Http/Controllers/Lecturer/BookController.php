<?php

namespace App\Http\Controllers\Lecturer;

use App\DAO\DaoLecturer\BookDao;
use App\Http\Controllers\Controller;
use App\Http\System\SystemStringParameter;
use App\TblTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;
use File;

class BookController extends Controller
{
    protected $_db_book;

    public function __construct()
    {
        $this->_db_book = new BookDao();
        $topic = TblTopic::all();
        view()->share('topic', $topic);
    }

    /**
     * return view for create book
     * @return \Exception|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get_create_book()
    {
        try {
            return view('lecturer.book.create_book');
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * create book by lecturer if success return view detail book and return back
     * @param Request $request
     * @return \Exception
     */
    public function post_create_book(Request $request)
    {
        try {
            $file_image_previous = $request->file('img_previous');
            $file_image_rear = $request->file('img_rear');
            $image_name_previous = Uuid::uuid4() . "." . $file_image_previous->getClientOriginalExtension();
            $image_name_rear = Uuid::uuid4() . "." . $file_image_rear->getClientOriginalExtension();
            $file_ebook = $request->file('ebook');
            $ebook_name = Uuid::uuid4() . "." . $file_ebook->getClientOriginalExtension();

            $book_id = $this->_db_book->create_book($request, $image_name_previous, $image_name_rear, $ebook_name);
            if (is_numeric($book_id) && $book_id == 0) {
                return redirect()->back()->with('message_notification', "Thêm sách thất bại");
            } elseif ($book_id instanceof \Exception) {
                return redirect()->back()->with('message_notification', "Xảy ra sự cố khi thêm sách");
            } else {
                Storage::disk('ebook')->put($ebook_name, File::get($file_ebook));
                Storage::disk('book_image')->put($image_name_previous, File::get($file_image_previous));
                Storage::disk('book_image')->put($image_name_rear, File::get($file_image_rear));
                return redirect('lecturer/book/detail/' . $book_id)
                    ->with('message_success', "Thêm sách thành công");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * display detail of book
     * @param $book_id
     * @return $this|\Exception
     */
    public function get_detail($book_id)
    {
        try {
            $book = $this->_db_book->get_one_book($book_id);
            return view('lecturer.book.detail_book')
                ->with('book', $book);
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    /**
     * change book image by happen only change file image in Storage
     * @param Request $request
     * @param $id_book
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_update_book_image(Request $request, $image_old)
    {
        try {
            if ($request->hasFile('img_book')) {
                Storage::disk('book_image')->delete($image_old);
                Storage::disk('book_image')->put($image_old, File::get($request->file('img_book')));
                return redirect()->back()->with('message_success', "Thay đổi ảnh bìa sách thành công");
            } else {
                return redirect()->back()->with('message_notification', "Bạn chưa thay đổi ảnh bìa");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * update book info
     * @param Request $request
     * @param $id_book
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_update_book_info(Request $request, $id_book)
    {
        try {
            $book = $this->_db_book->get_one_book($id_book);
            $ebook = $book->ebook;
            if ($request->hasFile('ebook')) {
                Storage::disk('ebook')->delete($ebook);
                $ebook = Uuid::uuid4() . "." . $request->file('ebook')->getClientOriginalExtension();
                Storage::disk('ebook')->put($ebook, File::get($request->file('ebook')));
            }
            $rs = $this->_db_book->update_book_info($request, $id_book, $ebook);
            if (is_numeric($rs) && $rs == 1) {
                return redirect()->back()->with('message_success', "Cập nhật thông tin sách thành công");
            } else {
                return redirect()->back()->with('message_notification', "Thông tin sách chưa được thay đổi");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function get_list_book($search)
    {
        try {
            $page = Input::get('page');
            if ($page < 1) {
                $page = 1;
            }
            $start = ($page - 1) * SystemStringParameter::PER_PAGE_BOOK();
            $book_name = trim($search);
            $book = $this->_db_book->list_book_of_lecturer($book_name);
            $count = count($book->get());
            $book_send = $book->paginate(SystemStringParameter::PER_PAGE_BOOK());
            return view('lecturer.book.list_book')
                ->with('book', $book_send)
                ->with('start', $start)
                ->with('count', $count)
                ->with('search_old', $book_name);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * search book
     * @param Request $request
     * @param $search
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_list_book(Request $request, $search)
    {
        try {
            $book_name = trim($request['txt_search']);
            if ($book_name == "") {
                return redirect('lecturer/book/list%20')
                    ->with('message_notification', "Bạn vừa nhập vào một khoảng trắng");
            } else {
                return redirect('lecturer/book/list' . $book_name)
                    ->with('message_success', "Tìm kiếm thành công");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * delete book with document and book image
     * @param $id_book
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function delete_book($id_book){
        try{
            $book = $this->_db_book->get_one_book($id_book);
            if(!is_null($book)){
                $rs = $this->_db_book->delete_book($id_book);
                if(is_numeric($rs) && $rs == 1){
                    Storage::disk('ebook')->delete($book->ebook);
                    Storage::disk('book_image')->delete($book->previous_image);
                    Storage::disk('book_image')->delete($book->rear_image);
                    return redirect()->back()->with('message_success',"Xóa sách thành công");
                }
                return redirect()->back()->with('message_notification',"Xóa sách không thành công");
            }elseif($book instanceof \Exception){
                return redirect()->back()->with('message_notification',"Đã xảy ra lỗi khi xóa sách");
            }else{
                return redirect()->back()->with('message_notification',"Xóa sách không thành công");
            }
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * change status of book
     * @param $id_book
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function change_status_book($id_book){
        try{
            $book = $this->_db_book->get_one_book($id_book);
            $status = $book->status;
            if($status == 0){
                $status = 1;
            }else{
                $status = 0;
            }
            $rs = $this->_db_book->change_status_book($id_book, $status);
            if(is_numeric($rs) && $rs == 1){
                return redirect()->back()->with('message_success',"Thay đổi trạng thái sách thành công");
            }elseif ($rs instanceof \Exception){
                return redirect()->back()->with('message_notification',"Đang xảy ra lỗi ở máy chủ");
            }else{
                return redirect()->back()->with('message_notification',"Thay đổi trạng thái sách thất bại");
            }
        }catch (\Exception $ex){
            return $ex;
        }
    }

}

