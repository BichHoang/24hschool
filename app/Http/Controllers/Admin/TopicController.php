<?php

namespace App\Http\Controllers\Admin;

use App\DAO\DaoAdmin\DaoTopic;
use App\Http\System\SystemStringParameter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class TopicController extends Controller
{
    private $_db_topic;

    /**
     * create a new instance
     * TopicController constructor.
     */
    public function __construct()
    {
        $this->_db_topic = new DaoTopic();
    }

    /**
     * show list of topic
     * @param $txt_search
     * @return \Exception
     */
    public function get_list_topic($txt_search)
    {
        try {
            $page = Input::get('page');
            if ($page < 1) {
                $page = 1;
            }
            $start = ($page - 1) * SystemStringParameter::PER_PAGE_TOPIC();
            $name = trim($txt_search, " ");
            $data = $this->_db_topic->list_topic($name);
            $count = count($data->get());
            $data_send = $data->paginate(SystemStringParameter::PER_PAGE_TOPIC());

            return view('admin.topic.show')
                ->with('data', $data_send)
                ->with('start', $start)
                ->with('count', $count)
                ->with('search_old', $name);


        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * find topic with keyword
     * @param Request $request
     * @param $txt_search
     * @return \Exception|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post_list_topic(Request $request, $txt_search)
    {
        try {
            $name = trim($request['txt_search'], " ");
            if ($name == "") {
                return redirect('admin/topic/show=%20')->with('message_notification', "Bạn vừa nhập vào khoảng trắng");
            } else {
                return redirect('admin/topic/show='.$name);
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

}
