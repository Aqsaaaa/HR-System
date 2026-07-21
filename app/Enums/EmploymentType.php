<?php

namespace App\Enums;

enum EmploymentType: string
{
    case PERMANENT = 'permanent';
    case CONTRACT = 'contract';
    case INTERN = 'intern';
    case PROBATION = 'probation';

    public function label(): string
    {
        return match ($this) {
            self::PERMANENT => 'Permanent',
            self::CONTRACT => 'Contract',
            self::INTERN => 'Intern',
            self::PROBATION => 'Probation',
        };
    }
}
