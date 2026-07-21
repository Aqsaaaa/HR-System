<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Announcement\AnnouncementService;
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
}
