<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:12', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.min' => 'Password must be at least 12 characters.',
        ];
    }
}
