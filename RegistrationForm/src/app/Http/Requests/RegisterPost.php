<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class RegisterPost extends FormRequest
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
            'full_name' => 'required|string|max:255',
            'user_name' => 'required|string|unique:users,user_name|max:255',
            'birthdate' => 'required|date',
            'address' => 'required|string|max:255',
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
            'full_name.required' => 'Full name is required.',
            'user_name.required' => 'User name is required.',
            'user_name.unique' => 'This user name has already been taken.',
            'birthdate.required' => 'Birthdate is required.',
            'birthdate.date' => 'Birthdate must be a valid date.',
            'address.required' => 'Address is required.',
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
