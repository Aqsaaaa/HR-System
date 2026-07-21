<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LeaveSeeder extends Seeder
{
    public function run(): void
    {
        $leaveTypes = [
            ['name' => 'Annual Leave', 'code' => 'ANNUAL', 'days_per_year' => 12, 'max_consecutive_days' => 14, 'is_paid' => true, 'color' => '#3B82F6'],
            ['name' => 'Sick Leave', 'code' => 'SICK', 'days_per_year' => 14, 'max_consecutive_days' => 5, 'is_paid' => true, 'color' => '#EF4444'],
            ['name' => 'Personal Leave', 'code' => 'PERSONAL', 'days_per_year' => 5, 'max_consecutive_days' => 3, 'is_paid' => true, 'color' => '#F59E0B'],
            ['name' => 'Maternity Leave', 'code' => 'MATERNITY', 'days_per_year' => 90, 'max_consecutive_days' => 90, 'is_paid' => true, 'color' => '#EC4899'],
            ['name' => 'Paternity Leave', 'code' => 'PATERNITY', 'days_per_year' => 5, 'max_consecutive_days' => 5, 'is_paid' => true, 'color' => '#8B5CF6'],
            ['name' => 'Marriage Leave', 'code' => 'MARRIAGE', 'days_per_year' => 3, 'max_consecutive_days' => 3, 'is_paid' => true, 'color' => '#10B981'],
            ['name' => 'Bereavement Leave', 'code' => 'BEREAVEMENT', 'days_per_year' => 3, 'max_consecutive_days' => 3, 'is_paid' => true, 'color' => '#6B7280'],
            ['name' => 'Unpaid Leave', 'code' => 'UNPAID', 'days_per_year' => 30, 'max_consecutive_days' => 30, 'is_paid' => false, 'color' => '#9CA3AF'],
        ];

        foreach ($leaveTypes as $data) {
            $data['created_by'] = 1;
            LeaveType::create($data);
        }

        $employees = Employee::all();
        $types = LeaveType::all();

        foreach ($employees as $employee) {
            foreach ($types as $type) {
                if (in_array($type->code, ['MATERNITY', 'PATERNITY', 'MARRIAGE', 'BEREAVEMENT'])) {
                    continue;
                }

                LeaveBalance::create([
                    'employee_id' => $employee->id,
                    'leave_type_id' => $type->id,
                    'year' => now()->year,
                    'total_days' => $type->days_per_year,
                    'used_days' => 0,
                    'pending_days' => 0,
                    'remaining_days' => $type->days_per_year,
                    'carried_forward' => 0,
                ]);
            }
        }

        $annual = $types->firstWhere('code', 'ANNUAL');
        $sick = $types->firstWhere('code', 'SICK');

        foreach ($employees->take(5) as $employee) {
            $start = now()->startOfMonth()->addDays(5);
            LeaveRequest::create([
                'leave_request_no' => 'LV-' . now()->format('Ymd') . '-' . str_pad((string) rand(1, 999), 4, '0', STR_PAD_LEFT),
                'employee_id' => $employee->id,
                'leave_type_id' => $annual->id,
                'start_date' => $start->format('Y-m-d'),
                'end_date' => $start->addDays(2)->format('Y-m-d'),
                'total_days' => 3,
                'status' => 'approved',
                'reason' => 'Annual vacation',
                'applied_on' => now()->subDays(7)->format('Y-m-d'),
                'created_by' => 1,
            ]);

            LeaveBalance::where('employee_id', $employee->id)
                ->where('leave_type_id', $annual->id)
                ->update([
                    'used_days' => 3,
                    'remaining_days' => \DB::raw('total_days + carried_forward - used_days - pending_days'),
                ]);
        }
    }
}
