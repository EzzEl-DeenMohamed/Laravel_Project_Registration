<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginPost;
use App\Http\Requests\RegisterPost;
use App\Dtos\DtoLogin;
use App\Dtos\DtoRegister;
use App\Services\AuthService;
use App\Exceptions\FailedToLogin;

class AuthController extends Controller
{
    private AuthService $_authServices;

    public function __construct(AuthService $authServices)
    {
        $this->_authServices = $authServices;
    }

    public function loginPost(LoginPost $request)
    {
        $dtoLogin = new DtoLogin($request->email, $request->password);

        return $this->_authServices->loginPostService($dtoLogin) ? view('welcome') : throw new FailedToLogin();
    }

    /**
     * @throws FailedToLogin
     */
    public function login()
    {
        return $this->_authServices->loginServices() ? view('welcome') : view('login');
    }

    public function registration()
    {
        return view('registration');
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

        return !$this->_authServices->registrationPostService($dtoRegister) ? redirect(route('registration')) : redirect(route('login'));
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
