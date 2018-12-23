<?php

namespace App\Http\Controllers\Admin;

use App\DAO\DaoAdmin\DaoClassRoom;
use App\Http\System\SystemStringParameter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ClassController extends Controller
{
    private $_db_class_room;

    /**
     * create a instance
     * ClassController constructor.
     */
    public function __construct()
    {
        $this->_db_class_room = new DaoClassRoom();
    }

    /**
     * show list class room
     * @param $txt_search
     * @return \Exception
     */
    public function get_list_class_room($txt_search)
    {
        try {
            $page = Input::get('page');
            if ($page < 1) {
                $page = 1;
            }
            $start = ($page - 1) * SystemStringParameter::PER_PAGE_CLASS();
            $name = trim($txt_search, " ");
            $data = $this->_db_class_room->get_list_class_room($name);
            $count = count($data->get());
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_CLASS());

            return view('admin.class_room.show')
                ->with('data', $data_send)
                ->with('start', $start)
                ->with('count', $count)
                ->with('search_old', $name);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * show list of class found
     *
     * @param Request $request
     * @param $txt_search
     * @return \Exception|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post_list_class_room(Request $request, $txt_search){
        try{
            $name = $request['txt_search'];
            $name = trim($name, " ");
            if($name == ""){
                return redirect('admin/class_room/show=%20')->with('message_notification',"Bạn vừa nhập vào một khoảng trắng");
            }else{
                return redirect('admin/class_room/show='.$name);
            }

        }catch (\Exception $ex){
            return $ex;
        }
    }

    public function get_create_class_room(){
        try{
            return view('admin.class_room.create');
        }catch (\Exception $ex){
            return $ex;
        }
    }

    public function post_create_class_room(Request $request){
        try{

        }catch (\Exception $ex){
            return $ex;
        }
    }
}
