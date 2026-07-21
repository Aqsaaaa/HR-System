<?php

namespace App\Http\Requests\Position;

use Illuminate\Foundation\Http\FormRequest;

class StorePositionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('position.create');
    }

    public function rules(): array
    {
        return [
            'department_id' => ['required', 'exists:departments,id'],
            'parent_id' => ['nullable', 'exists:positions,id'],
            'title' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:20', 'unique:positions,code'],
            'description' => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
            'responsibilities' => ['nullable', 'string'],
            'min_salary' => ['nullable', 'numeric', 'min:0'],
            'max_salary' => ['nullable', 'numeric', 'min:0', 'gte:min_salary'],
            'salary_currency' => ['nullable', 'string', 'size:3'],
            'employment_type' => ['required', 'in:full_time,part_time,contract,internship'],
            'max_headcount' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['boolean'],
        ];
    }
}
