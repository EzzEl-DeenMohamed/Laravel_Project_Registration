<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class LoginPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ];
    }

    /**
     * Get custom error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
        ];
    }

    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
    {
        // Log the validation errors or perform other actions
        Log::error('Validation failed:', $validator->errors()->toArray());

        // Optionally throw a custom exception
        throw new ValidationException($validator);
    }
}
