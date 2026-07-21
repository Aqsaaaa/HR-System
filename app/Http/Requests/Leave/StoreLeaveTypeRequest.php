<?php

namespace App\Http\Requests\Leave;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeaveTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('leave-type.create');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:leave_types,name'],
            'code' => ['required', 'string', 'max:20', 'unique:leave_types,code'],
            'description' => ['nullable', 'string', 'max:1000'],
            'days_per_year' => ['required', 'integer', 'min:0', 'max:365'],
            'max_consecutive_days' => ['nullable', 'integer', 'min:1'],
            'min_days_before' => ['nullable', 'integer', 'min:0'],
            'requires_attachment' => ['boolean'],
            'is_paid' => ['boolean'],
            'is_active' => ['boolean'],
            'color' => ['nullable', 'string', 'max:7'],
        ];
    }
}
