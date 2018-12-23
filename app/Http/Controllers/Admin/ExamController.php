<?php

namespace App\Http\Controllers\Admin;

use App\DAO\DaoAdmin\DaoExam;
use App\Http\System\StringRandom;
use App\Http\System\SystemStringParameter;
use App\TblClassRoom;
use App\TblLevel;
use App\TblSubject;
use App\TblTopic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use File;

class ExamController extends Controller
{

    private $_db_exam;

    /**
     * create a new instance
     * ExamController constructor.
     */
    public function __construct()
    {
        $this->_db_exam = new DaoExam();
    }

    /**
     * display list exam approved
     *
     * @param $txt_search
     * @return \Exception
     */
    public function get_list_exam_approved($txt_search)
    {
        try {
            $page = Input::get('page');
            if ($page < 1) {
                $page = 1;
            }
            $start = ($page - 1) * SystemStringParameter::PER_PAGE_EXAM();
            $name = trim($txt_search, " ");
            $data = $this->_db_exam->list_exam_approved($name);
            $count = count($data->get());
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_EXAM());

            return view('admin.exam.show_list_exam')
                ->with('data', $data_send)
                ->with('start', $start)
                ->with('count', $count)
                ->with('search_old', $name);

        } catch (\Exception $ex) {
            return $ex;
        }
    }


    /**
     * find exam approved and display
     *
     * @param Request $request
     * @param $txt_search
     * @return \Exception|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post_list_exam_approved(Request $request, $txt_search)
    {
        try {
            $name = trim($request['txt_search'], " ");
            if ($name == "") {
                return redirect('admin/exam/show=%20')->with('message_notification', "Bạn vừa nhập vào khoảng trắng");
            } else {
                return redirect('admin/exam/show=' . $name);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
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
            $topic = TblTopic::all();
            $level = TblLevel::all();

            return view('admin.exam.upload_exam')
                ->with('class_room', $class_room)
                ->with('subject', $subject)
                ->with('topic', $topic)
                ->with('level', $level);
        } catch (\Exception $ex) {
            return $ex;
        }
    }


    /**
     * save exam file into storage of project
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
                            return redirect()->back()->with('message_notification', "File giải thích chỉ nhận file word or pdf");
                        } elseif ($explain_file_name == 1) {
                            return redirect()->back()->with('message_notification', "Kích thước file giải thích vượt quá 4MB");
                        } else {
                            $rs_db = $this->_db_exam->upload_exam_and_explain($request, $exam_file_name, $explain_file_name);
                            if (is_numeric($rs_db)) {
                                Storage::disk('exam')->put($exam_file_name, File::get($request->file('file_exam')));
                                Storage::disk('explain')->put($explain_file_name, File::get($request->file('file_explain')));
                                return view('admin.exam.enter_answer')->with('message_success', "Tải đề thi lên thành công");
                            }
                        }
                    }
                    //not have file explain
                    $rs_db = $this->_db_exam->upload_exam_file($request, $exam_file_name);
                    if (is_numeric($rs_db)) {
                        Storage::disk('exam')->put($exam_file_name, File::get($request->file('file_exam')));
                        return 10;
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
            //check file size
            if ($file_size > (1024 << 2)) {
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




}
