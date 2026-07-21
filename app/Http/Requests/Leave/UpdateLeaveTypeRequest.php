<?php

namespace App\Http\Requests\Leave;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLeaveTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('leave-type.update');
    }

    public function rules(): array
    {
        $id = $this->route('leave_type');
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255', "unique:leave_types,name,{$id}"],
            'code' => ['sometimes', 'required', 'string', 'max:20', "unique:leave_types,code,{$id}"],
            'description' => ['nullable', 'string', 'max:1000'],
            'days_per_year' => ['sometimes', 'required', 'integer', 'min:0', 'max:365'],
            'max_consecutive_days' => ['nullable', 'integer', 'min:1'],
            'min_days_before' => ['nullable', 'integer', 'min:0'],
            'requires_attachment' => ['boolean'],
            'is_paid' => ['boolean'],
            'is_active' => ['boolean'],
            'color' => ['nullable', 'string', 'max:7'],
        ];
    }
}
