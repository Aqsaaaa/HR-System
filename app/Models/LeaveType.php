<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveType extends Model
{
    use Filterable, SoftDeletes;

    protected $fillable = [
        'name', 'code', 'description', 'days_per_year', 'max_consecutive_days',
        'min_days_before', 'requires_attachment', 'is_paid', 'is_active',
        'color', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'days_per_year' => 'integer',
            'max_consecutive_days' => 'integer',
            'min_days_before' => 'integer',
            'requires_attachment' => 'boolean',
            'is_paid' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    protected array $sortable = ['name', 'days_per_year', 'created_at'];

    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function balances(): HasMany
    {
        return $this->hasMany(LeaveBalance::class);
    }
}
