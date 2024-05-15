<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HelloMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($email,$userName)
    {
        return $this->view('mail.new_registered_user',['variableName' => $userName,'variableEmail' => $email])->subject("New Registered User");
    }

    public function build()
    {
        
    }

}
