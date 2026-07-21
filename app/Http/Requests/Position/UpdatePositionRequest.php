<?php

namespace App\Http\Requests\Position;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePositionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('position.update');
    }

    public function rules(): array
    {
        return [
            'department_id' => ['sometimes', 'exists:departments,id'],
            'parent_id' => ['nullable', 'exists:positions,id'],
            'title' => ['sometimes', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:20', Rule::unique('positions')->ignore($this->route('position'))],
            'description' => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
            'responsibilities' => ['nullable', 'string'],
            'min_salary' => ['nullable', 'numeric', 'min:0'],
            'max_salary' => ['nullable', 'numeric', 'min:0', 'gte:min_salary'],
            'salary_currency' => ['nullable', 'string', 'size:3'],
            'employment_type' => ['sometimes', 'in:full_time,part_time,contract,internship'],
            'max_headcount' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['boolean'],
        ];
    }
}
