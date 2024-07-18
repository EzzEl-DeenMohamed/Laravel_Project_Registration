<?php

namespace App\Services;

use App\Dtos\DtoRegister;
use App\Dtos\DtoSendMessage;
use App\Services\Contracts\SenderInterface;
use App\Services\SendMessageRequest\MessageType\Email;
use App\Services\SendMessageRequest\MessageType\Sms;
use App\Services\SendMessageRequest\SendRequest;
use Exception;


class SendMessageRegistrationService
{
    private DtoSendMessage $dtoSendMessage;
    function __construct(DtoRegister $dtoRegister)
    {
        $this->dtoSendMessage = new DtoSendMessage(
            $dtoRegister->getMessageType(),
            $dtoRegister->getBirthdate(),
            $dtoRegister->getPhone(),
            $dtoRegister->getAddress(),
            $dtoRegister->getEmail(),
            $dtoRegister->getFullName(),
        );
    }

    public function send()
    {
        //todo
        // 2. use enum instead of int

        match($this->dtoSendMessage->getMessageType())
        {
            "email" => $email = new Email(),
            "phone" => $email = new Sms(),
            default => throw new Exception("Invalid message type")
        };

        $SendRequest = new SendRequest($email);
        $SendRequest->messageType->send($this->dtoSendMessage);

    }




}
