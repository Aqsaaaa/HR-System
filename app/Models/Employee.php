<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use Filterable, SoftDeletes;

    protected $fillable = [
        'employee_id', 'user_id', 'department_id', 'position_id', 'report_to',
        'first_name', 'last_name', 'email', 'personal_email', 'phone',
        'emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relation',
        'avatar', 'gender', 'date_of_birth', 'marital_status', 'nationality',
        'identity_number', 'identity_type', 'address', 'city', 'state',
        'postal_code', 'country', 'employment_type', 'employment_status',
        'hire_date', 'probation_end_date', 'confirmation_date',
        'resignation_date', 'termination_date', 'termination_reason',
        'source_of_hire', 'branch', 'bank_details', 'tax_details',
        'education', 'certifications', 'skills', 'custom_fields',
        'notes', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'hire_date' => 'date',
            'probation_end_date' => 'date',
            'confirmation_date' => 'date',
            'resignation_date' => 'date',
            'termination_date' => 'date',
            'date_of_birth' => 'date',
            'bank_details' => 'json',
            'tax_details' => 'json',
            'education' => 'json',
            'certifications' => 'json',
            'skills' => 'json',
            'custom_fields' => 'json',
        ];
    }

    protected array $sortable = ['first_name', 'last_name', 'employee_id', 'email', 'hire_date', 'created_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function reportsTo(): BelongsTo
    {
        return $this->belongsTo(self::class, 'report_to');
    }

    public function subordinates(): HasMany
    {
        return $this->hasMany(self::class, 'report_to');
    }

    public function managedDepartment(): HasOne
    {
        return $this->hasOne(Department::class, 'manager_id');
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
