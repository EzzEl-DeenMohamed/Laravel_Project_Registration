<?php

namespace App\Http\Controllers\Auth;

use App\Dtos\DtoLogin;
use App\Exceptions\FailedToLogin;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPost;
use App\Services\Auth\LoginService;

class LoginController extends Controller
{
    private LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function loginPost(LoginPost $request)
    {
        $dtoLogin = new DtoLogin($request->email, $request->password);

        return $this->loginService->loginPostService($dtoLogin) ? view('welcome') : throw new FailedToLogin();
    }

    /**
     * @throws FailedToLogin
     */
    public function login(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return $this->loginService->loginServices() ? view('welcome') : view('login');
    }

    public function logout(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $this->loginService->logout();
        return redirect(route('login'));
    }

    public function adminPlace(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('admin');
    }
}
