<?php

namespace App\Services\Auth;

use App\Dtos\DtoRegister;
use App\Http\Controllers\SendMessageRegistrationController;
use App\repository\UserRepository;



class RegistrationService
{
    public UserRepository $userRepository;

    function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registrationPostService(DtoRegister $dtoRegister){

        $user = $this->userRepository->addUser($dtoRegister);

        if(!$user){
            return false;
        }

        $SendMessageRegistrationController = new SendMessageRegistrationController();
        $SendMessageRegistrationController->send($dtoRegister);
        return true;
    }

}
