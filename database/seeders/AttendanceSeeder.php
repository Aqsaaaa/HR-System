<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();
        $baseDate = Carbon::parse('2000-08-01');

        foreach ($employees as $employee) {
            for ($day = 1; $day <= 20; $day++) {
                $date = $baseDate->copy()->addDays($day - 1);

                if ($date->isWeekend()) {
                    continue;
                }

                $clockIn = $date->copy()->setHour(8)->setMinute(rand(0, 30))->setSecond(0);
                $clockOut = $date->copy()->setHour(17)->setMinute(rand(0, 30))->setSecond(0);
                $totalHours = $clockIn->diffInHours($clockOut);

                $status = $clockIn->format('H:i') > '08:15' ? 'late' : 'present';

                Attendance::create([
                    'employee_id' => $employee->id,
                    'date' => $date,
                    'clock_in' => $clockIn,
                    'clock_out' => $clockOut,
                    'status' => $status,
                    'type' => 'office',
                    'total_hours' => round($totalHours, 2),
                    'is_approved' => true,
                    'created_by' => 1,
                ]);
            }
        }

        // Create holidays
        $year = 2000;
        $holidays = [
            ['name' => 'New Year', 'date' => "{$year}-01-01", 'type' => 'national', 'is_recurring' => true],
            ['name' => 'Independence Day', 'date' => "{$year}-08-17", 'type' => 'national', 'is_recurring' => true],
            ['name' => 'Christmas', 'date' => "{$year}-12-25", 'type' => 'national', 'is_recurring' => true],
            ['name' => 'New Year Eve', 'date' => "{$year}-12-31", 'type' => 'national', 'is_recurring' => true],
        ];

        foreach ($holidays as $holiday) {
            Holiday::create($holiday + ['created_by' => 1]);
        }
    }
}
