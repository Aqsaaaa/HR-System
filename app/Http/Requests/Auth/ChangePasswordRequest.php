<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:12', 'confirmed', 'different:current_password'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.min' => 'Password must be at least 12 characters.',
            'password.different' => 'New password must be different from current password.',
        ];
    }
}
