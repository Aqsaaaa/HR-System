<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Goal;
use App\Models\PerformanceCycle;
use App\Models\PerformanceReview;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PerformanceSeeder extends Seeder
{
    public function run(): void
    {
        $cycle = PerformanceCycle::create([
            'name' => 'Q3 2026 Performance Review',
            'start_date' => Carbon::now()->startOfQuarter(),
            'end_date' => Carbon::now()->endOfQuarter(),
            'status' => 'active',
            'description' => 'Quarterly performance review for all employees.',
            'created_by' => 1,
        ]);

        $employees = Employee::all();

        foreach ($employees as $i => $emp) {
            Goal::create([
                'employee_id' => $emp->id,
                'cycle_id' => $cycle->id,
                'title' => 'Complete HRIS project milestones',
                'description' => 'Deliver key features for the internal HRIS platform.',
                'key_results' => [['title' => 'Backend API completion', 'progress' => 75], ['title' => 'Frontend integration', 'progress' => 60]],
                'weight' => 40,
                'progress' => rand(30, 100),
                'status' => rand(0, 1) ? 'completed' : 'active',
                'due_date' => $cycle->end_date,
                'created_by' => 1,
            ]);

            if ($i % 3 === 0) {
                PerformanceReview::create([
                    'cycle_id' => $cycle->id,
                    'employee_id' => $emp->id,
                    'reviewer_id' => $employees->first()->id,
                    'rating' => rand(60, 95),
                    'comments' => 'Good performance this quarter.',
                    'strengths' => 'Strong technical skills, good teamwork.',
                    'improvements' => 'Could improve documentation.',
                    'status' => 'completed',
                    'submitted_at' => Carbon::now()->subDays(rand(1, 10)),
                    'completed_at' => Carbon::now()->subDays(rand(0, 5)),
                    'created_by' => 1,
                ]);
            }
        }
    }
}
