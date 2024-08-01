<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class RegisterPost3 extends FormRequest
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
            'messageType' => 'required|string',
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
