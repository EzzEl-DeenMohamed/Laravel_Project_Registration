<?php

namespace App\repository\Contracts;

use App\Dtos\DtoRegister;
use App\Models\RegistrationStep;
use App\Models\User;
use Exception;

interface RegistrationRepositoryInterface
{
    public function addUser(DtoRegister $dtoRegister): User;

    /**
     * @throws Exception
     */
    public function checkIfExistUser($data): ?RegistrationStep;

    /**
     * @throws Exception
     */
    public function findUserById($id): ?RegistrationStep;

    public function removeIdFromRequest($data): string;

    public function extractUserNameFromData($jsonString): ?string;

    /**
     * @throws Exception
     */
    public function checkIfEmailExists($user): void;

    public function saveRegistrationStep(RegistrationStep $registrationStep): void;

    public function removeTokenFromRequest($data): string;
}
