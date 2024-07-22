<?php

namespace App\Services\SendMessageRequest;

use App\Services\Contracts\SenderInterface;

class SendRequest
{
    public SenderInterface $messageType;

    function __construct(SenderInterface $messageType)
    {
        $this->messageType = $messageType;
    }

}
