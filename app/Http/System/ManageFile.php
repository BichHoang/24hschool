<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 6/15/2018
 * Time: 7:30 PM
 */

namespace App\Http\System;


use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ManageFile
{

    /**
     * @param $file_name
     * @return \Exception|Response
     */
    public function get_file_exam(){
        try{
            $file = Storage::disk('exam')->get('20180615071647ciHqU.pdf');
            return new Response($file, 200);
        }catch (\Exception $ex){
            return $ex;
        }
    }
}