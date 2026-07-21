<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollRun extends Model
{
    use Filterable, SoftDeletes;

    protected $fillable = [
        'name', 'period_type', 'month', 'year', 'period_start', 'period_end',
        'payment_date', 'status', 'total_gross', 'total_deductions', 'total_net',
        'total_employees', 'notes', 'processed_at', 'completed_at',
        'processed_by', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'period_start' => 'date',
            'period_end' => 'date',
            'payment_date' => 'date',
            'processed_at' => 'datetime',
            'completed_at' => 'datetime',
            'total_gross' => 'decimal:2',
            'total_deductions' => 'decimal:2',
            'total_net' => 'decimal:2',
            'total_employees' => 'integer',
        ];
    }

    protected array $sortable = ['year', 'month', 'created_at', 'status'];

    public function payslips(): HasMany
    {
        return $this->hasMany(Payslip::class);
    }

    public function adjustments(): HasMany
    {
        return $this->hasMany(PayrollAdjustment::class);
    }

    public function processedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
