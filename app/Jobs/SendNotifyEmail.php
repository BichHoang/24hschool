<?php

namespace App\Jobs;

use App\Mail\NotifyOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendNotifyEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $view;
    protected $transaction;
    protected $email;
    /**
     * Create a new job instance.
     * @param String view
     * @param Object transaction
     * @return void
     */
    public function __construct($email, $view, $transaction)
    {
        $this->email = $email;
        $this->view = $view;
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     * send mail thong bao
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->queue(new NotifyOrder($this->view, $this->transaction));
    }
}
