<?php

namespace App\Services\SendMessageRequest;

use App\Services\Contracts\SenderInterface;

class SendRequest
{
    public SenderInterface $messageType;

    public function getMessageType(): SenderInterface
    {
        return $this->messageType;
    }

    public function setMessageType(SenderInterface $messageType): void
    {
        $this->messageType = $messageType;
    }
    function __construct(SenderInterface $messageType)
    {
        $this->messageType = $messageType;
    }

}
