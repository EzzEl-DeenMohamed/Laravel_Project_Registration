<?php

namespace App\repository;

use App\Dtos\DtoRegister;
use App\Models\RegistrationStep;
use App\Models\User;
use App\repository\Contracts\RegistrationRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Hash;

class RegistrationRepository implements RegistrationRepositoryInterface
{
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

    /**
     * @throws Exception
     */
    public function checkIfExistUser($data): ?RegistrationStep
    {
        $userName = $this->extractUserNameFromData($data);

        if (User::where('user_name', $userName)->exists()) {
            // If the username exists, throw an exception
            throw new Exception('Username already exists.');
        }

        if (!$userName) {
            return null;
        }

        // Fetch all registration steps and filter by user_name in the nested JSON
        $registrationSteps = RegistrationStep::all();
        $registrationStep = null;

        foreach ($registrationSteps as $step) {

            if(is_array($step['data'])){
                $stepData = $step['data'];
            }
            else {
                $stepData = json_decode($step['data'], true);
            }

            if (isset($stepData['Profile Data'])) {
                $firstPageData = $stepData['Profile Data'];

                // Decode First Page data if it's a string
                if (is_string($firstPageData)) {
                    $firstPageData = json_decode($firstPageData, true);
                }

                // Ensure that firstPageData is an array
                if (is_array($firstPageData)) {
                    $userNameInArray = $this->extractUserNameFromData($firstPageData) ?? null;

                    if ($userName !== null && $userName === $userNameInArray) {
                        $registrationStep = $step;
                        break;
                    }
                }
            }
        }

        return $registrationStep;
    }

    /**
     * @throws Exception
     */
    public function findUserById($id): ?RegistrationStep
    {
        return RegistrationStep::find($id);
    }

    public function removeIdFromRequest($data): string
    {
        // Decode the JSON string into an associative array
        $decodedData = json_decode($data, true);

        // Check if 'id' exists in the array and unset it
        if (isset($decodedData['id'])) {
            unset($decodedData['id']);
        }

        // Return the modified JSON string
        return json_encode($decodedData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function extractUserNameFromData($jsonString): ?string
    {
        if(is_array($jsonString)){
            $registrationStepArray = $jsonString;
        }
        else {
            $registrationStepArray = json_decode($jsonString, true);
        }

        // Check if 'data' key exists
        if ($registrationStepArray['user_name']) {
            return $registrationStepArray['user_name'];
        }

        return null;
    }

    /**
     * @throws Exception
     */
    public function checkIfEmailExists($user): void
    {
        $stringData = json_decode($user, true);

        if (!isset($stringData['email'])) {
            return;
        }

        if(User::where('email', $stringData['email'])->exists() ){
            throw new Exception('Email already exists.');
        }
    }

    public function saveRegistrationStep(RegistrationStep $registrationStep): void
    {
        $registrationStep->save();
    }

    public function removeTokenFromRequest($data): string
    {
        // Decode the JSON string into an associative array
        $decodedData = json_decode($data, true);

        // Check if 'id' exists in the array and unset it
        if (isset($decodedData['_token'])) {
            unset($decodedData['_token']);
        }

        // Return the modified JSON string
        return json_encode($decodedData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    }
}
