<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyOrder extends Mailable
{
    use Queueable, SerializesModels;

    protected $_view_send;
    protected $_transaction;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($view, $transaction)
    {
        $this->_view_send = $view;
        $this->_transaction = $transaction;
    }

    /**
     * gui tin nhan thong bao ve don hang
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->_view_send)
            ->subject('24hSchool - Thông báo đặt hàng')
            ->with('transaction', $this->_transaction);
    }
}
