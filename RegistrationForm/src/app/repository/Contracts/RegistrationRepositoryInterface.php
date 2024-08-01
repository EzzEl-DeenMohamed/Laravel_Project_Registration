<?php

namespace App\repository\Contracts;

use App\Models\RegistrationStep;

interface RegistrationRepositoryInterface
{
    public function findDraftUserById($id): ?RegistrationStep;
    public function addRegistrationStep(RegistrationStep $registrationStep): void;

    public function deleteRegistrationStepUser($id);

}
