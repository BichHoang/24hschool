<?php

namespace App\Http\Controllers\Lecturer;

use App\DAO\DaoLecturer\LecturerCTVDao;
use App\DAO\DaoLecturer\LecturerExamDao;
use App\Http\System\SystemStringParameter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CTVController extends Controller
{
    private $_db_ctv;
    private $_db_exam;

    /**
     * create a new instance of CTVController
     *
     * CTVController constructor.
     */
    public function __construct()
    {
        $this->_db_ctv = new LecturerCTVDao();
        $this->_db_exam = new LecturerExamDao();
    }

    /**
     * show list of this lecturer's ctv
     *
     * @param $txt_search
     * @return \Exception
     */
    public function get_list_your_ctv($txt_search)
    {
        try {
            $page = Input::get('page');
            if ($page < 1) {
                $page = 1;
            }
            $start = ($page - 1) * SystemStringParameter::PER_PAGE_ACCOUNT();
            $name = trim($txt_search, " ");
            $data = $this->_db_ctv->get_your_ctv($name);
            $count = count($data->get());
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_ACCOUNT());

            return view('lecturer.ctv.list_ctv')
                ->with('data', $data_send)
                ->with('start', $start)
                ->with('count', $count)
                ->with('search_old', $name);

        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * find lecturer's ctv by keyword
     *
     * @param Request $request
     * @param $txt_search
     * @return \Exception|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post_list_your_ctv(Request $request, $txt_search)
    {
        try {
            $name = trim($request['txt_search'], " ");
            if ($name == "") {
                return redirect('lecturer/ctv/list=%20')
                    ->with('message_notification', "Bạn vừa nhập vào một khoảng trắng");
            } else {
                return redirect('lecturer/ctv/list=' . $name);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * display list exam of a ctv by id_ctv
     *
     * @param $id_ctv
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function get_list_exam_of_ctv($id_ctv)
    {
        try {
            $ctv = $this->_db_ctv->get_detail_a_ctv($id_ctv);
            if (count($ctv) <= 0) {
                return redirect('lecturer/ctv/list=%20')
                    ->with('message_notification', "Không phải cộng tác viên của bạn");
            } else {
                $page = Input::get('page');
                if ($page < 1) {
                    $page = 1;
                }
                $start = ($page - 1) * SystemStringParameter::PER_PAGE_EXAM();
                $data = $this->_db_exam->get_list_exam_of_ctv($id_ctv);
                $count = count($data->get());
                $data_send = $data->paginate(SystemStringParameter::PER_PAGE_EXAM());

                return view('lecturer.ctv.list_exam')
                    ->with('data', $data_send)
                    ->with('start', $start)
                    ->with('count', $count)
                    ->with('ctv', $ctv);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * watch detail exam by id_exam
     *
     * @param $id_exam
     * @return $this|\Exception|\Illuminate\Http\RedirectResponse
     */
    public function watch_detail_exam($id_exam)
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

    /**
     * display view create a new ctv
     *
     * @return \Exception|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get_create_new_ctv()
    {
        try {
            return view('lecturer.ctv.create_ctv');
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * check and send info for create a new ctv
     *
     * @param Request $request
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_create_new_ctv(Request $request)
    {
        $this->validate($request,
            [
                'email' => 'required|email|unique:user,email',
                'password' => 'required|min:6|max:20',
                're_password' => 'required|same:password',
                'full_name' => 'required|min:6|max:50',
//                'birthday' => 'date',
                'phone' => 'digits_between:10,11'
            ],
            [
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Không đúng định dạng email',
                'email.unique' => 'Email đã có người sử dụng',
                'password.required' => 'Vui lòng nhập mật khẩu',
                're_password.same' => 'Nhập lại mật khẩu không chính xác',
                'password.min' => 'Mật khẩu ít nhất 6 kí tự',
                'password.max' => 'Mật khẩu nhiều nhất 20 kí tự',
                'full_name.required' => 'Họ tên là bắt buộc',
                'full_name.min' => 'Họ tên ít nhất 6 ký tự',
                'full_name.max' => 'Họ tên nhiều nhất 50 ký tự',
//                'birthday.date' => 'Ngày tháng không hợp lệ',
                'phone.number' => 'Số điện thoại chỉ nhận số',
                'phone.digits_between' => 'Số điện thoại ít nhất 10 số, nhiều nhất 11 số'
            ]);
        try {
            $rs = $this->_db_ctv->create_ctv($request);
            if(!is_numeric($rs)){
                return redirect('lecturer/ctv/list=%20')
                    ->with('message_success',"Tạo cộng tác viên thành công");
            }else{
                return redirect()->back()
                    ->with('message_notification',"Tạo cộng tác viên thất bại");
            }

        } catch (\Exception $ex) {
            return $ex;
        }
    }
}
