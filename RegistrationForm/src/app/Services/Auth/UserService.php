<?php

namespace App\Services\Auth;

use App\Dtos\DtoRegister;
use App\repository\Contracts\UserRepositoryInterface;
use Exception;

readonly class UserService
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    /**
     * @throws Exception
     */
    public function findUserByName($userName)
    {
        return $this->userRepository->findUserByUserName($userName) ?? throw new Exception('Username already exists.');
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
        $this->userRepository->addUser($this->createDtoFromRequest($data));
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
