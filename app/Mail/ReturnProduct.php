<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReturnProduct extends Mailable
{
    use Queueable, SerializesModels;

    public $return;
    public $user;

    public function __construct($user, $return)
    {
        $this->return = $return;
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.return-product');
    }
}
