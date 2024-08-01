<?php

namespace App\Services\Auth;

use App\Dtos\DtoRegister;
use App\Http\Controllers\SendMessageRegistrationController;
use App\repository\Contracts\UserRepositoryInterface;
use Exception;

readonly class UserService
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {}

    public function sendMessageRegistration($dtoRegister): void
    {
        $SendMessageRegistrationController = new SendMessageRegistrationController();
        $SendMessageRegistrationController->send($dtoRegister);
    }

    /**
     * @throws Exception
     */
    public function findUserByName($userName)
    {
        if($this->userRepository->findUserByUserName($userName))
        {
            throw new \RuntimeException('Username already exists.');
        }
        return $this->userRepository->findUserByUserName($userName);

    }

    /**
     * @throws Exception
     */
    public function findUserNameByEmail($email)
    {
        return $this->userRepository->findUserByUserName($email) ?? throw new Exception('Username already exists.');
    }

    public function createUser($data): void
    {
        $dtoRegister = $this->createDtoFromRequest($data);
        $this->sendMessageRegistration($dtoRegister);
        $this->userRepository->addUser($dtoRegister);
    }

    public function createDtoFromRequest($data): DtoRegister
    {
        $profileData = json_decode($data['Profile_Data'], true);
        $verificationData = json_decode($data['Verification_Data'], true);
        $imageData = json_decode($data['Image_Data'], true);

        return new DtoRegister(
            $profileData['full_name'],
            $profileData['user_name'],
            $profileData['birthdate'],
            $verificationData['phone'],
            $profileData['address'],
            $verificationData['password'],
            $verificationData['email'],
            $imageData['messageType']
        );
    }
}
