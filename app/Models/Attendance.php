<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use Filterable, SoftDeletes;

    protected $fillable = [
        'employee_id', 'date', 'clock_in', 'clock_out', 'status', 'type',
        'latitude_in', 'longitude_in', 'latitude_out', 'longitude_out',
        'ip_address_in', 'ip_address_out', 'device_in', 'device_out',
        'photo_in', 'photo_out', 'notes', 'total_hours', 'overtime_hours',
        'is_approved', 'approved_by', 'approved_at', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'clock_in' => 'datetime',
            'clock_out' => 'datetime',
            'is_approved' => 'boolean',
            'approved_at' => 'datetime',
            'total_hours' => 'decimal:2',
            'overtime_hours' => 'decimal:2',
        ];
    }

    protected array $sortable = ['date', 'clock_in', 'clock_out', 'status', 'created_at'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function approvedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
