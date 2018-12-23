<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 6/12/2018
 * Time: 8:40 PM
 */

namespace App\Http\System;


class SystemStringParameter
{
    /**
     * divide page of account
     *
     * @return int
     */
    public static function PER_PAGE_ACCOUNT()
    {
        return 15;
    }

    public static function PER_PAGE_BOOK()
    {
        return 15;
    }

    public static function PER_PAGE_DOCUMENT()
    {
        return 15;
    }

    /**
     * divide page of comment
     *
     * @return int
     */
    public static function PER_PAGE_COMMENT()
    {
        return 15;
    }

    /**
     * divide page of class
     *
     * @return int
     */
    public static function PER_PAGE_CLASS()
    {
        return 15;
    }

    /**
     * divide page of subject
     *
     * @return int
     */
    public static function PER_PAGE_SUBJECT()
    {
        return 15;
    }


    /**
     * divide page of topic
     *
     * @return int
     */
    public static function PER_PAGE_TOPIC()
    {
        return 15;
    }


    /**
     *divide page of exam
     *
     * @return int
     */
    public static function PER_PAGE_EXAM()
    {
        return 20;
    }


}