<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Services\Recruitment\CandidateService;
use App\Services\Recruitment\JobPostingService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RecruitmentController extends Controller
{
    public function __construct(
        private JobPostingService $jobPostingService,
        private CandidateService $candidateService
    ) {}

    public function index()
    {
        $jobs = $this->jobPostingService->getAll(request()->all());
        $positions = Position::orderBy('title')->get(['id', 'title as name']);

        return Inertia::render('Recruitment/Index', [
            'jobs' => $jobs,
            'positions' => $positions,
            'filters' => request()->all(),
        ]);
    }

    public function show(int $id)
    {
        $job = $this->jobPostingService->find($id);
        $job->load(['applications.candidate']);

        return Inertia::render('Recruitment/Show', [
            'job' => $job,
        ]);
    }

    public function moveStage(Request $request, int $id)
    {
        $request->validate(['stage' => 'required|string', 'notes' => 'nullable|string']);
        $this->candidateService->moveStage($id, $request->stage);
        return redirect()->back();
    }

    public function sendOffer(int $id)
    {
        $this->candidateService->sendOffer($id);
        return redirect()->back();
    }
}
