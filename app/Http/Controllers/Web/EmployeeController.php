<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Position;
use App\Services\Employee\EmployeeService;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public function __construct(
        private EmployeeService $employeeService
    ) {}

    public function index()
    {
        $employees = $this->employeeService->getAll(request()->all());
        return Inertia::render('Employees/Index', [
            'employees' => $employees,
            'filters' => request()->all(),
        ]);
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        $positions = Position::orderBy('title')->get();
        return Inertia::render('Employees/Create', [
            'departments' => $departments,
            'positions' => $positions,
        ]);
    }

    public function show(int $id)
    {
        $employee = $this->employeeService->find($id);
        return Inertia::render('Employees/Show', [
            'employee' => $employee,
        ]);
    }

    public function edit(int $id)
    {
        $employee = $this->employeeService->find($id);
        $departments = Department::orderBy('name')->get();
        $positions = Position::orderBy('title')->get();
        return Inertia::render('Employees/Edit', [
            'employee' => $employee,
            'departments' => $departments,
            'positions' => $positions,
        ]);
    }
}
