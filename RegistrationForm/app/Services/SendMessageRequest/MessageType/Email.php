<?php

namespace App\Services\SendMessageRequest\MessageType;

use App\Dtos\DtoSendMessage;
use App\Mail\BirthDayMail;
use App\Services\Contracts\SenderInterface;
use Illuminate\Support\Facades\Mail;

class Email implements SenderInterface
{
    public function send(DtoSendMessage $dtoSendMessage)
    {
        Mail::to($dtoSendMessage->getEmail())->send(
            new BirthDayMail(
                $dtoSendMessage->getEmail(),
                $dtoSendMessage->getFullName(),
                $dtoSendMessage->getBirthDate(),
                $dtoSendMessage->getAddress()
            ));
    }
}
