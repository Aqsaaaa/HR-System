<?php

namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('department.update');
    }

    public function rules(): array
    {
        return [
            'parent_id' => ['nullable', 'exists:departments,id'],
            'name' => ['sometimes', 'string', 'max:255', Rule::unique('departments')->ignore($this->route('department'))],
            'code' => ['nullable', 'string', 'max:20', Rule::unique('departments')->ignore($this->route('department'))],
            'description' => ['nullable', 'string', 'max:1000'],
            'manager_id' => ['nullable', 'exists:employees,id'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'budget_currency' => ['nullable', 'string', 'size:3'],
            'cost_center' => ['nullable', 'string', 'max:50'],
            'location' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
