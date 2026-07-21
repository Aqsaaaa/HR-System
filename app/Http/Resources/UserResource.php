<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->avatar ? url("storage/avatars/{$this->avatar}") : null,
            'phone' => $this->phone,
            'timezone' => $this->timezone,
            'locale' => $this->locale,
            'is_active' => $this->is_active,
            'has_2fa' => !is_null($this->two_factor_confirmed_at),
            'is_super_admin' => $this->isSuperAdmin(),
            'roles' => $this->getRoleNames(),
            'permissions' => $this->getAllPermissions()->pluck('name'),
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
            'email_verified_at' => $this->email_verified_at,
            'last_login_at' => $this->last_login_at,
            'last_login_ip' => $this->last_login_ip,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
