<?php

namespace App\repository;

use App\Dtos\DtoRegister;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function addUser(DtoRegister $dtoRegister)
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
