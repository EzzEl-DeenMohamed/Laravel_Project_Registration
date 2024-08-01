<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class RegisterPost2 extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8',
            'email' => 'required|string|email|unique:users,email|max:255',
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
            'phone.required' => 'Phone number is required.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'This email has already been taken.',
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
