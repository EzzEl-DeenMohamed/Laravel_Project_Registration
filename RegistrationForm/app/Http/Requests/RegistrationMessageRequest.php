<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'messageType' => 'required|in:email,phone',
            'birthdate' => 'required|date',
            'phone' => 'nullable|string|max:15',
            'address' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required_if:messageType,email|nullable|email|max:255',
            'phone' => 'required_if:messageType,phone|nullable|string|max:15',
            //
        ];
    }
}
