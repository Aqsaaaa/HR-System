<?php

namespace App\Http\Resources\Attendance;

use App\Http\Resources\EmployeeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
            'date' => $this->date,
            'clock_in' => $this->clock_in,
            'clock_out' => $this->clock_out,
            'status' => $this->status,
            'type' => $this->type,
            'total_hours' => $this->total_hours,
            'overtime_hours' => $this->overtime_hours,
            'is_approved' => $this->is_approved,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
        ];
    }
}
