<?php

namespace App\repository;

use App\Models\RegistrationStep;
use App\repository\Contracts\RegistrationRepositoryInterface;
use Exception;

class RegistrationRepository implements RegistrationRepositoryInterface
{
    public function __construct()
    {
        $this->model = new RegistrationStep();
    }

    public function all()
    {
        return $this->model->all();
    }

    /**
     * @throws Exception
     */
    public function findDraftUserById($id): ?RegistrationStep
    {
        return RegistrationStep::find($id);
    }

    /**
     * @throws Exception
     */

    public function addRegistrationStep(RegistrationStep $registrationStep): void
    {
        $registrationStep->save();
    }

    public function deleteRegistrationStepUser($id): int
    {
        return RegistrationStep::destroy($id);
    }
}
