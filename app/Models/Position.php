<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use Filterable, SoftDeletes;

    protected $fillable = [
        'department_id', 'parent_id', 'title', 'code', 'description',
        'requirements', 'responsibilities', 'min_salary', 'max_salary',
        'salary_currency', 'employment_type', 'max_headcount',
        'current_headcount', 'is_active', 'sort_order', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'min_salary' => 'decimal:2',
            'max_salary' => 'decimal:2',
            'max_headcount' => 'integer',
            'current_headcount' => 'integer',
        ];
    }

    protected array $sortable = ['title', 'created_at'];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function jobPostings(): HasMany
    {
        return $this->hasMany(JobPosting::class);
    }

    public function isHeadcountAvailable(): bool
    {
        if (is_null($this->max_headcount)) {
            return true;
        }
        return $this->current_headcount < $this->max_headcount;
    }
}
