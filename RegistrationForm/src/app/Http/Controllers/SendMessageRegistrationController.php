<?php

namespace App\Http\Controllers;

use App\Dtos\DtoRegister;
use App\Services\SendMessageRegistrationService;

class SendMessageRegistrationController extends Controller
{
    public function send(DtoRegister $dtoRegister)
    {
        $service = new SendMessageRegistrationService($dtoRegister);
        $service->send();

        return response()->json(['status' => 'Message sent successfully']);
    }
}
