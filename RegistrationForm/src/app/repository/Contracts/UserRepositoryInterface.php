<?php

namespace App\repository\Contracts;

use App\Dtos\DtoRegister;

interface UserRepositoryInterface
{
    public function findUserByUserName($userName);

    public function addUser(DtoRegister $dtoRegister);

    public function checkForUserByEmail($email);

}
