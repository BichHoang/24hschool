<?php

namespace App\Http\Controllers\User;

use App\DAO\DaoStudent\StudyDocumentDao;
use App\Http\System\SystemStringParameter;
use App\TblStudyDocument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudyDocumentController extends Controller
{
    protected $db_document;
    protected $db_cart_document;

    public function __construct()
    {
        $this->db_document = new StudyDocumentDao();
    }

    /**
     * xem danh sach tai lieu
     * @return $this|\Exception
     */
    public function get_all_document(){
        try{
            $document = $this->db_document->all_study_document();
            $document_send = $document->paginate(SystemStringParameter::PER_PAGE_DOCUMENT());
            return view('user.document.show_document')
                ->with('document', $document_send);

        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * xem chi tiet tai lieu
     * @param $id_document
     * @return $this|\Exception|\Illuminate\Http\RedirectResponse
     */
    public function get_detail_document($id_document)
    {
        try {
            $document = $this->db_document->get_one_document($id_document);
            $seen = $document->seen;
            $increment_seen_document = TblStudyDocument::find($id_document)->increment('seen');

            if (is_null($document) || $document instanceof \Exception) {
                return redirect()->back()->with('message_notification', "Đã có lỗi xảy ra. Hãy thử lại sau");
            } else {
                return view('user.document.detail')
                    ->with('document', $document);
            }

        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * tim kiem tai lieu hoc tap
     * @param $keyword
     * @return $this|\Exception
     */
    public function get_search_document($keyword)
    {
        try {
            $keyword = trim($keyword, " ");
            $document = $this->db_document->search_document($keyword);
            $document_send = $document->paginate(SystemStringParameter::PER_PAGE_DOCUMENT());
            return view('user.document.show_document')
                ->with('document', $document_send);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * tim kiem tai lieu hoc tap
     * @param Request $request
     * @param $keyword
     * @return \Exception|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     */
    public function post_search_document(Request $request, $keyword){
        try{
            $search = trim($request['search_document'], " ");
            if($search == ""){
                return redirect('user/document/search-%20')
                    ->with('message_notification', "Bạn vừa nhập vào một khoảng trắng");
            }else{
                return redirect('user/document/search-'. $search);
            }
        }catch (\Exception $ex){
            return $ex;
        }
    }
}
