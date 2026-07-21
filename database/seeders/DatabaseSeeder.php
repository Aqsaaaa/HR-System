<?php

namespace Database\Seeders;

use Database\Seeders\Auth\AdminUserSeeder;
use Database\Seeders\Auth\RolesAndPermissionsSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            AdminUserSeeder::class,
            OrganizationSeeder::class,
            EmployeeSeeder::class,
        ]);
    }
}
