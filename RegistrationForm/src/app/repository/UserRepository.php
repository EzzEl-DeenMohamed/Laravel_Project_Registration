<?php

namespace App\repository;

use App\Dtos\DtoRegister;
use App\Models\RegistrationStep;
use App\Models\User;
use App\repository\Contracts\RegistrationRepositoryInterface;
use App\repository\Contracts\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{

    public function findUserByUserName($userName)
    {
        return User::where('user_name', $userName)->exists();
    }

    public function checkForUserByEmail($email)
    {
        return User::where('email', $email)->exists();
    }

    public function addUser(DtoRegister $dtoRegister): User
    {
        $data['full_name'] = $dtoRegister->getFullName();
        $data['user_name'] = $dtoRegister->getUserName();
        $data['birthdate'] = $dtoRegister->getBirthdate();
        $data['phone'] = $dtoRegister->getPhone();
        $data['address'] = $dtoRegister->getAddress();
        $data['password'] = Hash::make($dtoRegister->getPassword());
        $data['email'] = $dtoRegister->getEmail();
        $data['user_type'] = 'user';
        $data['verified'] = $dtoRegister->getMessageType();

        $user = User::create($data);

        return $user;
    }
}
