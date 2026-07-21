<?php

namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('department.create');
    }

    public function rules(): array
    {
        return [
            'parent_id' => ['nullable', 'exists:departments,id'],
            'name' => ['required', 'string', 'max:255', 'unique:departments,name'],
            'code' => ['nullable', 'string', 'max:20', 'unique:departments,code'],
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
