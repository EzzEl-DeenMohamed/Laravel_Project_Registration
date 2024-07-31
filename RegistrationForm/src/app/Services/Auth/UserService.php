<?php

namespace App\Services\Auth;

use App\repository\Contracts\UserRepositoryInterface;
use Exception;

class UserService
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
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
}
