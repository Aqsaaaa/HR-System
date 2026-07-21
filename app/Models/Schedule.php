<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use Filterable, SoftDeletes;

    protected $fillable = [
        'employee_id', 'name', 'day_of_week', 'start_time', 'end_time',
        'break_start', 'break_end', 'total_working_hours',
        'is_active', 'effective_from', 'effective_to', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
            'break_start' => 'datetime:H:i',
            'break_end' => 'datetime:H:i',
            'is_active' => 'boolean',
            'effective_from' => 'date',
            'effective_to' => 'date',
            'total_working_hours' => 'decimal:2',
        ];
    }

    protected array $sortable = ['day_of_week', 'start_time', 'created_at'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
