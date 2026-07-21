<?php

namespace App\Http\Requests\Payroll;

use Illuminate\Foundation\Http\FormRequest;

class StorePayrollComponentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('payroll.create.run');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:payroll_components,name'],
            'code' => ['required', 'string', 'max:50', 'unique:payroll_components,code'],
            'type' => ['required', 'string', 'in:earning,deduction'],
            'calculation_type' => ['required', 'string', 'in:fixed,percentage,formula'],
            'default_value' => ['required', 'numeric', 'min:0'],
            'frequency' => ['nullable', 'string', 'in:monthly,yearly,one_time'],
            'is_taxable' => ['boolean'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
