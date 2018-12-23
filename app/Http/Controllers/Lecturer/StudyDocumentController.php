<?php

namespace App\Http\Controllers\Lecturer;

use App\DAO\AbstractStudyDocument;
use App\DAO\DaoLecturer\StudyDocumentDao;
use App\Http\System\Convert;
use App\Http\System\SystemStringParameter;
use App\TblClassRoom;
use App\TblSubject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;
use File;

class StudyDocumentController extends Controller
{
    private $_db_study_document;

    public function __construct()
    {
        $this->_db_study_document = new StudyDocumentDao();
        $subject = TblSubject::all();
        $class = TblClassRoom::all();

        view()->share('subject', $subject);
        view()->share('class', $class);
    }

    /**
     * get all document
     * @return \Exception
     */
    public function get_list_document($search)
    {
        try {
            $page = Input::get('page');
            if ($page < 1) {
                $page = 1;
            }
            $start = ($page - 1) * SystemStringParameter::PER_PAGE_DOCUMENT();
            $document_name = trim($search);
            $document = $this->_db_study_document->study_document_of_lecturer($document_name);
            $count = count($document->get());
            $document_send = $document->paginate(SystemStringParameter::PER_PAGE_DOCUMENT());
            return view('lecturer.study_document.list_document')
                ->with('document', $document_send)
                ->with('start', $start)
                ->with('count', $count)
                ->with('search_old', $document_name);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * search study document
     * @param Request $request
     * @param $search
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_list_document(Request $request, $search)
    {
        try {
            $document_name = trim($request['txt_search']);
            if ($document_name == "") {
                return redirect('lecturer/study_document/list%20')
                    ->with('message_notification', "Bạn vừa nhập vào một khoảng trắng");
            } else {
                return redirect('lecturer/study_document/list' . $document_name)
                    ->with('message_success', "Tìm kiếm thành công");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function get_create_document()
    {
        try {
            return view('lecturer.study_document.create_document');
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * create study document
     * @param Request $request
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_create_document(Request $request)
    {
        try {
            $file_image = $request->file('img_document');
            $image_name = Uuid::uuid4() . "." . $file_image->getClientOriginalExtension();
            $file_document = $request->file('document');
            $document_name = Uuid::uuid4() . "." . $file_document->getClientOriginalExtension();

            $document_id = $this->_db_study_document->create_document($request, $image_name, $document_name);
            if (is_numeric($document_id) && $document_id == 0) {
                return redirect()->back()->with('message_notification', "Thêm tài liệu thất bại");
            } elseif ($document_id instanceof \Exception) {
                return redirect()->back()->with('message_notification', "Xảy ra sự cố khi thêm tài liệu");
            } else {
                Storage::disk('study_document')->put($document_name, File::get($file_document));
                Storage::disk('study_document_image')->put($image_name, File::get($file_image));
                return redirect('lecturer/study_document/detail/' . $document_id)
                    ->with('message_success', "Thêm tài liệu thành công");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * display detail of study document
     * @param $id_document
     * @return $this|\Exception
     */
    public function get_detail($id_document)
    {
        try {
            $document = $this->_db_study_document->get_one_document($id_document);
            return view('lecturer.study_document.detail_document')
                ->with('document', $document);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * change image of document without change database
     * @param Request $request
     * @param $id_document
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_update_image(Request $request, $id_document)
    {
        try {
            $document = $this->_db_study_document->get_one_document($id_document);
            $image_old = $document->image;
            if ($request->hasFile('img_document')) {
                Storage::disk('study_document_image')->delete($image_old);
                Storage::disk('study_document_image')->put($image_old, File::get($request->file('img_document')));
                return redirect()->back()->with('message_success', "Thay đổi ảnh bìa tài liệu thành công");
            } else {
                return redirect()->back()->with('message_notification', "Bạn chưa thay đổi ảnh bìa");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }


    public function post_update_info(Request $request, $id_document)
    {
        try {
            $document = $this->_db_study_document->get_one_document($id_document);
            $link_document = $document->document;
            if ($request->hasFile('document')) {
                Storage::disk('study_document')->delete($link_document);
                $link_document = Uuid::uuid4() . "." . $request->file('document')->getClientOriginalExtension();
                Storage::disk('study_document')->put($link_document, File::get($request->file('document')));
            }
            $rs = $this->_db_study_document->update_document_info($request, $id_document, $link_document);
            if (is_numeric($rs) && $rs == 1) {
                return redirect()->back()->with('message_success', "Cập nhật thông tin tài liệu thành công");
            } else {
                return redirect()->back()->with('message_notification', "Thông tin tài liệu chưa được thay đổi");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }


}
