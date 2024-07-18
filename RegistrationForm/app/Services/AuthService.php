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
        return Auth::check() ? ['success'=>true] :['success'=>false];
    }

    public function loginPostService(DtoLogin $data){

        return Auth::attempt([
            'email' => $data->getEmail(),
            'password' => $data->getPassword()
        ]) ? ['success'=>true] : ['success'=>false];
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



        $user = User::create($data);

        if(!$user){
            return ['success'=>false,'message'=>'Registration failed!!'];
        }

        $SendMessageRegistrationController = new SendMessageRegistrationController();

        $SendMessageRegistrationController->send($dtoRegister);
        return ['success'=>true,'message'=>'Registration Success, Login to access your app!!'];
    }

    public function logout() {
        Session::flush();
        Auth::logout();
    }
}
