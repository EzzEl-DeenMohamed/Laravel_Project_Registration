<?php

namespace App\Http\Controllers\Auth;

use App\Dtos\DtoLogin;
use App\Exceptions\FailedToLogin;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPost;
use App\Services\Auth\LoginService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

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
    public function login(): View|Factory|Application
    {
        return $this->loginService->loginServices() ? view('welcome') : view('login');
    }

    public function logout(): Application|Redirector|RedirectResponse
    {
        $this->loginService->logout();
        return redirect(route('login'));
    }

    public function adminPlace(): View|Factory|Application
    {
        return view('admin');
    }
}
