<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Announcement\AnnouncementService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AnnouncementController extends Controller
{
    public function __construct(
        private AnnouncementService $announcementService
    ) {}

    public function index()
    {
        $announcements = $this->announcementService->getAll(request()->all());

        return Inertia::render('Announcement/Index', [
            'announcements' => $announcements,
            'filters' => request()->all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'nullable|string|in:info,warning,urgent,achievement',
            'is_published' => 'boolean',
        ]);

        $this->announcementService->create($validated);

        return redirect()->back();
    }

    public function togglePin(int $id)
    {
        $this->announcementService->togglePin($id);
        return redirect()->back();
    }
}
