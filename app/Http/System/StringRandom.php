<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 6/14/2018
 * Time: 4:57 PM
 */

namespace App\Http\System;


class StringRandom
{
    public static function generate_random_string()
    {
        $length = 5;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $char_length = strlen($characters);
        $random_string = '';
        for ($i = 0; $i < $length; $i++) {
            $random_string .= $characters[rand(0, $char_length - 1)];
        }
        $t = date('Ymdhis', time());
        $random_string = $t.$random_string;
        return $random_string;
    }

    public static function generate_random_code(){
        $length = 3;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $char_length = strlen($characters);
        $random_string = '';
        for ($i = 0; $i < $length; $i++) {
            $random_string .= $characters[rand(0, $char_length - 1)];
        }
        $t = date('mdhis', time());
        $random_string = $t.$random_string;
        return $random_string;
    }

    //generate password
    public static function generate_password(){
        $length = 8;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $char_length = strlen($characters);
        $random_string = '';
        for ($i = 0; $i < $length; $i++) {
            $random_string .= $characters[rand(0, $char_length - 1)];
        }
        return $random_string;
    }
}