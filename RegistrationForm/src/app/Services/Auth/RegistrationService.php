<?php

namespace App\Services\Auth;

use App\Models\RegistrationStep;
use App\repository\Contracts\RegistrationRepositoryInterface;
use App\Services\UploaderService;
use Exception;

readonly class RegistrationService
{

    public function __construct(
        private RegistrationRepositoryInterface $registrationRepository,
        private UserService                     $userService,
        private UploaderService                 $uploaderService
    )
    {}

    /**
     * @throws Exception
     */
    public function addProfileData($data)
    {
        $decodedData = json_decode($data, true);
        $this->userService->findUserByName($decodedData['user_name']);
        $registrationStep = new RegistrationStep([
            'data' => [
                'Profile_Data' => $this->removeTokenFromRequest($data)
            ],
            'current_step' => 1
        ]);
        $this->registrationRepository->addRegistrationStep($registrationStep);
        return $registrationStep->id;
    }

    /**
     * @throws Exception
     */
    public function addVerificationData($data): int
    {
        $data = json_decode($data, true);
        $this->checkIfEmailExists($data);
        $data['Verification_Data'] = $this->removeTokenFromRequest($this->removeIdFromRequest($data));

        return $this->processSaveDataInTwoSteps($data, 2);
    }

    /**
     * @throws Exception
     */
    public function addImageData($data, $filePath)
    {
        $data = $this->addImageUrl($data, $filePath);
        $data = json_decode($data, true);
        $data['Image_Data'] = $this->removeTokenFromRequest($this->removeIdFromRequest($data));

        return $this->processSaveDataInTwoSteps($data, 3);
    }

    /**
     * Process the common logic for saving registration data.
     *
     * @param array $data
     * @param int $newStep
     * @return int
     * @throws Exception
     */
    private function processSaveDataInTwoSteps(array $data, int $newStep): int
    {
        $registrationStep = $this->registrationRepository->findDraftUserById($data['id']) ?? throw new Exception('User not found.');

        $existingData['current_step'] = $registrationStep->current_step;
        $allData = $registrationStep->data;

        if (3 === $existingData['current_step']) {
            throw new \RuntimeException('User already completed the registration process.');
        }

        if ($newStep > $existingData['current_step']) {
            $existingData['current_step'] = $newStep;
        }

        $registrationStep->data = array_merge($allData, $data);
        $registrationStep->current_step = $existingData['current_step'];

        $this->registrationRepository->addRegistrationStep($registrationStep);

        if(3 === $newStep) {
            $this->makeRegistrationStepToBeUser($registrationStep->id);
        }

        return $registrationStep->id;
    }

    public function makeRequestDataJson($request): false|string
    {
        return json_encode($request->all());
    }

    private function addImageUrl($data, $filePath): false|string
    {
        $data = json_decode($data, true);
        $data['image_url'] = $filePath;
        return json_encode($data);
    }

    public function removeIdFromRequest($data): string
    {
        if (isset($data['id'])) {
            unset($data['id']);
        }

        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * @throws Exception
     */
    public function checkIfEmailExists($user): bool
    {
        if (!isset($user['email'])) {
            return 0;
        }
        return $this->userService->findUserNameByEmail($user['email']);
    }

    public function removeTokenFromRequest($data): string
    {
        $decodedData = json_decode($data, true);

        if (isset($decodedData['_token'])) {
            unset($decodedData['_token']);
        }

        return json_encode($decodedData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function uploadFileAndReturnPath($request): string
    {
        return $this->uploaderService->uploadFileAndReturnPath($request);
    }

    public function makeRegistrationStepToBeUser($id)
    {
        $user = $this->registrationRepository->findDraftUserById($id);
        $this->userService->createUser($user->data);
    }

}
