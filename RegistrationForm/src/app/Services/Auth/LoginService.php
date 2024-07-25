<?php

namespace App\Services\Auth;

use App\Dtos\DtoLogin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class LoginService
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

    public function logout() {
        Session::flush();
        Auth::logout();
    }
}
