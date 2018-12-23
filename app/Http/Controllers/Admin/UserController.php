<?php

namespace App\Http\Controllers\Admin;

use App\DAO\DaoAdmin\DaoUser;
use App\Http\System\SystemStringParameter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    private $_dao_user;

    public function __construct()
    {
        $this->_dao_user = new DaoUser();
    }

    /**
     * Get list account of student
     * @param $txt_search : has value is %20
     * @return view of student
     */
    public function get_list_student($txt_search){
        try{
            $page = Input::get('page');
            if($page < 1){
                $page = 1;
            }

            $start = ($page - 1) * SystemStringParameter::PER_PAGE_ACCOUNT();
            $name = trim($txt_search, " ");
            $data = $this->_dao_user->list_student($name);
            $count = count($data->get());
            $data = $data->paginate(SystemStringParameter::PER_PAGE_ACCOUNT());
            return view('admin.student.show')
                ->with('data',$data)
                ->with('start',$start)
                ->with('count',$count)
                ->with('search_old', $name);
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * Find student in database
     * @param $request: use for get value of tag has name is txt_search
     * @return redirect
     */
    public function post_list_student(Request $request, $txt_search){
        try{
            $name = trim($request['txt_search'], " ");

            if($name == "" || $name == null){
                return redirect('admin/student/show=%20');
            }else{
                return redirect('admin/student/show='.$name);
            }
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * Get list account of ctv
     * @param $txt_search : has value is %20
     * @return view show of ctv
     */
    public function get_list_ctv($txt_search){
        try{
            $page = Input::get('page');
            if($page < 1){
                $page = 1;
            }

            $start = ($page - 1) * SystemStringParameter::PER_PAGE_ACCOUNT();
            $name = trim($txt_search, " ");
            $data = $this->_dao_user->list_ctv($name);
            $count = count($data->get());
            $data = $data->paginate(SystemStringParameter::PER_PAGE_ACCOUNT());
            return view('admin.ctv.show')
                ->with('data',$data)
                ->with('start',$start)
                ->with('count',$count)
                ->with('search_old', $name);
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * Find ctv in database
     * @param $request: use for get value of tag has name is txt_search
     * @return redirect
     */
    public function post_list_ctv(Request $request, $txt_search){
        try{
            $name = trim($request['txt_search'], " ");

            if($name == "" || $name == null){
                return redirect('admin/ctv/show=%20');
            }else{
                return redirect('admin/ctv/show='.$name);
            }
        }catch (\Exception $ex){
            return $ex;
        }
    }
}
