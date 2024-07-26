<?php

namespace App\Services\Auth;

use App\Dtos\DtoRegister;
use App\Http\Controllers\SendMessageRegistrationController;
use App\repository\RegistrationRepository;


class RegistrationService
{
    public RegistrationRepository $userRepository;

    function __construct(RegistrationRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registrationPostService(DtoRegister $dtoRegister)
    {
        $user = $this->userRepository->addUser($dtoRegister);

        if (!$user)
            return false;

        $SendMessageRegistrationController = new SendMessageRegistrationController();
        $SendMessageRegistrationController->send($dtoRegister);
        return true;
    }

    public function getFirstRegistrationPage()
    {
        return $this->userRepository->initializeDraftUserIfNotExist();
    }

    public function postFirstRegistrationPage($request)
    {
        $this->userRepository->addFirstDraftPage($request);
    }

    public function postSecondRegistrationPage($request)
    {
        $this->userRepository->addSecondDraftPage($request);
    }

    public function postThirdRegistrationPage($request)
    {
        $this->userRepository->addThirdDraftPage($request);
    }

}
