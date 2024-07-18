<?php

namespace App\Services\Contracts;

use App\Dtos\DtoSendMessage;

interface SenderInterface
{
    function send(DtoSendMessage $dtoSendMessage);
}
