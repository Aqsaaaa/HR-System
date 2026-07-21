<?php

namespace Database\Seeders\Auth;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@hris.local',
            'password' => bcrypt('password'),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $admin->assignRole('super-admin');

        $hr = User::create([
            'name' => 'HR Manager',
            'email' => 'hr@hris.local',
            'password' => bcrypt('password'),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $hr->assignRole('hr-manager');

        $emp = User::create([
            'name' => 'Employee User',
            'email' => 'employee@hris.local',
            'password' => bcrypt('password'),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $emp->assignRole('employee');

        $this->command->info('Default users created:');
        $this->command->info('  admin@hris.local / password (Super Admin)');
        $this->command->info('  hr@hris.local / password (HR Manager)');
        $this->command->info('  employee@hris.local / password (Employee)');
    }
}
