<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 7/24/2018
 * Time: 4:14 PM
 */

namespace App\DAO\DaoAdmin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class Lecturer
{
    /**
     * select lecturer
     * @param $name : use for search
     * @return list lecturer
     */
    public function list_lecturer($name){
        try{
            if ($name == null || $name == "") {
                return DB::table('user')
                    ->where('status','10')
                    ->where('role',5);
            } else {
                return DB::table('user')
                    ->where('status','10')
                    ->where('role',5)
                    ->where(function ($query) use ($name) {
                        $query->where('email', 'like', "$name%")
                            ->orWhere('full_name', 'like', "$name%");
                    });
            }
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * create a new lecturer
     * @param $request
     * @return \Exception|int|\Ramsey\Uuid\UuidInterface
     */
    public function create_lecturer($request){
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
                'role' => 5,
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