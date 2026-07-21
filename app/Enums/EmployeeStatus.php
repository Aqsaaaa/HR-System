<?php

namespace App\Enums;

enum EmployeeStatus: string
{
    case ACTIVE = 'active';
    case RESIGNED = 'resigned';
    case TERMINATED = 'terminated';
    case SUSPENDED = 'suspended';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::RESIGNED => 'Resigned',
            self::TERMINATED => 'Terminated',
            self::SUSPENDED => 'Suspended',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ACTIVE => 'green',
            self::RESIGNED => 'yellow',
            self::TERMINATED => 'red',
            self::SUSPENDED => 'orange',
        };
    }
}
