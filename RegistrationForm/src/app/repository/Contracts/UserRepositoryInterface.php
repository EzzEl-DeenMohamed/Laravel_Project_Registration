<?php

namespace App\repository\Contracts;

use App\Dtos\DtoRegister;
use App\Models\User;

interface UserRepositoryInterface
{
    public function findUserByUserName($userName);

    public function addUser(DtoRegister $dtoRegister): User;

    public function checkForUserByEmail($email);

}
