<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->first_name . ' ' . $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'avatar' => $this->avatar ? url("storage/avatars/{$this->avatar}") : null,
            'department' => new DepartmentResource($this->whenLoaded('department')),
            'position' => new PositionResource($this->whenLoaded('position')),
            'employment_type' => $this->employment_type,
            'employment_status' => $this->employment_status,
            'hire_date' => $this->hire_date,
            'created_at' => $this->created_at,
        ];
    }
}
