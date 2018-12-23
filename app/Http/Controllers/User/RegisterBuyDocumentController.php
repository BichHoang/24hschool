<?php

namespace App\Http\Controllers\User;

use App\DAO\DaoStudent\CartDocumentDao;
use App\DAO\DaoStudent\RegisterBuyDocumentDao;
use App\DAO\DaoStudent\StudyDocumentDao;
use App\DAO\DaoStudent\TransactionDao;
use App\Http\System\StringRandom;
use App\Jobs\SendNotifyEmail;
use App\TblStudyDocument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterBuyDocumentController extends Controller
{
    protected $db_document;
    protected $db_cart_document;
    protected $db_register_buy_document;
    protected $db_transaction;

    public function __construct()
    {
        $this->db_register_buy_document = new RegisterBuyDocumentDao();
        $this->db_cart_document = new CartDocumentDao();
        $this->db_document = new StudyDocumentDao();
        $this->db_transaction = new TransactionDao();
    }

    /**
     * gui di dang ky mua tai lieu, tat ca tai lieu trong gio
     * @param Request $request
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_register_buy_all_cart(Request $request)
    {
        try {
            $cart_document = $this->db_cart_document->get_cart_document()->get();
            $price = $this->calculator_price_document();
            $documents = null;
            foreach ($cart_document as $document) {
                $item = null;
                $item['id_document'] = $document->id_document;
                $item['number'] = $document->number;
                $item['price_sale'] = 0;
                if ($document->type_document == 1){
                    if($document->sale == 0 || $document->sale == ""){
                        $item['price_sale'] = $document->price;
                    }else{
                        $item['price_sale'] = $document->sale;
                    }
                }
                $documents[] = $item;
                TblStudyDocument::find($document->id_document)->increment('bought', $document->number);
            }
            $documents = json_encode($documents);
            $code = StringRandom::generate_random_code();
            $type_item = 1;
            $register_buy_document = $this->db_register_buy_document
                ->buy_all_document_in_cart($request, $documents, $price, $code, $type_item);
            if (!($register_buy_document instanceof \Exception)) {
                $transaction = $this->db_transaction->get_detail_transaction($register_buy_document);
                //gui mail thong bao dang ky mua hang cho nguoi dung
                $view_email = "user.transaction.email_notify.register_buy_item";
                $this->dispatch(new SendNotifyEmail($transaction->email, $view_email, $transaction));
                return redirect('user/transaction/all')
                    ->with('message_success', "Đặt mua tài liệu thành công. Hãy chờ nhân viên của 24hSchool liên lạc lại. Xin cám ơn");
            } else {
                return redirect()->back()->with('message_notification', "Đặt mua tài liệu thất bại. Hãy thử lại sau");
            }

        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * view for register buy document
     * @param $id_document
     * @return \Exception
     */
    public function get_register_buy_document($id_document)
    {
        try {
            $document = $this->db_document->get_one_document($id_document);
            $price = 0;
            if ($document->type_document == 1) {
                if($document->sale == 0){
                    $price = $document->price;
                }else{
                    $price = $document->sale;
                }
            }
            $type_item = 1;
            return view('user.transaction.document.form_info', [
                'document' => $document,
                'price' => $price,
                'type_item' => $type_item,
            ]);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * send request buy document of user
     * @param Request $request
     * @param $id_document
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_register_buy_document(Request $request, $id_document)
    {
        try {
            $document = $this->db_document->get_one_document($id_document);
            $total = 0;
            if ($document->type_document == 1) {
                if($document->sale == 0){
                    $total = $document->price;
                }else{
                    $total = $document->sale;
                }
            }
            $item['id_document'] = $document->id;
            $item['number'] = 1;
            $item['price_sale'] = $total;
            $documents[] = $item;
            //tang so luot mua them 1 don vi
            $increment_buy_document = TblStudyDocument::find($id_document)->increment('bought');

            $documents = json_encode($documents);
            $code = StringRandom::generate_random_code();
            $type_item = 1;
            $register_buy_document = $this->db_register_buy_document
                ->register_buy_document($request, $documents, $total, $code, $type_item);
            if (!($register_buy_document instanceof \Exception)) {
                $transaction = $this->db_transaction->get_detail_transaction($register_buy_document);
                //gui mail thong bao mua san pham
                $view_email = "user.transaction.email_notify.register_buy_item";
                $this->dispatch(new SendNotifyEmail($transaction->email, $view_email, $transaction));
                return redirect('user/transaction/all')
                    ->with('message_success', "Đặt mua tài liệu thành công. Hãy chờ nhân viên của 24hSchool liên lạc lại. Xin cám ơn");
            } else {
                return redirect()->back()->with('message_notification', "Đặt mua tài liệu thất bại. Hãy thử lại sau");
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
