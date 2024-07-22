<?php

namespace App\Services;

use App\Http\Controllers\SendMessageRegistrationController;
use App\Dtos\{DtoLogin, DtoRegister};
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AuthService
{

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

        $data['full_name'] = $dtoRegister->getFullName();
        $data['user_name'] = $dtoRegister->getUserName();
        $data['birthdate'] = $dtoRegister->getBirthdate();
        $data['phone'] = $dtoRegister->getPhone();
        $data['address'] = $dtoRegister->getAddress();
        $data['password'] = Hash::make($dtoRegister->getPassword());
        $data['email'] = $dtoRegister->getEmail();
        $data['user_type'] = 'user';
        $data['verified'] = $dtoRegister->getMessageType();

        $user = User::create($data);

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
