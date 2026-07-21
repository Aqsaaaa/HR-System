<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('employee.update');
    }

    public function rules(): array
    {
        $id = $this->route('employee') ?? $this->route('id');

        return [
            'employee_id' => ['nullable', 'string', 'max:20', "unique:employees,employee_id,{$id}"],
            'user_id' => ['nullable', 'exists:users,id'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'position_id' => ['nullable', 'exists:positions,id'],
            'report_to' => ['nullable', 'exists:employees,id'],
            'first_name' => ['sometimes', 'required', 'string', 'max:255'],
            'last_name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'email', 'max:255', "unique:employees,email,{$id}"],
            'personal_email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:20'],
            'emergency_contact_relation' => ['nullable', 'string', 'max:100'],
            'gender' => ['nullable', 'string', 'in:male,female,other'],
            'date_of_birth' => ['nullable', 'date'],
            'marital_status' => ['nullable', 'string', 'max:50'],
            'nationality' => ['nullable', 'string', 'max:100'],
            'identity_number' => ['nullable', 'string', 'max:50'],
            'identity_type' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'employment_type' => ['sometimes', 'required', 'string', 'in:full_time,part_time,contract,intern,temporary'],
            'employment_status' => ['sometimes', 'required', 'string', 'in:active,inactive,terminated,resigned,suspended'],
            'hire_date' => ['sometimes', 'required', 'date'],
            'probation_end_date' => ['nullable', 'date', 'after:hire_date'],
            'confirmation_date' => ['nullable', 'date'],
            'resignation_date' => ['nullable', 'date'],
            'termination_date' => ['nullable', 'date'],
            'termination_reason' => ['nullable', 'string'],
            'source_of_hire' => ['nullable', 'string', 'max:100'],
            'branch' => ['nullable', 'string', 'max:100'],
            'bank_details' => ['nullable', 'json'],
            'tax_details' => ['nullable', 'json'],
            'education' => ['nullable', 'json'],
            'certifications' => ['nullable', 'json'],
            'skills' => ['nullable', 'json'],
            'custom_fields' => ['nullable', 'json'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
