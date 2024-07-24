<?php

namespace App\Services\SendMessageRequest\MessageType;

use App\Dtos\DtoSendMessage;
use App\Services\Contracts\SenderInterface;
use function Laravel\Prompts\alert;


class Sms implements SenderInterface
{
    public string $message;
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function send(DtoSendMessage $dtoSendMessage)
    {
        alert($this->message);

    }
}
