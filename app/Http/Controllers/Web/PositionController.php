<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::with('department:id,name')
            ->orderBy('title')
            ->paginate(20);

        $departments = Department::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Positions/Index', [
            'positions' => $positions,
            'departments' => $departments,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'employment_type' => 'nullable|string|max:50',
            'min_salary' => 'nullable|numeric|min:0',
            'max_salary' => 'nullable|numeric|min:0',
            'max_headcount' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data['created_by'] = auth()->id();
        $data['is_active'] = $data['is_active'] ?? true;

        Position::create($data);

        return redirect()->back()->with('success', 'Position created.');
    }

    public function update(Request $request, $id)
    {
        $position = Position::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'employment_type' => 'nullable|string|max:50',
            'min_salary' => 'nullable|numeric|min:0',
            'max_salary' => 'nullable|numeric|min:0',
            'max_headcount' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $position->update($data);

        return redirect()->back()->with('success', 'Position updated.');
    }

    public function destroy($id)
    {
        $position = Position::findOrFail($id);
        $position->delete();

        return redirect()->back()->with('success', 'Position deleted.');
    }
}
