<?php

namespace App\Services\SendMessageRequest\MessageType;

use App\Services\Contracts\SenderInterface;

class Sms implements SenderInterface
{
    public function send()
    {
        return "Sms sent";
    }
}
{

}
