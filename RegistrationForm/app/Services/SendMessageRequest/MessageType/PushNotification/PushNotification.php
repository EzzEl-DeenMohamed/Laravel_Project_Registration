<?php

namespace App\Services\SendMessageRequest\MessageType\PushNotification;

use function Laravel\Prompts\alert;

class PushNotification
{
    public string $message;
    public function __construct($message)
    {
        $this->message = $message;
    }

    public function push(): void
    {
        alert($this->message);
    }


}
