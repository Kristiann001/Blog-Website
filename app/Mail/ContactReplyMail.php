<?php

namespace App\Mail;

use App\Models\ContactReply;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reply;

    public function __construct(ContactReply $reply)
    {
        $this->reply = $reply;
    }

    public function build()
    {
        return $this->subject('Response to your message')
            ->view('emails.contact-reply');
    }
}
