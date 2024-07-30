<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\RegistrationService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{

    public function registration(): View|Factory|Application
    {
//        $draftUser = $this->registrationService->getDraftUser(session('user_name'));
        return view('registration');
    }

    public function __construct(private readonly RegistrationService $registrationService){}

    public function registrationPost(Request $request): RedirectResponse
    {
        $id = $this->registrationService->postRegistration($this->registrationService->makeRequestDataJson($request));

        return redirect()->route('registration2')
            ->with('id',$id );
    }
    public function registrationPost2(Request $request): RedirectResponse
    {

        $id = $this->registrationService->postRegistration2($this->registrationService->makeRequestDataJson($request));
        return redirect()->route('registration3')
            ->with('id', $id);
    }
    public function registrationPost3(Request $request): RedirectResponse
    {
        $this->registrationService->postRegistration3($this->registrationService->makeRequestDataJson($request),$this->registrationService->uploadFileAndReturnPath($request));
        return redirect()->route('home');
    }

    public function registration2(): View|Factory|Application
    {
//        $data = $this->registrationService->getDraftUserArray(session('id'));
//        dd($data);
        return view('registration2');
    }


    public function registration3(): View|Factory|Application
    {
        return view('registration3');
    }

}
