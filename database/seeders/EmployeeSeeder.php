<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@hris.local')->first();
        $hr = User::where('email', 'hr@hris.local')->first();

        $departments = Department::all();
        $positions = Position::all();

        $employeeId = 1;

        $employees = [
            ['first_name' => 'John', 'last_name' => 'Smith', 'email' => 'john.smith@hris.local', 'department' => 'Engineering', 'position' => 'Engineering Manager', 'employment_type' => 'full_time', 'hire_date' => '2024-01-15', 'user_id' => $admin?->id],
            ['first_name' => 'Sarah', 'last_name' => 'Johnson', 'email' => 'sarah.johnson@hris.local', 'department' => 'Human Resources', 'position' => 'HR Manager', 'employment_type' => 'full_time', 'hire_date' => '2024-01-15', 'user_id' => $hr?->id],
            ['first_name' => 'Michael', 'last_name' => 'Chen', 'email' => 'michael.chen@hris.local', 'department' => 'Engineering', 'position' => 'Senior Software Engineer', 'employment_type' => 'full_time', 'hire_date' => '2024-02-01'],
            ['first_name' => 'Emily', 'last_name' => 'Davis', 'email' => 'emily.davis@hris.local', 'department' => 'Human Resources', 'position' => 'HR Staff', 'employment_type' => 'full_time', 'hire_date' => '2024-03-01'],
            ['first_name' => 'James', 'last_name' => 'Wilson', 'email' => 'james.wilson@hris.local', 'department' => 'Finance', 'position' => 'Finance Manager', 'employment_type' => 'full_time', 'hire_date' => '2024-01-20'],
            ['first_name' => 'Maria', 'last_name' => 'Garcia', 'email' => 'maria.garcia@hris.local', 'department' => 'Finance', 'position' => 'Accountant', 'employment_type' => 'full_time', 'hire_date' => '2024-04-01'],
            ['first_name' => 'David', 'last_name' => 'Brown', 'email' => 'david.brown@hris.local', 'department' => 'Marketing', 'position' => 'Marketing Manager', 'employment_type' => 'full_time', 'hire_date' => '2024-02-15'],
            ['first_name' => 'Lisa', 'last_name' => 'Anderson', 'email' => 'lisa.anderson@hris.local', 'department' => 'Marketing', 'position' => 'Marketing Manager', 'employment_type' => 'full_time', 'hire_date' => '2024-05-01'],
            ['first_name' => 'Robert', 'last_name' => 'Taylor', 'email' => 'robert.taylor@hris.local', 'department' => 'Operations', 'position' => 'Operations Manager', 'employment_type' => 'full_time', 'hire_date' => '2024-01-25'],
            ['first_name' => 'Jennifer', 'last_name' => 'Martinez', 'email' => 'jennifer.martinez@hris.local', 'department' => 'Operations', 'position' => 'Operations Manager', 'employment_type' => 'full_time', 'hire_date' => '2024-06-01'],
            ['first_name' => 'William', 'last_name' => 'Lee', 'email' => 'william.lee@hris.local', 'department' => 'Engineering', 'position' => 'Software Engineer', 'employment_type' => 'full_time', 'hire_date' => '2024-06-15'],
            ['first_name' => 'Amanda', 'last_name' => 'White', 'email' => 'amanda.white@hris.local', 'department' => 'Human Resources', 'position' => 'HR Staff', 'employment_type' => 'full_time', 'hire_date' => '2024-07-01'],
            ['first_name' => 'Daniel', 'last_name' => 'Thompson', 'email' => 'daniel.thompson@hris.local', 'department' => 'Finance', 'position' => 'Accountant', 'employment_type' => 'full_time', 'hire_date' => '2024-07-15'],
            ['first_name' => 'Jessica', 'last_name' => 'Robinson', 'email' => 'jessica.robinson@hris.local', 'department' => 'Marketing', 'position' => 'Marketing Manager', 'employment_type' => 'full_time', 'hire_date' => '2024-08-01'],
            ['first_name' => 'Christopher', 'last_name' => 'Hall', 'email' => 'christopher.hall@hris.local', 'department' => 'Operations', 'position' => 'Operations Manager', 'employment_type' => 'full_time', 'hire_date' => '2024-08-15'],
            ['first_name' => 'Stephanie', 'last_name' => 'Young', 'email' => 'stephanie.young@hris.local', 'department' => 'Engineering', 'position' => 'Junior Software Engineer', 'employment_type' => 'contract', 'hire_date' => '2024-09-01'],
            ['first_name' => 'Kevin', 'last_name' => 'King', 'email' => 'kevin.king@hris.local', 'department' => 'Finance', 'position' => 'Accountant', 'employment_type' => 'full_time', 'hire_date' => '2024-09-15'],
            ['first_name' => 'Rachel', 'last_name' => 'Wright', 'email' => 'rachel.wright@hris.local', 'department' => 'Human Resources', 'position' => 'HR Staff', 'employment_type' => 'full_time', 'hire_date' => '2024-10-01'],
            ['first_name' => 'Brian', 'last_name' => 'Scott', 'email' => 'brian.scott@hris.local', 'department' => 'Marketing', 'position' => 'Marketing Manager', 'employment_type' => 'full_time', 'hire_date' => '2024-10-15'],
            ['first_name' => 'Michelle', 'last_name' => 'Turner', 'email' => 'michelle.turner@hris.local', 'department' => 'Operations', 'position' => 'Operations Manager', 'employment_type' => 'full_time', 'hire_date' => '2024-11-01'],
        ];

        foreach ($employees as $data) {
            $department = $departments->firstWhere('name', $data['department']);
            $position = $positions->firstWhere('title', $data['position']);

            Employee::create([
                'employee_id' => 'EMP' . now()->format('y') . str_pad((string) $employeeId++, 5, '0', STR_PAD_LEFT),
                'user_id' => $data['user_id'] ?? null,
                'department_id' => $department?->id,
                'position_id' => $position?->id,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'employment_type' => $data['employment_type'],
                'employment_status' => 'active',
                'hire_date' => $data['hire_date'],
                'created_by' => User::first()?->id,
            ]);
        }
    }
}
