<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BirthDayMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($email,$full_name,$birthdate,$address)
    {
        return $this->view('mail.HappyBirthday',['variableName' => $full_name,'variableEmail' => $email,'birthdate' => $birthdate, 'address'=>$address])->subject("Happy Birthday!");
    }

    public function build()
    {

    }

}
