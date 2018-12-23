<?php

namespace App\Http\Controllers\Admin;

use App\DAO\DaoAdmin\DaoSubject;
use App\Http\System\SystemStringParameter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class SubjectController extends Controller
{
    private $_db_subject;

    /**
     * create a new instance
     * SubjectController constructor.
     */
    public function __construct()
    {
        $this->_db_subject = new DaoSubject();
    }

    /**
     * show list subject
     * @param $txt_search
     * @return \Exception
     */
    public function get_list_subject($txt_search){
        try{
            $page = Input::get('page');
            if($page < 1){
                $page = 1;
            }
            $start = ($page - 1) * SystemStringParameter::PER_PAGE_SUBJECT();
            $name = trim($txt_search, " ");
            $data = $this->_db_subject->get_list_subject($name);
            $count = count($data->get());
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_SUBJECT());

            return view('admin.subject.show')
                ->with('data', $data_send)
                ->with('start', $start)
                ->with('count', $count)
                ->with('search_old', $name);

        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * Find subject
     * @param Request $request
     * @param $txt_search
     * @return \Exception|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post_list_subject(Request $request, $txt_search){
        try{
            $name = trim($request['txt_search'], " ");
            if($name == ""){
                return redirect('admin/subject/show=%20')->with('message_notification',"Bạn vừa nhập vào khoảng trắng");
            }else{
                return redirect('admin/subject/show='.$name);
            }

        }catch (\Exception $ex){
            return $ex;
        }
    }
}
