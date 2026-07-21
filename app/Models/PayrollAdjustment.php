<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayrollAdjustment extends Model
{
    use Filterable;

    protected $fillable = [
        'payroll_run_id', 'employee_id', 'payroll_component_id',
        'type', 'amount', 'currency', 'reason',
        'is_recurring', 'status', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'is_recurring' => 'boolean',
        ];
    }

    public function payrollRun(): BelongsTo
    {
        return $this->belongsTo(PayrollRun::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function component(): BelongsTo
    {
        return $this->belongsTo(PayrollComponent::class, 'payroll_component_id');
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
