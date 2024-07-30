<?php

namespace App\Services\Auth;

use App\Http\Controllers\SendMessageRegistrationController;
use App\Models\RegistrationStep;
use App\repository\Contracts\RegistrationRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegistrationService
{

    public function __construct(private readonly RegistrationRepositoryInterface $userRepository){}

//    public function registrationPostService($draftUser)
//    {
//        $this->userRepository->moveDataFromDraftToPrimary($draftUser);
//
//        $dtoRegister = $this->userRepository->makeRegistrationDto($draftUser);
//
//        $SendMessageRegistrationController = new SendMessageRegistrationController();
//        $SendMessageRegistrationController->send($dtoRegister);
//        return true;
//    }

    /**
     * @throws Exception
     */
    public function postRegistration($data)
    {
        $registrationStep = $this->userRepository->checkIfExistUser($data);

        if ($registrationStep) {

            $existingData['current_step'] = $registrationStep->current_step;
            $allData = $registrationStep->data;
            $allData['Profile Data'] = $this->userRepository->removeTokenFromRequest($this->userRepository->removeIdFromRequest($data));


            // Update the current step only if the new step is greater
            if (1 > $existingData['current_step']) {
                $existingData['current_step'] = 1;
            }

            // Update the registration step record with the new data and current step
            $registrationStep->data = $allData;
            $registrationStep->current_step = $existingData['current_step'];

        } else {

            $dataFinal = [
                'Profile Data' => $this->userRepository->removeTokenFromRequest($data)
            ];

            $registrationStep = new RegistrationStep([
                'data' => $dataFinal,
                'current_step' => 1
            ]);
        }
        $this->userRepository->saveRegistrationStep($registrationStep);
        return $registrationStep->id;
    }

    /**
     * @throws Exception
     */
    public function postRegistration2($data)
    {

        $id = json_decode($data, true);
        $this->userRepository->checkIfEmailExists($data);
        $registrationStep = $this->userRepository->findUserById($id['id']) ?? throw new Exception('User not found.');

        if ($registrationStep) {

            $existingData['current_step'] = $registrationStep->current_step;
            $allData = $registrationStep->data;
            $allData['Verification Data'] = $this->userRepository->removeTokenFromRequest($this->userRepository->removeIdFromRequest($data));


            if ($existingData['current_step'] == 3) {
                throw new Exception('User already completed the registration process.');
            }

            // Update the current step only if the new step is greater
            if (2 > $existingData['current_step']) {
                $existingData['current_step'] = 2;
            }

            // Update the registration step record with the new data and current step
            $registrationStep->data = $allData;
            $registrationStep->current_step = $existingData['current_step'];

        }
        $this->userRepository->saveRegistrationStep($registrationStep);
        return $registrationStep->id;

    }

    /**
     * @throws Exception
     */
    public function postRegistration3($data, $filePath)
    {
        $data = $this->addImageUrl($data, $filePath);
        $id = json_decode($data, true);
        $this->userRepository->checkIfEmailExists($data);
        $registrationStep = $this->userRepository->findUserById($id['id']) ?? throw new Exception('User not found.');

        if ($registrationStep) {

            $existingData['current_step'] = $registrationStep->current_step;
            $allData = $registrationStep->data;
            $allData['Image Data'] = $this->userRepository->removeTokenFromRequest($this->userRepository->removeIdFromRequest($data));


            if ($existingData['current_step'] == 3) {
                throw new Exception('User already completed the registration process.');
            }

            // Update the current step only if the new step is greater
            if (3 > $existingData['current_step']) {
                $existingData['current_step'] = 3;
            }

            // Update the registration step record with the new data and current step
            $registrationStep->data = $allData;
            $registrationStep->current_step = $existingData['current_step'];

        }
        $this->userRepository->saveRegistrationStep($registrationStep);
        return $registrationStep->id;
    }

    public function makeRequestDataJson($request)
    {
        return json_encode($request->all());
    }

    public function uploadFileAndReturnPath(Request $request)
    {
        // Check if the request contains a file
        if ($request->hasFile('image_url')) {
            // Validate the file (optional)
            $request->validate([
                'image_url' => 'required|file|mimes:jpg,png,pdf,doc,docx|max:2048', // Add your validation rules here
            ]);

            // Retrieve the file from the request
            $file = $request->file('image_url');

            // Define a file path to store the file
            $filePath = 'uploads/' . time() . '_' . $file->getClientOriginalName();

            // Store the file in the storage/app/uploads directory
            Storage::put($filePath, file_get_contents($file));

            // Optionally, you can save the file path or other info to the database

            // Return a response to indicate successful upload
            return $filePath;
        }
        return '';

    }

    public function addImageUrl($data, $filePath)
    {
        $data = json_decode($data, true);
        $data['image_url'] = $filePath;
        return json_encode($data);
    }

//    public function getDraftUserArray($id)
//    {
//        $userDataRequest = $this->userRepository->findUserById($id);
//        dd($this->makeRequestDataJson($userDataRequest));
//        return $this->makeRequestDataJson($userDataRequest);
//    }

}
