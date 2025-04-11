<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComunicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $messageBody;
    public $link;

    public function __construct($title, $messageBody, $link)
    {
        $this->title = $title;
        $this->messageBody = $messageBody;
        $this->link = $link;
    }

    public function build()
    {
        return $this->subject($this->title)
                    ->markdown('emails.comunication');
    }
}

