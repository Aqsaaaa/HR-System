<?php

namespace App\Http\Requests\Payroll;

use Illuminate\Foundation\Http\FormRequest;

class StorePayrollRunRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('payroll.create.run');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'period_type' => ['nullable', 'string', 'in:monthly,weekly,biweekly'],
            'month' => ['required', 'integer', 'min:1', 'max:12'],
            'year' => ['required', 'integer', 'min:2020', 'max:2099'],
            'period_start' => ['required', 'date'],
            'period_end' => ['required', 'date', 'after_or_equal:period_start'],
            'payment_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
