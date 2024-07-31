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
        $user = new User();
        $user->full_name = $dtoRegister->getFullName();
        $user->user_name = $dtoRegister->getUserName();
        $user->birthdate = $dtoRegister->getBirthdate();
        $user->phone = $dtoRegister->getPhone();
        $user->address = $dtoRegister->getAddress();
        $user->password = Hash::make($dtoRegister->getPassword());
        $user->email = $dtoRegister->getEmail();
        $user->verified = $dtoRegister->getMessageType();
        $user->save();
        return $user;
    }
}
