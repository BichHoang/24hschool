<?php

namespace App\Http\Controllers\User;

use App\DAO\DaoStudent\CartDocumentDao;
use App\DAO\DaoStudent\StudyDocumentDao;
use App\Http\System\SystemStringParameter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartDocumentController extends Controller
{

    protected $db_document;
    protected $db_cart_document;

    public function __construct()
    {
        $this->db_document = new StudyDocumentDao();
        $this->db_cart_document = new CartDocumentDao();
    }

    /**
     * lay ra danh sach tai lieu trong gio hang cua nguoi dung
     * @return \Exception
     */
    public function get_cart_document()
    {
        try {
            $document = $this->db_cart_document->get_cart_document();
            $count = count($document->get());
            $price = $this->calculator_price_document();
            $total = $price;
            $document_send = $document->paginate(SystemStringParameter::PER_PAGE_DOCUMENT());
            return view('user.document.cart')
                ->with('data', $document_send)
                ->with('count', $count)
                ->with('price', $price)
                ->with('total', $total);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * them tai lieu vao gio hang
     * @param $id_document
     * @param Request $request
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function add_document_into_cart($id_document)
    {
        try {
            $rs = $this->db_cart_document->add_document($id_document);
            if ($rs) {
                return redirect('user/document/my_cart')
                    ->with('message_success', "Thêm tài liệu vào giỏ hàng thành công");
            } else {
                return redirect()->back()
                    ->with('message_notification', "Thêm tài liệu vào giỏ hàng thất bại. Vui lòng thử lại sau");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * xoa mot tai lieu trong gio hang cua nguoi dung
     * @param $id_book
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function delete_document_from_cart($id_document)
    {
        try {
            $rs = $this->db_cart_document->delete_document($id_document);
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
    public function delete_all_document_of_user()
    {
        try {
            $rs = $this->db_cart_document->delete_all_document();
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
    public function calculator_price_document(){
        try{
            $cart_document = $this->db_cart_document->get_cart_document()->get();
            $price = 0;
            foreach($cart_document as $document){
                $number_of_document = $document->number;
                if($document->type_document == 1){
                    if($document->sale == 0){
                        $price += ($document->price * $number_of_document);
                    }else{
                        $price += ($document->sale * $number_of_document);
                    }
                }
            }
            return $price;
        }catch (\Exception $ex){
            return $ex;
        }
    }
}
