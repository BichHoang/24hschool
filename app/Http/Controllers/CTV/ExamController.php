<?php

namespace App\Http\Controllers\CTV;

use App\DAO\DaoCTV\CTVExamDao;
use App\Http\System\Convert;
use App\Http\System\StringRandom;
use App\Http\System\SystemStringParameter;
use App\TblClassRoom;
use App\TblExam;
use App\TblLevel;
use App\TblSubject;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use File;

class ExamController extends Controller
{

    private $_db_exam;

    /**
     * create a new instance of ExcamController of ctv
     *
     * ExamController constructor.
     */
    public function __construct()
    {
        $this->_db_exam = new CTVExamDao();
    }

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

            return view('ctv.exam.upload_exam')
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
                            $rs_db = $this->_db_exam
                                ->upload_exam_and_explain($request, $exam_file_name, $explain_file_name);
                            if ($rs_db) {
                                $rs_exam = Storage::disk('exam')
                                    ->put($exam_file_name, File::get($request->file('file_exam')));
                                $rs_explain = Storage::disk('explain')
                                    ->put($explain_file_name, File::get($request->file('file_explain')));
                                if (isset($request['save'])) {
                                    return redirect('ctv/exam/not_answer/list=%20')
                                        ->with('message_success', "Tải đề thi và giải thích lên thành công");
                                } elseif (isset($request['enter_answer'])) {
                                    return redirect('ctv/exam/not_answer/enter_answer=' . $rs_db)
                                        ->with('message_success', "Tải đề thi và giải thích lên thành công");
                                } else {
                                    return redirect()->back()->with('message_notification', "Tạo đề thi thất bại");
                                }

                            } else {
                                return redirect('ctv/exam/not_answer/list=%20')
                                    ->with('message_notification', "Không thể nhập đáp án vào lúc này");
                            }
                        }
                    } else {
                        return redirect()->back()->with('message_notification', "Bạn chưa nhập file giải thích");
                    }
                }
            } else {
                return redirect()->back()->with('message_notification', "Bạn chưa nhập file đề thi");
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
            if ($file_size > (1024 << 2)) {
                return 1;//return "Kích thước file đã vượt quá 4MB"
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

    //----------------------------------------- update exam ------------------------------------------------------------

    /**
     * display view for ctv choose exam modification ways
     *
     * @param $id_exam
     * @return $this|\Exception|\Illuminate\Http\RedirectResponse
     */
    public function get_update_view($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_one_exam_for_modification($id_exam);
            if (is_null($exam)) {
                return redirect()->back()->with('message_notification', "Đề thi này không được phép chỉnh sửa");
            }
            return view('ctv.exam.update.choose_update')
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
                return redirect()->back()->with('message_notification', "Đề thi này không được phép chỉnh sửa");
            } else {
                return view('ctv.exam.update.update_exam')
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
                return redirect()->back()->with('message_notification', "Đề thi này không được phép chỉnh sửa");
            }
            if ($request->hasFile('file_exam')) {
                $exam_file_name = $this->check_file($request['file_exam']);
                if ($exam_file_name == 0) {
                    return redirect()->back()->with('message_notification', "File đề thi chỉ nhận file word or pdf");
                } elseif ($exam_file_name == 1) {
                    return redirect()->back()->with('message_notification', "Kích thước file đề thi vượt quá 4MB");
                } else {
                    $rs = $this->_db_exam->update_exam_file($id_exam, $exam_file_name);
                    if (is_numeric($rs) && $rs == 1) {
                        Storage::disk('exam')->delete($exam->name_briefly);
                        Storage::disk('exam')->put($exam_file_name, File::get($request->file('file_exam')));

                        return redirect('ctv/exam/update=' . $exam->id)->with('message_success', "Đổi file đề thi thành công");
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
                return redirect()->back()->with('message_notification', "Đề thi này không được phép chỉnh sửa");
            } else {
                return view('ctv.exam.update.update_explain')
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
        $exam = $this->_db_exam->get_one_exam_for_modification($id_exam);
        if (is_null($exam)) {
            return redirect()->back()->with('message_notification', "Đề thi này không được phép chỉnh sửa");
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

                    return redirect('ctv/exam/update=' . $exam->id)->with('message_success', "Đổi file giải thích thành công");
                } else {
                    return redirect()->back()->with('message_notification', "Chưa thay đổi file giải thích");
                }
            }
        } else {
            return redirect()->back()->with('message_notification', "Bạn chưa nhập file giải thích");
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
                return redirect()->back()->with('message_notification', "Đề thi này không được phép chỉnh sửa");
            } else {
                $class_room = TblClassRoom::all();
                $subject = TblSubject::all();
                $level = TblLevel::all();

                return view('ctv.exam.update.update_exam_info')
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
                return redirect('ctv/home')->with('message_notification', "Đề thi này không được phép chỉnh sửa");
            }
            $rs = $this->_db_exam->update_exam_info($id_exam, $request);
            if (is_numeric($rs) && $rs == 1) {
                return redirect('ctv/exam/update=' . $exam->id)->with('message_success', "Thay đổi thông tin đề thi thành công");
            } else {
                return redirect('ctv/exam/update=' . $exam->id)->with('message_notification', "Thông tin đề thi chưa được thay đổi");
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
                return redirect()->back()->with('message_notification', "Đề thi này không được phép chỉnh sửa");
            } elseif (is_null($exam->list_answer)) {
                return redirect()->back()->with('message_notification', "Đề thi này chưa nhập đáp án");
            } else {
                $list_answer = json_decode($exam->list_answer);
                return view('ctv.exam.update.update_list_answer')
                    ->with('exam', $exam)
                    ->with('list_answer', $list_answer);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * update list answer for exam of ctv
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
                return redirect()->back()->with('message_notification', "Đề thi này không được phép chỉnh sửa");
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
                return redirect('ctv/exam/update=' . $exam->id)
                    ->with('message_success', "Lưu đáp án thành công");
            }
            return redirect()->back()->with('message_notification', "Lưu đáp án thất bại");
        } catch (\Exception $ex) {
            return $ex;
        }
    }


//-------------------------------------- show exam -----------------------------------------------------------------


    /**
     * display list exam haven't been answer
     *
     * @param $txt_seach
     * @return \Exception
     */
    public function get_exam_not_answer($txt_seach)
    {
        try {
            $page = Input::get('page');
            if ($page < 1) {
                $page = 1;
            }
            $start = ($page - 1) * SystemStringParameter::PER_PAGE_EXAM();
            $name = trim($txt_seach, " ");
            $data = $this->_db_exam->get_list_exam_not_answer($name);
            $count = count($data->get());
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_EXAM());

            return view('ctv.exam.exam_not_answer.list_exam')
                ->with('data', $data_send)
                ->with('start', $start)
                ->with('count', $count)
                ->with('search_old', $name);

        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * find exam haven't been answer with keyword of ctv
     *
     * @param Request $request
     * @param $txt_search
     * @return \Exception|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post_exam_not_answer(Request $request, $txt_search)
    {
        try {
            $name = trim($request['txt_search'], " ");
            if ($name == "") {
                return redirect('ctv/exam/not_answer/list=%20')
                    ->with('message_notification', "Bạn vừa nhập vào khoảng trắng");
            } else {
                return redirect('ctv/exam/not_answer/list=' . $name);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * display list exam have answer
     *
     * @param $txt_seach
     * @return \Exception
     */
    public function get_exam_have_answer($txt_search)
    {
        try {
            $page = Input::get('page');
            if ($page < 1) {
                $page = 1;
            }
            $start = ($page - 1) * SystemStringParameter::PER_PAGE_EXAM();
            $name = trim($txt_search, " ");
            $data = $this->_db_exam->get_list_exam_have_answer($name);
            $count = count($data->get());
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_EXAM());

            return view('ctv.exam.exam_have_answer.list_exam')
                ->with('data', $data_send)
                ->with('start', $start)
                ->with('count', $count)
                ->with('search_old', $name);

        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * find exam have answer with keyword of ctv
     *
     * @param Request $request
     * @param $txt_search
     * @return \Exception|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post_exam_have_answer(Request $request, $txt_search)
    {
        try {
            $name = trim($request['txt_search'], " ");
            if ($name == "") {
                return redirect('ctv/exam/have_answer/list=%20')
                    ->with('message_notification', "Bạn vừa nhập vào khoảng trắng");
            } else {
                return redirect('ctv/exam/have_answer/list=' . $name);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * show list exam is waiting approve
     *
     * @param $txt_search
     * @return \Exception
     */
    public function get_exam_waiting_approve($txt_search)
    {
        try {
            $page = Input::get('page');
            if ($page < 1) {
                $page = 1;
            }
            $start = ($page - 1) * SystemStringParameter::PER_PAGE_EXAM();
            $name = trim($txt_search, " ");
            $data = $this->_db_exam->get_list_exam_waiting_approve($name);
            $count = count($data->get());
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_EXAM());

            return view('ctv.exam.exam_waiting_approve.list_exam')
                ->with('data', $data_send)
                ->with('start', $start)
                ->with('count', $count)
                ->with('search_old', $name);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * find exam is waiting approve
     *
     * @param Request $request
     * @param $txt_search
     * @return \Exception|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post_exam_waiting_approve(Request $request, $txt_search)
    {
        try {
            $name = trim($request['txt_search'], " ");
            if ($name == "") {
                return redirect('ctv/exam/waiting_approve/list=%20')
                    ->with('message_notification', "Bạn vừa nhập vào khoảng trắng");
            } else {
                return redirect('ctv/exam/waiting_approve/list=' . $name);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * show list exam has been approved on web
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
            $data = $this->_db_exam->get_exam_on_web($name);
            $count = count($data->get());
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_EXAM());

            return view('ctv.exam.exam_approved.list_exam')
                ->with('data', $data_send)
                ->with('start', $start)
                ->with('count', $count)
                ->with('search_old', $name);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * find exam has been approved on web
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
                return redirect('ctv/exam/web/list=%20')
                    ->with('message_notification', "Bạn vừa nhập vào khoảng trắng");
            } else {
                return redirect('ctv/exam/web/list=' . $name);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * show list exam has been approved in repository
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
            $data = $this->_db_exam->get_exam_in_repository($name);
            $count = count($data->get());
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_EXAM());

            return view('ctv.exam.exam_approved.list_exam')
                ->with('data', $data_send)
                ->with('start', $start)
                ->with('count', $count)
                ->with('search_old', $name);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * find exam has been approved in repository
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
                return redirect('ctv/exam/web/list=%20')
                    ->with('message_notification', "Bạn vừa nhập vào khoảng trắng");
            } else {
                return redirect('ctv/exam/web/list=' . $name);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * show list exam need modify
     *
     * @param $txt_search
     * @return \Exception
     */
    public function get_list_exam_need_modify($txt_search)
    {
        try {
            $page = Input::get('page');
            if ($page < 1) {
                $page = 1;
            }
            $start = ($page - 1) * SystemStringParameter::PER_PAGE_EXAM();
            $name = trim($txt_search, " ");
            $data = $this->_db_exam->get_list_exam_need_modify($name);
            $count = count($data->get());
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_EXAM());

            return view('ctv.exam.exam_need_modify.list_exam')
                ->with('data', $data_send)
                ->with('start', $start)
                ->with('count', $count)
                ->with('search_old', $name);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * find exam has been approved
     *
     * @param Request $request
     * @param $txt_search
     * @return \Exception|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post_list_exam_need_modify(Request $request, $txt_search)
    {
        try {
            $name = trim($request['txt_search'], " ");
            if ($name == "") {
                return redirect('ctv/exam/need_modify/list=%20')
                    ->with('message_notification', "Bạn vừa nhập vào khoảng trắng");
            } else {
                return redirect('ctv/exam/need_modify/list=' . $name);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

//--------------------------------- end show exam ------------------------------------------------------------------

//--------------------------------- detail exam --------------------------------------------------------------------

    /**
     * display detail exam have answer
     *
     * @param $id_exam
     * @return $this|\Exception|\Illuminate\Http\RedirectResponse
     */
    public function detail_exam_have_answer($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_a_exam_file($id_exam);
            if (is_null($exam)) {
                return redirect()->back()->with('message_notification', "Đề thi này không phải của bạn");
            } else {
                if ($exam->status == EXAM_HAVE_ANSWER) {
                    $list_answer = json_decode($exam->list_answer);
                    return view('ctv.exam.watch_detail')
                        ->with('exam', $exam)
                        ->with('list_answer', $list_answer);
                } else {
                    return redirect()->back()
                        ->with('message_notification', "Đề thi này không thuộc đề thi đã có đáp án");
                }
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * display detail exam waiting approve
     *
     * @param $id_exam
     * @return $this|\Exception|\Illuminate\Http\RedirectResponse
     */
    public function detail_exam_waiting_approve($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_a_exam_file($id_exam);
            if (is_null($exam)) {
                return redirect()->back()->with('message_notification', "Đề thi này không phải của bạn");
            } else {
                if ($exam->status == EXAM_WAITING_APPROVE) {
                    $list_answer = json_decode($exam->list_answer);
                    return view('ctv.exam.watch_detail')
                        ->with('exam', $exam)
                        ->with('list_answer', $list_answer);
                } else {
                    return redirect()->back()
                        ->with('message_notification', "Đề thi này không thuộc đề thi đợi duyệt");
                }
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * display detail exam approved
     *
     * @param $id_exam
     * @return $this|\Exception|\Illuminate\Http\RedirectResponse
     */
    public function detail_exam_approved($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_a_exam_file($id_exam);
            if (is_null($exam)) {
                return redirect()->back()->with('message_notification', "Đề thi này không phải của bạn");
            } else {
                if ($exam->status == EXAM_APPROVED_INTO_EXAM_DIRECTORY ||
                    $exam->status == EXAM_APPROVED_INTO_WEB) {

                    $list_answer = json_decode($exam->list_answer);
                    return view('ctv.exam.watch_detail')
                        ->with('exam', $exam)
                        ->with('list_answer', $list_answer);
                } else {
                    return redirect()->back()
                        ->with('message_notification', "Đề thi này không thuộc đề thi đã được duyệt");
                }
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * display detail exam need modify
     *
     * @param $id_exam
     * @return $this|\Exception|\Illuminate\Http\RedirectResponse
     */
    public function detail_exam_need_modify($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_a_exam_file($id_exam);
            if (is_null($exam)) {
                return redirect()->back()->with('message_notification', "Đề thi này không phải của bạn");
            } else {
                if ($exam->status == EXAM_NEED_MODIFY) {

                    $list_answer = json_decode($exam->list_answer);
                    return view('ctv.exam.watch_detail')
                        ->with('exam', $exam)
                        ->with('list_answer', $list_answer);
                } else {
                    return redirect()->back()
                        ->with('message_notification', "Đề thi này không thuộc đề thi cần chỉnh sửa");
                }
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

// ---------------------------------- end detail exam --------------------------------------------------------------

    /**
     * display view for enter answer for exam hasn't been answer
     *
     * @param $id_exam
     * @return \Exception
     */
    public function get_enter_answer($id_exam)
    {
        try {
            $data = $this->_db_exam->get_a_exam_file($id_exam);
            if (is_null($data)) {
                return redirect()->back()
                    ->with('message_notification', "Đề thi này không phải của bạn");
            }
            $file_name = $data->name_briefly;
            $number_of_questions = $data->number_of_questions;
            return view('ctv.exam.exam_not_answer.enter_answer')
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
            $number_of_questions = $this->_db_exam->get_a_exam_file($id_exam)->number_of_questions;
            $list_answer = [];
            for ($index = 1; $index <= $number_of_questions; $index++) {
                $answer = $request[$index];
                if ($answer <= 4 && $answer >= 1) {
                    $list_answer[] = [
                        'stt' => $index,
                        'answer' => $answer
                    ];
                } else {
                    return redirect()->back()
                        ->with('message_notification', "Nhập đáp án không đúng định dạng. Nhập lại");
                }
            }
            $list_answer_json = json_encode($list_answer);
            $result = $this->_db_exam->save_answer($id_exam, $list_answer_json);
            if (is_numeric($result)) {
                return redirect('ctv/exam/have_answer/list=%20')
                    ->with('message_success', "Lưu đáp án thành công");
            }
            return redirect()->back()->with('message_notification', "Lưu đáp án thất bại");
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * send request approve to admin to approve
     *
     * @param $id_exam
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function send_approve_request($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_a_exam_file($id_exam);
            //kiem tra xem co phai de cua nguoi nay khong
            //kiem tra xem co duoc phep gui duyet khong
            if (is_null($exam) || $exam->status != EXAM_HAVE_ANSWER) {
                return redirect()->back()->with('message_notification', "Đề này không được phép gửi duyệt");
            }
            $rs = $this->_db_exam->send_approve_request($id_exam);
            if (is_numeric($rs) && $rs == 1) {
                return redirect('ctv/exam/waiting_approve/list=%20')
                    ->with('message_success', "Gửi yêu cầu duyệt thành công");
            } else {
                return redirect()->back()->with('message_notification', "Gửi duyệt thất bại");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * send request approve again admin to admin approve again
     *
     * @param $id_exam
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function send_approve_again($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_a_exam_file($id_exam);
            //kiem tra xem co phai de cua nguoi nay khong
            //kiem tra xem co duoc phep gui duyet khong
            if (is_null($exam) || $exam->status != EXAM_NEED_MODIFY) {
                return redirect()->back()->with('message_notification', "Đề này không được phép gửi duyệt");
            }
            $rs = $this->_db_exam->send_approve_again($id_exam);
            if (is_numeric($rs) && $rs == 1) {
                return redirect('ctv/exam/waiting_approve/list=%20')
                    ->with('message_success', "Gửi yêu cầu duyệt thành công");
            } else {
                return redirect()->back()->with('message_notification', "Gửi duyệt thất bại");
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * cancel request approve of ctv
     * @param $id_exam
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function cancel_approve_request($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_a_exam_file($id_exam);
            //kiem tra xem co phai de cua nguoi nay khong
            //kiem tra xem co phai de duoc phep huy gui duyet khong
            if (is_null($exam) || $exam->status != EXAM_WAITING_APPROVE) {
                return redirect()->back()
                    ->with('message_notification', "Đề thi này không được hủy gửi yêu cầu duyệt");
            }
            $rs = $this->_db_exam->cancel_send_approve($id_exam);
            if (is_numeric($rs)) {
                return redirect('ctv/exam/have_answer/list=%20')
                    ->with('message_success', "Hủy yêu cầu duyệt đề thi thành công");
            } else {
                return redirect()->back()
                    ->with('message_notification', "Hủy yêu cầu duyệt thất bại");
            }

        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * Delete one exam of ctv
     * @param $id_exam
     * @return \Exception|\Illuminate\Http\RedirectRespons
     */
    public function delete_exam($id_exam)
    {
        try {
            $exam = $this->_db_exam->get_a_exam_file($id_exam);
            if (is_null($exam)) {
                return redirect()->back()->with('message_notification', "Đây không phải đề thi của bạn");
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

    //------------------------------------- modify exam and comment -------------------------------------------------

    /**
     * show list comment of exam need modify
     *
     * @param $id_exam
     * @return \Exception
     */
    public function get_comment_for_exam($id_exam)
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

            return view('ctv.exam.comment_for_exam.list_comment')
                ->with('comment', $comment_send)
                ->with('exam', $exam)
                ->with('start', $start)
                ->with('count', $count);

        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * display comment with exam
     *
     * @param $id_comment
     * @return $this|\Exception|\Illuminate\Http\RedirectResponse|string
     */
    public function get_detail_comment($id_comment)
    {
        try {
            $comment = $this->_db_exam->get_detail_comment($id_comment);
            if (is_null($comment)) {
                return redirect()->back()->with('message_notification', "Comment không phải của đề thi này");
            } else {
                $id_exam = $comment->id_exam;
                $exam = $this->_db_exam->get_a_exam_file($id_exam);
                if (is_null($exam)) {
                    return redirect()->back()->with('message_notification', "Đề thi này không phải của bạn");
                } else {
                    $list_answer = json_decode($exam->list_answer);
                    return view('ctv.exam.comment_for_exam.comment_detail')
                        ->with('exam', $exam)
                        ->with('comment', $comment)
                        ->with('list_answer', $list_answer);
                }
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }


}
