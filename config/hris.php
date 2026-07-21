<?php

return [
    'name' => env('HRIS_NAME', 'Enterprise HRIS'),
    'version' => '1.0.0',

    'employee' => [
        'id_prefix' => env('HRIS_EMPLOYEE_ID_PREFIX', 'EMP'),
        'id_pad_length' => 4,
        'max_document_size' => 10485760,
        'allowed_document_types' => ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'],
    ],

    'attendance' => [
        'grace_period_minutes' => 15,
        'auto_clock_out' => true,
        'auto_clock_out_time' => '00:00',
        'weekly_max_hours' => 48,
        'geolocation_enabled' => false,
        'max_clock_pairs_per_day' => 2,
    ],

    'leave' => [
        'max_consecutive_days' => 30,
        'carry_forward_max_days' => 5,
        'sick_leave_document_threshold' => 3,
        'min_days_before_request' => 1,
    ],

    'payroll' => [
        'overtime_rate' => 1.5,
        'holiday_overtime_rate' => 2.0,
        'currency' => env('HRIS_CURRENCY', 'USD'),
    ],

    'notification' => [
        'retention_days' => 90,
        'email_digest_enabled' => false,
    ],

    'audit' => [
        'retention_years' => 7,
        'log_read_operations' => false,
    ],

    'pagination' => [
        'default_per_page' => 15,
        'max_per_page' => 100,
    ],

    'admin_email' => env('HRIS_ADMIN_EMAIL', 'admin@hris.local'),
];
