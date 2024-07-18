<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginPost;
use App\Http\Requests\RegisterPost;
use App\Dtos\DtoLogin;
use App\Dtos\DtoRegister;
use App\Services\AuthService;

class AuthController extends Controller
{
    private AuthService $_authServices;

    public function __construct(AuthService $authServices)
    {
        $this->_authServices = $authServices;
    }

    public function login()
    {
        return $this->_authServices->loginServices() ? redirect(route('home')) : view('login');
    }

    public function registration()
    {
        return view('registration');
    }

    public function loginPost(LoginPost $request)
    {
        $dtoLogin = new DtoLogin($request->email, $request->password);

        $result = $this->_authServices->loginPostService($dtoLogin);

        return $result['success'] ?  redirect()->intended(route('home')) : error_log('login post failed');
    }

    public function registrationPost(RegisterPost $request)
    {
        $dtoRegister = new DtoRegister(
            $request->full_name,
            $request->user_name,
            $request->birthdate,
            $request->phone,
            $request->address,
            $request->password,
            $request->email,
            $request->messageType

        );

        $validateRegistration = $this->_authServices->registrationPostService($dtoRegister);
        return !$validateRegistration['success'] ? redirect(route('registration')) : redirect(route('login'));
    }

    public function logout()
    {
        $this->_authServices->logout();
        return redirect(route('login'));
    }

    public function adminPlace()
    {
        return view('admin');
    }
}
