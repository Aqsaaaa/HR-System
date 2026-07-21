<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Services\Performance\PerformanceCycleService;
use App\Services\Performance\GoalService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PerformanceController extends Controller
{
    public function __construct(
        private PerformanceCycleService $cycleService,
        private GoalService $goalService,
    ) {}

    public function index()
    {
        $cycles = $this->cycleService->getAll(request()->all());
        $employees = Employee::select('id', 'first_name', 'last_name')->get();

        return Inertia::render('Performance/Index', [
            'cycles' => $cycles,
            'employees' => $employees,
            'filters' => request()->all(),
        ]);
    }

    public function show(int $id)
    {
        $cycle = $this->cycleService->find($id);
        $cycle->load(['goals.employee', 'reviews.employee']);

        return Inertia::render('Performance/Show', [
            'cycle' => $cycle,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        $this->cycleService->create($validated);
        return redirect()->back();
    }

    public function launchCycle(int $id)
    {
        $this->cycleService->launch($id);
        return redirect()->back();
    }
}
