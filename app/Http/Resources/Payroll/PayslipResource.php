<?php

namespace App\Http\Resources\Payroll;

use App\Http\Resources\EmployeeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayslipResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'payslip_no' => $this->payslip_no,
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
            'basic_salary' => $this->basic_salary,
            'earnings' => $this->earnings,
            'deductions' => $this->deductions,
            'total_earnings' => $this->total_earnings,
            'total_deductions' => $this->total_deductions,
            'net_pay' => $this->net_pay,
            'tax_amount' => $this->tax_amount,
            'status' => $this->status,
            'paid_at' => $this->paid_at,
            'created_at' => $this->created_at,
        ];
    }
}
