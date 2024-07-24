<?php

namespace App\Services;

use App\Http\Controllers\SendMessageRegistrationController;
use App\repository\UserRepository;
use App\Dtos\{DtoLogin, DtoRegister};
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class AuthService
{
    public UserRepository $userRepository;

    function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function loginServices(){
        return Auth::check();
    }

    public function loginPostService(DtoLogin $data){

        return Auth::attempt([
            'email' => $data->getEmail(),
            'password' => $data->getPassword()
        ]);
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

    public function logout() {
        Session::flush();
        Auth::logout();
    }
}
