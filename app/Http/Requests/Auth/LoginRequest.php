<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:255'],
            'abilities' => ['nullable', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'A valid email address is required.',
            'password.required' => 'Password is required.',
        ];
    }
}
