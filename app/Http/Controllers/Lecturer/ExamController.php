<?php

namespace App\Http\Controllers\Lecturer;

use App\DAO\DaoLecturer\LecturerExamDao;
use App\Http\Controllers\Controller;
use App\Http\System\StringRandom;
use App\Http\System\SystemStringParameter;
use App\TblClassRoom;
use App\TblLevel;
use App\TblSubject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use File;
use Ramsey\Uuid\Uuid;



class ExamController extends Controller
{
    private $_db_exam;

    /**
     * create a new instance of ExamController class
     *
     * ExamController constructor.
     */
    public function __construct()
    {
        $this->_db_exam = new LecturerExamDao();
    }

//-------------------------------------------- delete exam -------------------------------------------------------------

    /**
     * delete one my exam
     *
     * @param $id_exam
     * @return \Exception|\Illuminate\Http\RedirectResponse|int
     */
    public function delete_my_exam($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_a_my_exam_file($id_exam);
            if (is_null($exam)) {
                return redirect()->back()->with('message_notification', "Đề này không phải của bạn");
            } else {
                //delete record in database
                //then delete file in exam and explain if have
                $rs = $this->_db_exam->delete_exam($id_exam);
                if (is_numeric($rs) && $rs == 1) {
                    Storage::disk('exam')->delete($exam->name_briefly);
                    Storage::disk('explain')->delete($exam->explain_file_name);
                    return redirect()->back()->with('message_success', "Xóa đề thi thành công");
                } elseif (is_numeric($rs) && $rs == 0) {
                    return redirect()->back()->with('message_notification', "Xóa đề không thành công");
                } else {
                    return redirect()->back()->with('message_notifcation', "Đã xảy ra lỗi");
                }
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * delete one exam of ctv
     * @param $id_exam
     * @return \Exception|\Illuminate\Http\RedirectResponse|int
     */
    public function delete_exam_of_ctv($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_a_exam_file($id_exam);
            if (is_null($exam)) {
                return redirect()->back()->with('message_notification', "Đề này không do cộng tác viên của bạn tạo ra");
            } else {
                //delete record in database
                //then delete file in exam and explain if have
                $rs = $this->_db_exam->delete_exam($id_exam);
                if (is_numeric($rs) && $rs == 1) {
                    Storage::disk('exam')->delete($exam->name_briefly);
                    Storage::disk('explain')->delete($exam->explain_file_name);
                    return redirect()->back()->with('message_success', "Xóa đề thi thành công");
                } elseif (is_numeric($rs) && $rs == 0) {
                    return redirect()->back()->with('message_notification', "Xóa đề không thành công");
                } else {
                    return redirect()->back()->with('message_notifcation', "Đã xảy ra lỗi");
                }
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    //---------------------------------------- create a new exam and store into exam repository or web -----------------

    /**
     * display view upload file exam
     *
     * @return \Exception|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get_upload_exam()
    {
        try {
            $class_room = TblClassRoom::all();
            $subject = TblSubject::all();
            $level = TblLevel::all();

            return view('lecturer.exam.upload_exam')
                ->with('class_room', $class_room)
                ->with('subject', $subject)
                ->with('level', $level);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * redirect submit if button save is clicked -> save exam to my exam repository
     * else if button enter_answer is clicked -> save exam then display enter answer page for user
     *
     * @param Request $request
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_upload_exam(Request $request)
    {
        try {
            //file exam without file explain
            if ($request->hasFile('file_exam')) {
                $exam_file_name = $this->check_file($request['file_exam']);
                //check file exam
                if ($exam_file_name == 0) {
                    return redirect()->back()->with('message_notification', "File đề thi chỉ nhận file word or pdf");
                } elseif ($exam_file_name == 1) {
                    return redirect()->back()->with('message_notification', "Kích thước file đề thi vượt quá 4MB");
                } else {
                    //has file explain
                    if ($request->hasFile('file_explain')) {
                        $explain_file_name = $this->check_file($request['file_explain']);
                        //check file explain
                        if ($explain_file_name == 0) {
                            return redirect()->back()
                                ->with('message_notification', "File giải thích chỉ nhận file word or pdf");
                        } elseif ($explain_file_name == 1) {
                            return redirect()->back()
                                ->with('message_notification', "Kích thước file giải thích vượt quá 4MB");
                        } else {
                            $image = $request->file('img_exam');
                            $image_name = Uuid::uuid4(). "." . $image->getClientOriginalExtension();
                            $rs_db = $this->_db_exam
                                ->upload_exam_and_explain($request, $exam_file_name, $explain_file_name, $image_name);
                            if ($rs_db) {
                                $rs_img = Storage::disk('exam_image')
                                    ->put($image_name, File::get($image));
                                $rs_exam = Storage::disk('exam')
                                    ->put($exam_file_name, File::get($request->file('file_exam')));
                                $rs_explain = Storage::disk('explain')
                                    ->put($explain_file_name, File::get($request->file('file_explain')));
                                if (isset($request['save'])) {
                                    return redirect('lecturer/exam/my_exam/not_answer/list=%20')
                                        ->with('message_success', "Tải đề thi và giải thích lên thành công");
                                } elseif (isset($request['enter_answer'])) {
                                    return redirect('lecturer/exam/my_exam/not_answer/enter_answer=' . $rs_db)
                                        ->with('message_success', "Tải đề thi và giải thích lên thành công");
                                }else{
                                    return redirect()->back()->with('message_notification',"Tạo đề thi thất bại");
                                }

                            } else {
                                return redirect('lecturer/exam/my_exam/not_answer/list=%20')
                                    ->with('message_notification', "Lưu đề thi không thành công");
                            }
                        }
                    } else {
                        return redirect()->back()->with('message_notification', "Bạn chưa nhập file giải thích");
                    }
                }
            } else {
                return redirect()->back()->with('message_notification', "Bạn phải nhập file đề thi");
            }

        } catch (\SQLiteException $ex) {
            return redirect()->back()->with('message_notification', "Lỗi kết nối với máy chủ");
        } catch (\Exception $ex) {
            return redirect()->back()->with('message_notification', "Đã có lỗi xảy ra");
        }
    }

    /**
     * check condition of file and return file_name if valid
     *
     * @param Request $request
     * @return \Exception|int|string
     */
    public function check_file($file)
    {
        try {
            $file_size = $file->getClientSize() >> 10; // size file = kb
            $file_extension = $file->getClientOriginalExtension();
            $file_extension = strtolower($file_extension);
            //check file size
            if ($file_size > (1024 * 20)) {
                return 1;//return "Kích thước file đã vượt quá 1MB"
            }
            //check file extension
            if (strcmp($file_extension, "pdf") == 0 ||
                strcmp($file_extension, "doc") == 0 ||
                strcmp($file_extension, "docx") == 0) {

                //generate file string name
                $file_name = StringRandom::generate_random_string() . "." . $file_extension;
                return $file_name;

            } else {
                return 0;//return "File không đúng định dạng"
            }

        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * display view for enter answer for exam hasn't been answer
     *
     * @param $id_exam
     * @return \Exception
     */
    public function get_enter_answer($id_exam)
    {
        try {
            $data = $this->_db_exam->get_a_my_exam_file($id_exam);

            $file_name = $data->name_briefly;
            $number_of_questions = $data->number_of_questions;
            return view('lecturer.exam.my_exam.exam_not_answer.enter_answer')
                ->with('file_name', $file_name)
                ->with('number_of_questions', $number_of_questions)
                ->with('exam', $data);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * save answer of exam
     *
     * @param Request $request
     * @param $id_exam
     * @return \Exception
     */
    public function post_enter_answer(Request $request, $id_exam)
    {
        try {
            $exam = $this->_db_exam->get_a_my_exam_file($id_exam);
            if (is_null($exam)) {
                return redirect()->back()->with('message_notification', "Đề thi này không phải của bạn");
            }
            $number_of_questions = $exam->number_of_questions;
            $list_answer = [];
            for ($index = 1; $index <= $number_of_questions; $index++) {
                $answer = $request[$index];
                if ($answer <= 4 && $answer >= 1) {
                    $list_answer[] = [
                        'stt' => $index,
                        'answer' => $answer
                    ];
                } else {
                    return redirect()->back()->with('message_notification', "Nhập đáp án không đúng định dạng. Nhập lại");
                }
            }
            $list_answer_json = json_encode($list_answer);
            $result = $this->_db_exam->save_answer($id_exam, $list_answer_json);
            if (is_numeric($result)) {
                return redirect('lecturer/exam/my_exam/have_answer/list=%20')
                    ->with('message_success', "Lưu đáp án thành công");
            }
            return redirect()->back()->with('message_notification', "Lưu đáp án thất bại");
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    //----------------------------------- update exam ------------------------------------------------------------------

    /**
     * display view for lecturer choose exam modification ways
     *
     * @param $id_exam
     * @return $this|\Exception|\Illuminate\Http\RedirectResponse
     */
    public function get_update_view($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_one_exam_for_modification($id_exam);
            if (is_null($exam)) {
                return redirect()->back()->with('message_notification', "Đề thi này không được phép sửa");
            }
            return view('lecturer.exam.my_exam.choose_update')
                ->with('exam', $exam);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * display view for change exam file
     *
     * @param $id_exam
     * @return $this|\Exception|\Illuminate\Http\RedirectResponse
     */
    public function get_update_exam_file($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_one_exam_for_modification($id_exam);
            if (is_null($exam)) {
                return redirect()->back()->with('message_notification', "Đề thi này không được phép sửa");
            } else {
                return view('lecturer.exam.my_exam.update_exam')
                    ->with('exam', $exam);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * update exam file for exam by id_exam
     *
     * @param Request $request
     * @param $id_exam
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_update_exam_file(Request $request, $id_exam)
    {
        try {
            $exam = $this->_db_exam->get_one_exam_for_modification($id_exam);
            if (is_null($exam)) {
                return redirect()->back()->with('message_notification', "Đề thi này không được phép sửa");
            }
            if ($request->hasFile('file_exam')) {
                $exam_file_name = $this->check_file($request['file_exam']);
                if ($exam_file_name == 0) {
                    return redirect()->back()->with('message_notification', "File đề thi chỉ nhận file word or pdf");
                } elseif ($exam_file_name == 1) {
                    return redirect()->back()->with('message_notification', "Kích thước file đề thi vượt quá 30MB");
                } else {
                    $rs = $this->_db_exam->update_exam_file($id_exam, $exam_file_name);
                    if (is_numeric($rs) && $rs == 1) {
                        Storage::disk('exam')->delete($exam->name_briefly);
                        Storage::disk('exam')->put($exam_file_name, File::get($request->file('file_exam')));

                        return redirect('lecturer/exam/my_exam/update=' . $exam->id)->with('message_success', "Đổi file đề thi thành công");
                    } else {
                        return redirect()->back()->with('message_notification', "Thay đổi file đề thi thất bại");
                    }
                }
            } else {
                return redirect()->back()->with('message_notification', "Bạn chưa nhập file đề thi");
            }

        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * display view for update explain file of exam
     *
     * @param $id_exam
     * @return $this|\Exception|\Illuminate\Http\RedirectResponse
     */
    public function get_update_explain_file($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_one_exam_for_modification($id_exam);
            if (is_null($exam)) {
                return redirect()->back()->with('message_notification', "Đề thi này không được phép sửa");
            } else {
                return view('lecturer.exam.my_exam.update_explain')
                    ->with('exam', $exam);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * update explain file for exam by id_exam
     *
     * @param Request $request
     * @param $id_exam
     * @return \Illuminate\Http\RedirectResponse
     */
    public function post_update_explain_file(Request $request, $id_exam)
    {
        try{
            $exam = $this->_db_exam->get_one_exam_for_modification($id_exam);
            if (is_null($exam)) {
                return redirect()->back()->with('message_notification', "Đề thi này không được phép sửa");
            }
            if ($request->hasFile('file_explain')) {
                $explain_file_name = $this->check_file($request['file_explain']);
                if ($explain_file_name == 0) {
                    return redirect()->back()->with('message_notification', "File giải thích chỉ nhận file word or pdf");
                } elseif ($explain_file_name == 1) {
                    return redirect()->back()->with('message_notification', "Kích thước file giải thích vượt quá 4MB");
                } else {
                    $rs = $this->_db_exam->update_explain_file($id_exam, $explain_file_name);
                    if (is_numeric($rs) && $rs == 1) {
                        Storage::disk('explain')->delete($exam->explain_file_name);
                        Storage::disk('explain')->put($explain_file_name, File::get($request->file('file_explain')));

                        return redirect('lecturer/exam/my_exam/update=' . $exam->id)->with('message_success', "Đổi file giải thích thành công");
                    } else {
                        return redirect()->back()->with('message_notification', "Chưa thay đổi file giải thích");
                    }
                }
            } else {
                return redirect()->back()->with('message_notification', "Bạn chưa nhập file giải thích");
            }
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * display view for update exam info by id_exam
     * @param $id_exam
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function get_update_exam_info($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_one_exam_for_modification($id_exam);
            if (is_null($exam)) {
                return redirect()->back()->with('message_notification', "Đề thi này không được phép sửa");
            } else {
                $class_room = TblClassRoom::all();
                $subject = TblSubject::all();
                $level = TblLevel::all();

                return view('lecturer.exam.my_exam.update_exam_info')
                    ->with('class_room', $class_room)
                    ->with('subject', $subject)
                    ->with('level', $level)
                    ->with('exam', $exam);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * update exam info by id_exam
     * @param Request $request
     * @param $id_exam
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_update_exam_info(Request $request, $id_exam)
    {
        try {
            $exam = $this->_db_exam->get_one_exam_for_modification($id_exam);
            if (is_null($exam)) {
                return redirect('lecturer/home')->with('message_notification', "Đề thi này không được phép sửa");
            }
            $image = $exam->image;
            if($request->hasFile('img_exam')){
                Storage::disk('exam_image')->delete($image);
                $image = Uuid::uuid4(). ".". $request->file('img_exam')->getClientOriginalExtension();
                Storage::disk('exam_image')->put($image, File::get($request->file('img_exam')));
            }
            $rs = $this->_db_exam->update_exam_info($id_exam, $request, $image);
            if (is_numeric($rs) && $rs == 1) {
                return redirect('lecturer/exam/my_exam/update=' . $exam->id)->with('message_success', "Thay đổi thông tin đề thi thành công");
            } else {
                return redirect('lecturer/exam/my_exam/update=' . $exam->id)->with('message_notification', "Thông tin đề thi chưa được thay đổi");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * display view for list answer modification
     *
     * @param $id_exam
     * @return $this|\Exception|\Illuminate\Http\RedirectResponse
     */
    public function get_update_list_answer($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_one_exam_for_modification($id_exam);
            if (is_null($exam)) {
                return redirect()->back()->with('message_notification', "Đề thi này không được phép sửa");
            } elseif (is_null($exam->list_answer)) {
                return redirect()->back()->with('message_notification', "Đề thi này chưa nhập đáp án");
            } else {
                $list_answer = json_decode($exam->list_answer);
                return view('lecturer.exam.my_exam.update_list_answer')
                    ->with('exam', $exam)
                    ->with('list_answer', $list_answer);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * update list answer for exam of lecturer
     *
     * @param Request $request
     * @param $id_exam
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_update_list_answer(Request $request, $id_exam)
    {
        try {
            $exam = $this->_db_exam->get_one_exam_for_modification($id_exam);
            if (is_null($exam)) {
                return redirect()->back()->with('message_notification', "Đề thi này không được phép sửa");
            }
            $number_of_questions = $exam->number_of_questions;
            $list_answer = [];
            for ($index = 1; $index <= $number_of_questions; $index++) {
                $answer = $request[$index];
                if ($answer <= 4 && $answer >= 1) {
                    $list_answer[] = [
                        'stt' => $index,
                        'answer' => $answer
                    ];
                } else {
                    return redirect()->back()->with('message_notification', "Nhập đáp án không đúng định dạng. Nhập lại");
                }
            }
            $list_answer_json = json_encode($list_answer);
            $result = $this->_db_exam->update_list_answer($id_exam, $list_answer_json);
            if (is_numeric($result)) {
                return redirect('lecturer/exam/my_exam/update=' . $exam->id)
                    ->with('message_success', "Lưu đáp án thành công");
            }
            return redirect()->back()->with('message_notification', "Lưu đáp án thất bại");
        } catch (\Exception $ex) {
            return $ex;
        }
    }

//-------------------------------------- save this lecturer's exam------------------------------------------------------

    /**
     * save my exam to web
     *
     * @param $id_exam
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function save_my_exam_to_web($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_a_my_exam_file($id_exam);
            if ($exam->status == EXAM_HAVE_ANSWER) {

                $rs = $this->_db_exam->save_exam_to_web($id_exam);
                if (is_numeric($rs)) {
                    return redirect('lecturer/exam/my_exam/web/list=%20')
                        ->with('message_success', "Duyệt đề thi thành công");
                } else {
                    return redirect('lecturer/exam/my_exam/have_answer/list=%20')
                        ->with('message_notification', "Duyệt đề thi thất bại");
                }
            } else {
                return redirect('lecturer/exam/my_exam/have_answer/list=%20')
                    ->with('message_notification', "Đề thi này không thể duyệt lên web");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * save my exam to repository
     *
     * @param $id_exam
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function save_my_exam_to_repository($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_a_my_exam_file($id_exam);
            if ($exam->status == EXAM_HAVE_ANSWER) {

                $rs = $this->_db_exam->save_exam_to_repository($id_exam);
                if (is_numeric($rs)) {
                    return redirect('lecturer/exam/my_exam/repository/list=%20')
                        ->with('message_success', "Duyệt đề thi thành công");
                } else {
                    return redirect('lecturer/exam/my_exam/have_answer/list=%20')
                        ->with('message_notification', "Duyệt đề thi thất bại");
                }
            } else {
                return redirect('lecturer/exam/exam/my_exam/have_answer/list=%20')
                    ->with('message_notification', "Đề thi này không thể duyệt vào kho đề");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

//-------------------------------------- show exam of this lecturer ----------------------------------------------------

    /**
     * display my exam on web or in repository
     *
     * @param $id_exam
     * @return $this|\Exception|\Illuminate\Http\RedirectResponse
     */
    public function get_detail_my_exam_complete($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_a_my_exam_file($id_exam);
            if (is_null($exam)) {
                return redirect()->back()->with('message_notification', "Đề thi không phải của bạn");
            } else {
                if ($exam->status != EXAM_NOT_ANSWER) {

                    $list_answer = json_decode($exam->list_answer);
                    return view('lecturer.exam.my_exam.watch_detail')
                        ->with('exam', $exam)
                        ->with('list_answer', $list_answer);
                } else {
                    return redirect()->back()
                        ->with('message_notification', "Đề thi này không trong số đề thi cần chỉnh sửa");
                }
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * show my exam haven't been answer
     *
     * @param $txt_search
     * @return \Exception
     */
    public function get_my_exam_not_answer($txt_search)
    {
        try {
            try {
                $page = Input::get('page');
                if ($page < 1) {
                    $page = 1;
                }
                $start = ($page - 1) * SystemStringParameter::PER_PAGE_EXAM();
                $name = trim($txt_search, " ");
                $data = $this->_db_exam->get_my_exam_not_answer($name);
                $count = count($data->get());
                $data_send = $data->paginate(SystemStringParameter::PER_PAGE_EXAM());

                return view('lecturer.exam.my_exam.exam_not_answer.list_exam')
                    ->with('data', $data_send)
                    ->with('start', $start)
                    ->with('count', $count)
                    ->with('search_old', $name);
            } catch (\Exception $ex) {
                return $ex;
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * find exam not answer in this lecturer's exam not answer
     *
     * @param Request $request
     * @param $txt_search
     * @return \Exception|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post_my_exam_not_answer(Request $request, $txt_search)
    {
        try {
            $name = trim($request['txt_search'], " ");
            if ($name == "") {
                return redirect('lecturer/exam/my_exam/not_answer/list=%20')
                    ->with('message_notification', "Bạn vừa nhập vào một khoảng trắng");
            } else {
                return redirect('lecturer/exam/my_exam/not_answer/list=' . $name);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * show my exam have been answer
     *
     * @param $txt_search
     * @return \Exception
     */
    public function get_my_exam_have_answer($txt_search)
    {
        try {
            try {
                $page = Input::get('page');
                if ($page < 1) {
                    $page = 1;
                }
                $start = ($page - 1) * SystemStringParameter::PER_PAGE_EXAM();
                $name = trim($txt_search, " ");
                $data = $this->_db_exam->get_my_exam_have_answer($name);
                $count = count($data->get());
                $data_send = $data->paginate(SystemStringParameter::PER_PAGE_EXAM());

                return view('lecturer.exam.my_exam.exam_have_answer.list_exam')
                    ->with('data', $data_send)
                    ->with('start', $start)
                    ->with('count', $count)
                    ->with('search_old', $name);
            } catch (\Exception $ex) {
                return $ex;
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * find exam have answer in this lecturer's exam have answer
     *
     * @param Request $request
     * @param $txt_search
     * @return \Exception|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post_my_exam_have_answer(Request $request, $txt_search)
    {
        try {
            $name = trim($request['txt_search'], " ");
            if ($name == "") {
                return redirect('lecturer/exam/my_exam/have_answer/list=%20')
                    ->with('message_notification', "Bạn vừa nhập vào một khoảng trắng");
            } else {
                return redirect('lecturer/exam/my_exam/have_answer/list=' . $name);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * show my exam on web
     *
     * @param $txt_search
     * @return \Exception
     */
    public function get_my_exam_on_web($txt_search)
    {
        try {
            try {
                $page = Input::get('page');
                if ($page < 1) {
                    $page = 1;
                }
                $start = ($page - 1) * SystemStringParameter::PER_PAGE_EXAM();
                $name = trim($txt_search, " ");
                $data = $this->_db_exam->get_my_exam_on_web($name);
                $count = count($data->get());
                $data_send = $data->paginate(SystemStringParameter::PER_PAGE_EXAM());

                return view('lecturer.exam.my_exam.exam_on_web.list_exam')
                    ->with('data', $data_send)
                    ->with('start', $start)
                    ->with('count', $count)
                    ->with('search_old', $name);
            } catch (\Exception $ex) {
                return $ex;
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * find exam on web in this lecturer's exam on web
     *
     * @param Request $request
     * @param $txt_search
     * @return \Exception|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post_my_exam_on_web(Request $request, $txt_search)
    {
        try {
            $name = trim($request['txt_search'], " ");
            if ($name == "") {
                return redirect('lecturer/exam/my_exam/web/list=%20')
                    ->with('message_notification', "Bạn vừa nhập vào một khoảng trắng");
            } else {
                return redirect('lecturer/exam/my_exam/web/list=' . $name);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * show my exam in repository
     *
     * @param $txt_search
     * @return \Exception
     */
    public function get_my_exam_in_repository($txt_search)
    {
        try {
            try {
                $page = Input::get('page');
                if ($page < 1) {
                    $page = 1;
                }
                $start = ($page - 1) * SystemStringParameter::PER_PAGE_EXAM();
                $name = trim($txt_search, " ");
                $data = $this->_db_exam->get_my_exam_in_repository($name);
                $count = count($data->get());
                $data_send = $data->paginate(SystemStringParameter::PER_PAGE_EXAM());

                return view('lecturer.exam.my_exam.exam_in_repository.list_exam')
                    ->with('data', $data_send)
                    ->with('start', $start)
                    ->with('count', $count)
                    ->with('search_old', $name);
            } catch (\Exception $ex) {
                return $ex;
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * find exam in repository in this lecturer's exam in repository
     *
     * @param Request $request
     * @param $txt_search
     * @return \Exception|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post_my_exam_in_repository(Request $request, $txt_search)
    {
        try {
            $name = trim($request['txt_search'], " ");
            if ($name == "") {
                return redirect('lecturer/exam/my_exam/repository/list=%20')
                    ->with('message_notification', "Bạn vừa nhập vào một khoảng trắng");
            } else {
                return redirect('lecturer/exam/my_exam/repository/list=' . $name);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

//--------------------------------------- show exam of all ctv----------------------------------------------------------

    /**
     * get exams are waiting approve into web of all this lecturer's ctv
     *
     * @param $txt_search
     * @return \Exception
     */
    public function get_waiting_approve($txt_search)
    {
        try {
            $page = Input::get('page');
            if ($page < 1) {
                $page = 1;
            }
            $start = ($page - 1) * SystemStringParameter::PER_PAGE_EXAM();
            $name = trim($txt_search, " ");
            $data = $this->_db_exam->exam_waiting_approve($name);
            $count = count($data->get());
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_EXAM());

            return view('lecturer.exam.exam_waiting_approve.list_exam')
                ->with('data', $data_send)
                ->with('start', $start)
                ->with('count', $count)
                ->with('search_old', $name);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * find exams are waiting approve into web by keyword of all this lecturer's ctv
     *
     * @param Request $request
     * @param $txt_search
     * @return \Exception|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post_waiting_approve(Request $request, $txt_search)
    {
        try {
            $name = trim($request['txt_search'], " ");
            if ($name == "") {
                return redirect('lecturer/exam/exam_waiting_approve/list_web=%20')
                    ->with('message_notification', "Bạn vừa nhập vào một khoảng trắng");
            } else {
                return redirect('lecturer/exam/exam_waiting_approve/list_web=' . $name);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * get exams are waiting approve into repository of all this lecturer's ctv
     *
     * @param $txt_search
     * @return \Exception
     */
    public function get_approve_to_repository($txt_search)
    {
        try {
            $page = Input::get('page');
            if ($page < 1) {
                $page = 1;
            }
            $start = ($page - 1) * SystemStringParameter::PER_PAGE_EXAM();
            $name = trim($txt_search, " ");
            $data = $this->_db_exam->exam_waiting_approve_to_repository($name);
            $count = count($data->get());
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_EXAM());

            return view('lecturer.exam.exam_waiting_to_repository.list_exam')
                ->with('data', $data_send)
                ->with('start', $start)
                ->with('count', $count)
                ->with('search_old', $name);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * find exams are waiting approve into repository by keyword of all this lecturer's ctv
     *
     * @param Request $request
     * @param $txt_search
     * @return \Exception|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post_approve_to_repository(Request $request, $txt_search)
    {
        try {
            $name = trim($request['txt_search'], " ");
            if ($name == "") {
                return redirect('lecturer/exam/exam_waiting_approve/list_repository=%20')
                    ->with('message_notification', "Bạn vừa nhập vào một khoảng trắng");
            } else {
                return redirect('lecturer/exam/exam_waiting_approve/list_repository=' . $name);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * show list exams approved at repository of all this lecturer's ctv
     *
     * @param $txt_search
     * @return \Exception
     */
    public function get_exam_in_repository($txt_search)
    {
        try {
            $page = Input::get('page');
            if ($page < 1) {
                $page = 1;
            }
            $start = ($page - 1) * SystemStringParameter::PER_PAGE_EXAM();
            $name = trim($txt_search, " ");
            $data = $this->_db_exam->exam_approved_to_repository($name);
            $count = count($data->get());
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_EXAM());

            return view('lecturer.exam.exam_approved_repository.list_exam')
                ->with('data', $data_send)
                ->with('start', $start)
                ->with('count', $count)
                ->with('search_old', $name);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * find exams have been approved at repository of all this lecturer's ctv
     *
     * @param Request $request
     * @param $txt_search
     * @return \Exception|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post_exam_in_repository(Request $request, $txt_search)
    {
        try {
            $name = trim($request['txt_search'], " ");
            if ($name == "") {
                return redirect('lecturer/exam/exam_approved_repository/list=%20')
                    ->with('message_notification', "Bạn vừa nhập vào khoảng trắng");
            } else {
                return redirect('lecturer/exam/exam_approved_repository/list=' . $name);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * show list exams have been approved on web of all this lecturer's ctv
     *
     * @param $txt_search
     * @return \Exception
     */
    public function get_exam_on_web($txt_search)
    {
        try {
            $page = Input::get('page');
            if ($page < 1) {
                $page = 1;
            }
            $start = ($page - 1) * SystemStringParameter::PER_PAGE_EXAM();
            $name = trim($txt_search, " ");
            $data = $this->_db_exam->exam_approved_to_web($name);
            $count = count($data->get());
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_EXAM());

            return view('lecturer.exam.exam_approved_web.list_exam')
                ->with('data', $data_send)
                ->with('start', $start)
                ->with('count', $count)
                ->with('search_old', $name);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * find exams have been approved on web of all this lecturer's ctv
     *
     * @param Request $request
     * @param $txt_search
     * @return \Exception|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post_exam_on_web(Request $request, $txt_search)
    {
        try {
            $name = trim($request['txt_search'], " ");
            if ($name == "") {
                return redirect('lecturer/exam/exam_approved_web/list=%20')
                    ->with('message_notification', "Bạn vừa nhập vào khoảng trắng");
            } else {
                return redirect('lecturer/exam/exam_approved_web/list=' . $name);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * display exams need
     *
     * @param $txt_search
     * @return \Exception
     */
    public function get_exam_need_modify($txt_search)
    {
        try {
            $page = Input::get('page');
            if ($page < 1) {
                $page = 1;
            }
            $start = ($page - 1) * SystemStringParameter::PER_PAGE_EXAM();
            $name = trim($txt_search, " ");
            $data = $this->_db_exam->exam_need_modify($name);
            $count = count($data->get());
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_EXAM());

            return view('lecturer.exam.exam_need_modify.list_exam')
                ->with('data', $data_send)
                ->with('start', $start)
                ->with('count', $count)
                ->with('search_old', $name);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * find exams have been approved on web of all this lecturer's ctv
     *
     * @param Request $request
     * @param $txt_search
     * @return \Exception|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post_exam_need_modify(Request $request, $txt_search)
    {
        try {
            $name = trim($request['txt_search'], " ");
            if ($name == "") {
                return redirect('lecturer/exam/exam_need_modify/list=%20')
                    ->with('message_notification', "Bạn vừa nhập vào khoảng trắng");
            } else {
                return redirect('lecturer/exam/exam_need_modify/list=' . $name);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
//------------------------------------------ watch detail exam -------------------------------------------------

    /**
     * display detail of exam is waiting approve
     *
     * @param $id_exam
     * @return $this|\Exception|\Illuminate\Http\RedirectResponse
     */
    public function detail_exam_waiting($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_a_exam_file($id_exam);
            if (is_null($exam)) {
                return redirect()->back()
                    ->with('message_notification', "Bạn không được phép xem đề thi này");
            } else {
                if ($exam->request_approve == REQUEST_APPROVE &&
                    $exam->status == EXAM_WAITING_APPROVE) {

                    $list_answer = json_decode($exam->list_answer);
                    return view('lecturer.exam.watch_detail')
                        ->with('exam', $exam)
                        ->with('list_answer', $list_answer);
                } else {
                    return redirect()->back()
                        ->with('message_notification', "Đề thi này không nằm trong số đề thi đang đợi duyệt");
                }
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * display exam need modify by id_exam
     *
     * @param $id_exam
     * @return $this|\Exception|\Illuminate\Http\RedirectResponse
     */
    public function get_detail_exam_need_modify($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_a_exam_file($id_exam);
            if (is_null($exam)) {
                if ($exam->status == EXAM_NEED_MODIFY) {

                    $list_answer = json_decode($exam->list_answer);
                    return view('lecturer.exam.watch_detail')
                        ->with('exam', $exam)
                        ->with('list_answer', $list_answer);
                } else {
                    return redirect()->back()
                        ->with('message_notification', "Đề thi này không trong số đề thi cần chỉnh sửa");
                }
            } else {
                return redirect()->back()
                    ->with('message_notification', "Đề thi không thuộc đề thi đang đợi duyệt");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * display detail of exam approved
     *
     * @param $id_exam
     * @return $this|\Exception|\Illuminate\Http\RedirectResponse
     */
    public function get_detail_a_exam_approved($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_a_exam_file($id_exam);
            if (count($exam) > 0) {
                if ($exam->request_approve == REQUEST_END) {

                    $list_answer = json_decode($exam->list_answer);
                    return view('lecturer.exam.watch_detail')
                        ->with('exam', $exam)
                        ->with('list_answer', $list_answer);
                } else {
                    return redirect()->back()
                        ->with('message_notification', "Đề thi này không trong số đề thi đã đuọc duyệt");
                }
            } else {
                return redirect()->back()->with('message_notification', "Đề thi không tồn tại");
            }

        } catch (\Exception $ex) {
            return $ex;
        }
    }


//------------------------------------- approve exam -----------------------------------------------------------

    /**
     * approve exam to web
     *
     * @param $id_exam
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function approve_exam_to_web($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_a_exam_file($id_exam);
            if (is_null($exam)) {
                return redirect()->back()->with('message_notification', "Đề thi này không thuộc về bạn");
            }
            if ($exam->request_approve == REQUEST_APPROVE &&
                $exam->status == EXAM_WAITING_APPROVE) {

                $rs = $this->_db_exam->save_exam_to_web($id_exam);
                if (is_numeric($rs)) {
                    return redirect('lecturer/exam/exam_approved_web/list=%20')
                        ->with('message_success', "Duyệt đề thi thành công");
                } else {
                    return redirect()->back()
                        ->with('message_notification', "Duyệt đề thi thất bại");
                }
            } else {
                return redirect()->back()
                    ->with('message_notification', "Không thể duyệt đề thi này");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * approve exam to repository
     *
     * @param $id_exam
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function approve_exam_to_repository($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_a_exam_file($id_exam);
            if (is_null($exam)) {
                return redirect()->back()->with('message_notification', "Đề thi này không thuộc về bạn");
            }
            if ($exam->request_approve == REQUEST_APPROVE &&
                $exam->status == EXAM_WAITING_APPROVE) {

                $rs = $this->_db_exam->save_exam_to_repository($id_exam);
                if (is_numeric($rs)) {
                    return redirect('lecturer/exam/exam_approved_repository/list=%20')
                        ->with('message_success', "Duyệt đề thi thành công");
                } else {
                    return redirect()->back()
                        ->with('message_notification', "Duyệt đề thi thất bại");
                }
            } else {
                return redirect()->back()
                    ->with('message_notification', "Không thể duyệt đề thi này");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

//-----------------------------------------send request modify for exam --------------------------------------------

    /**
     * display view for send request modify exam of lecturer
     *
     * @param $id_exam
     * @return $this|\Exception|\Illuminate\Http\RedirectResponse
     */
    public function get_send_request_modify($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_a_exam_file($id_exam);
            if (count($exam) > 0) {
                if ($exam->status == EXAM_WAITING_APPROVE ||
                    $exam->status == EXAM_NEED_MODIFY) {

                    $list_answer = json_decode($exam->list_answer);
                    return view('lecturer.exam.comment_for_exam.create_comment')
                        ->with('exam', $exam)
                        ->with('list_answer', $list_answer);
                } else {
                    return redirect()->back()
                        ->with('message_notification', "Đề thi này không trong số đề thi đợi duyệt vào kho đề");
                }
            } else {
                return redirect()->back()->with('message_notification', "Đề thi không phải của bạn");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * save request modify of lecturer
     *
     * @param Request $request
     * @param $id_exam
     * @return $this|\Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_send_request_modify(Request $request, $id_exam)
    {
        try {
            $exam = $this->_db_exam->get_a_exam_file($id_exam);
            if (count($exam) > 0) {
                if ($exam->status == EXAM_WAITING_APPROVE ||
                    $exam->status == EXAM_NEED_MODIFY) {

                    $comment = trim($request['ta_comment'], " ");
                    if ($comment == "" || strlen($comment) >= 250) {
                        return redirect()->back()->with('message_notification', "Comment không phù hợp");
                    }
                    $rs = $this->_db_exam->save_comment_for_exam($id_exam, $comment);
                    if (!is_numeric($rs)) {
                        //change exam to modify exam
                        $this->_db_exam->save_exam_need_modify($id_exam);
                        return redirect('lecturer/exam/exam_need_modify/list=%20')
                            ->with('message_success', "Viết comment thành công");
                    } else {
                        return redirect('lecturer/home')->with('message_notification', "Viết comment thất bại");
                    }
                } else {
                    return redirect()->back()
                        ->with('message_notification', "Đề thi này không trong số đề thi đợi duyệt vào kho đề");
                }
            } else {
                return redirect()->back()->with('message_notification', "Đề thi không phải của bạn");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * display list of comment of a exam
     *
     * @param $id_exam
     * @return \Exception
     */
    public function get_list_comment_of_exam($id_exam)
    {
        try {
            $page = Input::get('page');
            if ($page < 1) {
                $page = 1;
            }
            $start = ($page - 1) * SystemStringParameter::PER_PAGE_COMMENT();
            $comment = $this->_db_exam->get_list_comment_of_exam($id_exam);
            $count = count($comment->get());
            $comment_send = $comment->paginate(SystemStringParameter::PER_PAGE_COMMENT());
            $exam = $this->_db_exam->get_a_exam_file($id_exam);
            return view('lecturer.exam.comment_for_exam.list_comment')
                ->with('comment', $comment_send)
                ->with('exam', $exam)
                ->with('count', $count)
                ->with('start', $start);

        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     *watch detail comment of 1 exam
     *
     * @param $id_exam
     * @return $this|\Exception|\Illuminate\Http\RedirectResponse
     */
    public function get_detail_comment_of_exam($id_comment)
    {
        try {
            $comment = $this->_db_exam->get_a_comment($id_comment);
            $id_exam = $comment->id_exam;
            $exam = $this->_db_exam->get_a_exam_file($id_exam);
            if (count($exam) > 0) {
                if ($exam->status == EXAM_NEED_MODIFY) {

                    $list_answer = json_decode($exam->list_answer);

                    return view('lecturer.exam.comment_for_exam.comment_detail')
                        ->with('exam', $exam)
                        ->with('list_answer', $list_answer)
                        ->with('comment', $comment);
                } else {
                    return redirect()->back()
                        ->with('message_notification', "Đề thi này không trong số đề thi đợi duyệt vào kho đề");
                }
            } else {
                return redirect()->back()->with('message_notification', "Đề thi không phải của bạn");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * update comment
     *
     * @param Request $request
     * @param $id_comment
     * @return \Exception|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update_comment(Request $request, $id_comment)
    {
        try {
            $comment_new = $request['ta_comment'];
            $comment_old = $this->_db_exam->get_a_comment($id_comment);
            $id_exam = $comment_old->id_exam;
            if (strcmp($comment_new, $comment_old->comment) == 0) {
                return redirect()->back()->with('message_notification', "Comment chưa được thay đổi");
            } else {
                $rs = $this->_db_exam->update_comment($id_comment, $comment_new);
                if (is_numeric($rs) && $rs == 1) {
                    return redirect('lecturer/exam/exam_need_modify/comment_exam=' . $id_exam)
                        ->with('message_success', "Cập nhật comment thành công");
                } else {
                    return redirect('notification', "Cập nhật comment thất bại");
                }
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}
