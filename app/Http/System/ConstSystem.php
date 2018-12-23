<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Van Tin
 * Date: 8/9/2018
 * Time: 9:58 AM
 */

namespace App\Http\System;

//exam
define("EXAM_APPROVED_INTO_WEB", 1);
define("EXAM_APPROVED_INTO_EXAM_DIRECTORY", 2);
define("EXAM_NOT_ANSWER", 3);
define("EXAM_NEED_MODIFY", 4);
define("EXAM_HAVE_ANSWER", 5);
define("EXAM_WAITING_APPROVE", 6);

define("NOT_SEND", 0);
define("REQUEST_APPROVE", 1);
define("REQUEST_END", 4);

//transaction
define('ADMIN_NOT_SEEN', 0);
define('TRANSACTION_NOT_HANDING', 1);
define('TRANSACTION_HIDE', 2);
define('CUSTOMER_CANCEL_TRANSACTION', 3);
define('TRANSACTION_HANDING', 5);
define('TRANSACTION_SUCCESS', 9);
define('TRANSACTION_FAIL', 10);

define('REASON_DENY_RECEIVE_TRANSACTION', 1);
define('REASON_TRANSACTION_FAIL', 2);

class ConstSystem
{

}