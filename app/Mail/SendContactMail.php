<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public function __construct($data)
    {
        $this->data['fullName'] = $data['fullName'];
        $this->data['email'] = $data['email'];
        $this->data['subject'] = $data['subject'];
    }

    public function build()
    {
        return $this->view('mail.contact')->with($this->data);
    }
}
