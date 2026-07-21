<?php

namespace App\Http\Resources\Leave;

use App\Http\Resources\EmployeeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveRequestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'leave_request_no' => $this->leave_request_no,
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
            'leave_type' => new LeaveTypeResource($this->whenLoaded('leaveType')),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'total_days' => $this->total_days,
            'duration_type' => $this->duration_type,
            'status' => $this->status,
            'reason' => $this->reason,
            'notes' => $this->notes,
            'contact_number' => $this->contact_number,
            'address_during_leave' => $this->address_during_leave,
            'approved_by' => $this->approved_by,
            'approved_at' => $this->approved_at,
            'approval_notes' => $this->approval_notes,
            'applied_on' => $this->applied_on,
            'created_at' => $this->created_at,
        ];
    }
}
