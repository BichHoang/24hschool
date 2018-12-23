<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 6/20/2018
 * Time: 3:35 PM
 */

namespace App\DAO\DaoLecturer;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

define("STUDENT_NOT_ADD", 1);
define("ACCOUNT_BLOCKED", 2);
define("STUDENT_COMPLETE", 10);
define("CTV", 10);

class LecturerCTVDao
{
    /**
     * get information of this lecturer's ctv
     *
     * @param $name
     * @return \Exception
     */
    public function get_your_ctv($name){
        try{
            if($name == ""){
                return DB::table('user')
                    ->where('status', CTV)
                    ->where('role', 4)
                    ->where('id_lecturer', Auth::user()->id)
                    ->orderBy('created_at', 'desc');
            }else{
                return DB::table('user')
                    ->where('status', CTV)
                    ->where('role', 4)
                    ->where('id_lecturer', Auth::user()->id)
                    ->where(function ($query) use ($name){
                       $query->where('email', 'like', "%$name%")
                       ->orWhere('full_name', 'like', "%$name%");
                    })
                    ->orderBy('created_at', 'desc');
            }
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * get detail a ctv of lecturer logged
     *
     * @param $id_ctv
     * @return \Exception
     */
    public function get_detail_a_ctv($id_ctv){
        try{
            return DB::table('user')
                ->where('id', $id_ctv)
                ->where('role', 4)
                ->where('id_lecturer', Auth::user()->id)
                ->first();
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * save a new ctv
     *
     * @param $request
     * @return \Exception
     */
    public function create_ctv($request){
        try{
            $email = $request['email'];
            $password = $request['password'];
            $full_name = $request['full_name'];
//            $birthday = $request['birthday'];
            $phone = $request['phone'];
            $id = Uuid::uuid4();
            $rs = DB::table('user')->insert([
                'id' => $id,
                'email' => $email,
                'password' => bcrypt($password),
                'full_name' => $full_name,
//                'birthday' => $birthday,
                'phone' => $phone,
                'status' => 10,
                'role' => 4,
                'id_lecturer' => Auth::user()->id,
                'created_at' => time(),
                'updated_at' => time()
            ]);
            if($rs){
                return $id;
            }else{
                return 0;
            }

        }catch (\Exception $ex){
            return $ex;
        }
    }
}