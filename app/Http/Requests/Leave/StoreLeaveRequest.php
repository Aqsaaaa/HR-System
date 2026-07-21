<?php

namespace App\Http\Requests\Leave;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'leave_type_id' => ['required', 'exists:leave_types,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'duration_type' => ['required', 'string', 'in:full_day,half_day_morning,half_day_afternoon,hourly'],
            'reason' => ['required', 'string', 'max:2000'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'contact_number' => ['nullable', 'string', 'max:20'],
            'address_during_leave' => ['nullable', 'string', 'max:500'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,jpg,png,doc,docx', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'start_date.after_or_equal' => 'Start date must be today or later.',
            'end_date.after_or_equal' => 'End date must be after or equal to start date.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('leave_type_id')) {
            $leaveType = \App\Models\LeaveType::find($this->leave_type_id);
            if ($leaveType && $leaveType->requires_attachment) {
                $this->merge(['requires_attachment' => true]);
            }
        }
    }
}
