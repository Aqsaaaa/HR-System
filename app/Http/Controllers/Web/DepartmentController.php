<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('parent', 'manager:id,first_name,last_name')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return Inertia::render('Departments/Index', [
            'departments' => $departments,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:departments,id',
            'location' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $data['created_by'] = auth()->id();
        $data['is_active'] = $data['is_active'] ?? true;

        Department::create($data);

        return redirect()->back()->with('success', 'Department created.');
    }

    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:departments,id',
            'location' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $department->update($data);

        return redirect()->back()->with('success', 'Department updated.');
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect()->back()->with('success', 'Department deleted.');
    }
}
