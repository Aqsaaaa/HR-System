<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveRequest extends Model
{
    use Filterable, SoftDeletes;

    protected $fillable = [
        'leave_request_no', 'employee_id', 'leave_type_id',
        'start_date', 'end_date', 'total_days', 'duration_type',
        'status', 'reason', 'notes', 'attachment', 'contact_number',
        'address_during_leave', 'approved_by', 'approved_at',
        'approval_notes', 'applied_on', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'applied_on' => 'date',
            'approved_at' => 'datetime',
            'total_days' => 'integer',
        ];
    }

    protected array $sortable = ['start_date', 'end_date', 'status', 'created_at'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function leaveType(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class);
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
