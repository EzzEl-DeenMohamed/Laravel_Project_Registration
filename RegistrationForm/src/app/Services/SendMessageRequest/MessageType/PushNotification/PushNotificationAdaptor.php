<?php

namespace App\Services\SendMessageRequest\MessageType\PushNotification;

use App\Dtos\DtoSendMessage;
use App\Services\Contracts\SenderInterface;

class PushNotificationAdaptor implements SenderInterface
{
    protected $pushNotification;

    public function __construct(PushNotification $pushNotification)
    {
        $this->pushNotification = $pushNotification;
    }


    function send(DtoSendMessage $dtoSendMessage)
    {
        $this->pushNotification->push();
    }
}
