<?php

namespace App\Http\Controllers\Admin;

use App\DAO\DaoAdmin\Lecturer;
use App\Http\System\SystemStringParameter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class LecturerController extends Controller
{
    protected $_db_lecturer;

    public function __construct()
    {
        $this->_db_lecturer = new Lecturer();
    }

    /**
     * Get list account of lecturer
     * @param $txt_search : has value is %20
     * @return view of lecturer
     * @Exception return $ex
     */
    public function get_list_lecturer($txt_search){
        try{
            $page = Input::get('page');
            if($page < 1){
                $page = 1;
            }

            $start = ($page - 1) * SystemStringParameter::PER_PAGE_ACCOUNT();
            $name = trim($txt_search, " ");
            $data = $this->_db_lecturer->list_lecturer($name);
            $count = count($data->get());
            $data = $data->paginate(SystemStringParameter::PER_PAGE_ACCOUNT());
            return view('admin.lecturer.show')
                ->with('data',$data)
                ->with('start',$start)
                ->with('count',$count)
                ->with('search_old', $name);
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * Find lecturer in database
     * @param $request: use for get value of tag has name is txt_search
     * @return redirect
     * @Exception return $ex
     */
    public function post_list_lecturer(Request $request, $txt_search){
        try{
            $name = trim($request['txt_search'], " ");
            if($name == "" || $name == null){
                return redirect('admin/lecturer/show=%20');
            }else{
                return redirect('admin/lecturer/show='.$name);
            }
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * show view for crate a new lecturer
     * @return \Exception|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get_create_lecturer(){
        try{
            return view('admin.lecturer.create_lecturer');
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * create a new lecturer
     * @param Request $request
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function post_create_lecturer(Request $request){
        try{
            $rs = $this->_db_lecturer->create_lecturer($request);
            if(is_numeric($rs) && $rs == 0){
                return redirect()->back()
                    ->with('message_notification',"Tạo giáo viên thất bại");
            }else{
                return redirect('admin/lecturer/show=%20')
                    ->with('message_success', "Tạo giáo viên thành công");
            }
        }catch (\Exception $ex){
            return $ex;
        }
    }
}
