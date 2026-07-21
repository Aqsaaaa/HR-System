<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('attendance.create');
    }

    public function rules(): array
    {
        return [
            'employee_id' => ['required', 'exists:employees,id'],
            'date' => ['required', 'date'],
            'clock_in' => ['required', 'date'],
            'clock_out' => ['nullable', 'date', 'after:clock_in'],
            'status' => ['required', 'string', 'in:present,late,absent,half_day,holiday,on_leave'],
            'type' => ['nullable', 'string', 'in:office,remote,field'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }
}
