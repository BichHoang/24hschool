<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 6/13/2018
 * Time: 2:56 PM
 */

namespace App\DAO\DaoStudent;


use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class AccountDaoUser
{

    public function register_user($email, $full_name, $password, $phone, $at_school, $birthday)
    {
        try {
            return DB::table('user')->insert([
                'id' => Uuid::uuid4(),
                'email' => $email,
                'full_name' => $full_name,
                'password' => $password,
                'phone' => $phone,
                'at_school' => $at_school,
                'birthday' => $birthday,
                'created_at' => time(),
                'updated_at' => time()
            ]);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function upload_avatar($fileName)
    {
        try {
            $oldImg = Auth::user()->avatar;
            $this->delAvatar($oldImg);
            return DB::table('user')
                ->where('id', Auth::user()->id)
                ->update([
                    'avatar' => $fileName,
                    'updated_at' => time()
                ]);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function delAvatar($img){
        $image_path = public_path().'/avatar/'.$img;
        if(is_file($image_path)){
            unlink($image_path);
        }
    }

    public function update_full_name($full_name){
        try{
            return DB::table('user')
                ->where('id', Auth::user()->id)
                ->update([
                    'full_name' => $full_name,
                    'updated_at' => time()
                ]);
        }catch (\Exception  $ex){
            return $ex;
        }
    }

    public function update_birthday($birthday){
        try{
            return DB::table('user')
                ->where('id', Auth::user()->id)
                ->update([
                    'birthday' => $birthday,
                    'updated_at' => time()
                ]);
        }catch (\Exception  $ex){
            return $ex;
        }
    }

    public function update_phone($phone){
        try{
            return DB::table('user')
                ->where('id', Auth::user()->id)
                ->update([
                    'phone' => $phone,
                    'updated_at' => time()
                ]);
        }catch (\Exception  $ex){
            return $ex;
        }
    }

    public function update_at_school($at_school){
        try{
            return DB::table('user')
                ->where('id', Auth::user()->id)
                ->update([
                    'at_school' => $at_school,
                    'updated_at' => time()
                ]);
        }catch (\Exception $ex){
            return $ex;
        }
    }

    public function update_facebook($facebook){
        try{
            return DB::table('user')
                ->where('id', Auth::user()->id)
                ->update([
                    'facebook' => $facebook,
                    'updated_at' => time()
                ]);
        }catch (\Exception  $ex){
            return $ex;
        }
    }

    /**
     * update password of user
     * @param $password
     * @return \Exception
     */
    public function update_password($password){
        try{
            return DB::table('user')
               ->where('id', Auth::user()->getAuthIdentifier())
                ->update([
                    'password' => bcrypt($password),
                    'updated_at' => time()
                ]);
        }catch (\Exception  $ex){
            return $ex;
        }
    }

    /**
     * give password again for user forgot password
     * @param $email
     * @param $password
     * @return \Exception
     */
    public function forgot_password($email, $password){
        try{
            return DB::table('user')
            ->where('email', $email)
            ->update([
                'password' => bcrypt($password),
                'updated_at' => time()
            ]);
        }catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * update status of user to 10
     * @param $id_user
     * @return \Exception
     */
    public function update_complete_infor($id_user){
        try{
            return DB::table('user')
                ->where('id', $id_user)
                ->update([
                    'status' => 10
                ]);
        }catch (\Exception $ex){
            return $ex;
        }
    }
}