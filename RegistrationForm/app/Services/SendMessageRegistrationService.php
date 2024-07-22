<?php

namespace App\Services;

use App\Dtos\DtoRegister;
use App\Dtos\DtoSendMessage;
use App\Services\SendMessageRequest\MessageType\Email;
use App\Services\SendMessageRequest\MessageType\PushNotification\PushNotification;
use App\Services\SendMessageRequest\MessageType\PushNotification\PushNotificationAdaptor;
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
        match($this->dtoSendMessage->getMessageType())
        {
            "email" => $message = new Email(),
            "phone" => $message = new Sms("Hello This is sms from Laravel"),
            "push" => $message = new PushNotificationAdaptor(new PushNotification("Hello This is push notification from Laravel")),
            default => throw new Exception("Invalid message type")
        };

        $SendRequest = new SendRequest($message);
        $SendRequest->messageType->send($this->dtoSendMessage);

    }




}
