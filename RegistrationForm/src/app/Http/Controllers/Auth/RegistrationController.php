<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\DraftUser;
use App\Services\Auth\RegistrationService;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    private RegistrationService $registrationService;

    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    public function registration()
    {
        // Check if a draft user exists
        $draftUser = DraftUser::first();

        // If no draft user exists, create one with default values
        if (!$draftUser) {
            $draftUser = DraftUser::create([
                'user_name' => '', // Default empty values
                'full_name' => '',
                'birthdate' => '',
                'address' => '',
                'phone' => '',
                'email' => '',
                'password' => '',
                'image_url' => '',
                'current_status' => 'Step1',
                'user_type' => 'user',
            ]);
        }

        return view('registration', ['draftUser' => $draftUser]);
    }

    public function registrationPost(Request $request)
    {
        try {
            $draftUser = DraftUser::where('user_name', $request->user_mame)->first();


            if ($draftUser) {
                // Update the user's fields
                $draftUser->full_name = $request->input('full_name');
                $draftUser->birthdate = $request->input('birthdate');
                $draftUser->user_name = $request->input('user_name');
                $draftUser->user_name = $request->input('address');
                $draftUser->user_type = 'user';
                $draftUser->current_status = 'Step1';

                // Save the changes
                $draftUser->save();
            } else {
                // Handle the case where the user is not found
                return redirect()->back()->with('error', 'Draft user not found.');
            }

            session(['user_name' => $request->user_name]);

            return redirect()->route('registration2');
        } catch (\Exception $e) {
            \Log::error('Error creating or updating draft user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while processing your request.');
        }
    }

    public function registration2()
    {
        $draftUser = DraftUser::first();
        return view('registration2', ['draftUser' => $draftUser]);
    }

    public function registrationPost2(Request $request)
    {
        try {
            $userName = session('user_name');

            // Find the draft user by user name
            $draftUser = DraftUser::where('user_name', $userName)->first();

            if ($draftUser) {
                // Update the user's fields
                $draftUser->phone = $request->input('phone');
                $draftUser->email = $request->input('email');
                $draftUser->password = bcrypt($request->input('password'));
                $draftUser->current_status = 'Step2';

                // Save the changes
                $draftUser->save();
            } else {
                // Handle the case where the user is not found
                return redirect()->back()->with('error', 'Draft user not found.');
            }

            return redirect()->route('registration3');
        } catch (\Exception $e) {
            \Log::error('Error updating draft user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while processing your request.');
        }
    }


    public function registration3()
    {
        $draftUser = DraftUser::first();
        return view('registration3', ['draftUser' => $draftUser]);
    }

    public function registrationPost3(Request $request)
    {
        try {
            $draftUser = DraftUser::where('user_name', session('user_name'))->first();

            if ($draftUser) {
                // Update the user's fields
                $draftUser->address = $request->input('address');
                $draftUser->current_status = 'Step3';

                // Save the changes
                $draftUser->save();
            } else {
                // Handle the case where the user is not found
                return redirect()->back()->with('error', 'Draft user not found.');
            }

            return redirect()->route('home');
        } catch (\Exception $e) {
            \Log::error('Error updating draft user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while processing your request.');
        }
    }
}
