<?php

namespace Database\Seeders\Auth;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@hris.local'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('super-admin');

        $hr = User::updateOrCreate(
            ['email' => 'hr@hris.local'],
            [
                'name' => 'HR Manager',
                'password' => bcrypt('password'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        $hr->assignRole('hr-manager');

        $emp = User::updateOrCreate(
            ['email' => 'employee@hris.local'],
            [
                'name' => 'Employee User',
                'password' => bcrypt('password'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        $emp->assignRole('employee');

        $this->command->info('Default users created:');
        $this->command->info('  admin@hris.local / password (Super Admin)');
        $this->command->info('  hr@hris.local / password (HR Manager)');
        $this->command->info('  employee@hris.local / password (Employee)');
    }
}
