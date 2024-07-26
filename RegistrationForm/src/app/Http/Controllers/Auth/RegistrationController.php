<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\RegistrationService;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    private RegistrationService $registrationService;

    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    public function registration(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $draftUser = $this->registrationService->getFirstRegistrationPage();
        return view('registration', ['draftUser' => $draftUser]);
    }

    public function registrationPost(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->registrationService->postFirstRegistrationPage($request);
        return redirect()->route('registration2');
    }

    public function registration2(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('registration2', ['draftUser' => $this->registrationService->userRepository->getDraftUser(session('user_name'))]);
    }

    public function registrationPost2(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->registrationService->postSecondRegistrationPage($request);
        return redirect()->route('registration3');
    }


    public function registration3(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('registration3',['draftUser' => $this->registrationService->userRepository->getDraftUser(session('user_name'))]);
    }

    public function registrationPost3(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->registrationService->postThirdRegistrationPage($request);
        return redirect()->route('home');
    }
}
