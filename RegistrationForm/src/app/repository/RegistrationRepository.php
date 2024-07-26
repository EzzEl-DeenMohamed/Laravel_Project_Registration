<?php

namespace App\repository;

use App\Dtos\DtoRegister;
use App\Models\DraftUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegistrationRepository
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

    public function initializeDraftUserIfNotExist()
    {
        $draftUser = $this->getDraftUser(session('user_name'));

        if (!$draftUser) {
            $draftUser = DraftUser::create([
                'user_name' => '',
                'full_name' => '',
                'birthdate' => '1990-01-01',
                'address' => '',
                'phone' => '',
                'email' => '',
                'password' => '',
                'image_url' => '',
                'current_status' => 'Step1',
                'user_type' => 'user',
                'email_verified_at' => '',
            ]);
        }
        $this->saveUserNameSession($draftUser->user_name);
        return $draftUser;
    }

    public function addFirstDraftPage($request)
    {
        $draftUser = $this->getDraftUser($request->input('user_name'));

        if ($draftUser) {
            // Update the user's fields
            $draftUser->full_name = $request->input('full_name');
            $draftUser->user_name = $request->input('user_name');
            $draftUser->birthdate = $request->input('birthdate');
            $draftUser->address = $request->input('address');
            $draftUser->current_status = 'Step1';
            $draftUser->save();
            $this->saveUserNameSession($draftUser->user_name);
        } else {
            // Handle the case where the user is not found
            return redirect()->back()->with('error', 'Draft user not found.');
        }
    }

    public function addSecondDraftPage($request)
    {
        // Find the draft user by user name
        $draftUser = $this->getDraftUser(session('user_name'));

        if ($draftUser) {
            // Update the user's fields
            $draftUser->phone = $request->input('phone');
            $draftUser->email = $request->input('email');
            $draftUser->password = bcrypt($request->input('password'));
            $draftUser->current_status = 'Step2';

            // Save the changes
            $draftUser->save();
            $this->saveUserNameSession($draftUser->user_name);
        } else {
            // Handle the case where the user is not found
            return redirect()->back()->with('error', 'Draft user not found.');
        }
    }

    public function addThirdDraftPage($request)
    {
        // Find the draft user by user name
        $draftUser = $this->getDraftUser(session('user_name'));

        if ($draftUser) {
            // Update the user's fields
            $draftUser->image_url = $request->file('image_url')->store('images', 'public');
            $draftUser->email_verified_at = now();
            $draftUser->verified = $request->input('messageType');
            $draftUser->current_status = 'Step3';

            $draftUser->save();
            $this->saveUserNameSession($draftUser->user_name);
            session()->flush();
        } else {
            // Handle the case where the user is not found
            return redirect()->back()->with('error', 'Draft user not found.');
        }
    }

    public function getDraftUser($userName)
    {
        if(!$userName)
            return DraftUser::where('user_name', '')->first();

        return DraftUser::where('user_name', $userName)->first();
    }

    public function saveUserNameSession($userName)
    {
        session(['user_name' => $userName]);
    }

}
