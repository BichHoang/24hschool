<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $_password;

    public function __construct($password)
    {
        $this->_password = $password;
    }

    /**
     * lay lai mat khau
     * @param $password
     * @return $this
     */
    public function build()
    {
        return $this->view('auth.passwords.link_reset')
            ->subject("24hSchool - Lấy lại mật khẩu")
            ->with('password',$this->_password);
    }


}
