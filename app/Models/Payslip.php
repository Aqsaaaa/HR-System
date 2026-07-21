<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payslip extends Model
{
    use Filterable, SoftDeletes;

    protected $fillable = [
        'payslip_no', 'payroll_run_id', 'employee_id', 'basic_salary',
        'earnings', 'deductions', 'total_earnings', 'total_deductions',
        'net_pay', 'tax_amount', 'adjustments', 'status', 'paid_at', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'earnings' => 'json',
            'deductions' => 'json',
            'adjustments' => 'json',
            'basic_salary' => 'decimal:2',
            'total_earnings' => 'decimal:2',
            'total_deductions' => 'decimal:2',
            'net_pay' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    protected array $sortable = ['created_at', 'net_pay', 'status'];

    public function payrollRun(): BelongsTo
    {
        return $this->belongsTo(PayrollRun::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
