<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        $executive = Department::create(['name' => 'Executive', 'code' => 'EXEC', 'sort_order' => 1]);
        $hr = Department::create(['name' => 'Human Resources', 'code' => 'HR', 'sort_order' => 2]);
        $engineering = Department::create(['name' => 'Engineering', 'code' => 'ENG', 'sort_order' => 3]);
        $finance = Department::create(['name' => 'Finance', 'code' => 'FIN', 'sort_order' => 4]);
        $marketing = Department::create(['name' => 'Marketing', 'code' => 'MKT', 'sort_order' => 5]);
        $operations = Department::create(['name' => 'Operations', 'code' => 'OPS', 'sort_order' => 6]);

        Position::create(['department_id' => $hr->id, 'title' => 'HR Manager', 'code' => 'HR-MGR', 'employment_type' => 'full_time']);
        Position::create(['department_id' => $hr->id, 'title' => 'HR Staff', 'code' => 'HR-STF', 'employment_type' => 'full_time']);
        Position::create(['department_id' => $engineering->id, 'title' => 'Engineering Manager', 'code' => 'ENG-MGR', 'employment_type' => 'full_time']);
        Position::create(['department_id' => $engineering->id, 'title' => 'Senior Software Engineer', 'code' => 'ENG-SSE', 'employment_type' => 'full_time']);
        Position::create(['department_id' => $engineering->id, 'title' => 'Software Engineer', 'code' => 'ENG-SE', 'employment_type' => 'full_time']);
        Position::create(['department_id' => $engineering->id, 'title' => 'Junior Software Engineer', 'code' => 'ENG-JSE', 'employment_type' => 'full_time']);
        Position::create(['department_id' => $finance->id, 'title' => 'Finance Manager', 'code' => 'FIN-MGR', 'employment_type' => 'full_time']);
        Position::create(['department_id' => $finance->id, 'title' => 'Accountant', 'code' => 'FIN-ACC', 'employment_type' => 'full_time']);
        Position::create(['department_id' => $marketing->id, 'title' => 'Marketing Manager', 'code' => 'MKT-MGR', 'employment_type' => 'full_time']);
        Position::create(['department_id' => $operations->id, 'title' => 'Operations Manager', 'code' => 'OPS-MGR', 'employment_type' => 'full_time']);

        $this->command->info('Default departments and positions created.');
    }
}
