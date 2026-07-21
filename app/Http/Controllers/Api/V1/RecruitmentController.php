<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Recruitment\StoreCandidateRequest;
use App\Http\Requests\Recruitment\StoreJobPostingRequest;
use App\Http\Requests\Recruitment\UpdateCandidateRequest;
use App\Http\Requests\Recruitment\UpdateJobPostingRequest;
use App\Http\Resources\Recruitment\CandidateResource;
use App\Http\Resources\Recruitment\JobApplicationResource;
use App\Http\Resources\Recruitment\JobPostingResource;
use App\Services\Recruitment\CandidateService;
use App\Services\Recruitment\JobPostingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecruitmentController extends BaseController
{
    private bool $isJob;

    public function __construct(
        private JobPostingService $jobPostingService,
        private CandidateService $candidateService
    ) {}

    private function resolve(): string
    {
        $path = request()->path();
        $this->isJob = str_contains($path, '/jobs') || str_contains($path, '/job-postings');
        return $this->isJob ? 'job' : 'candidate';
    }

    public function index(Request $request): JsonResponse
    {
        $this->resolve();
        if ($this->isJob) {
            $jobs = $this->jobPostingService->getAll($request->all());
            return $this->paginated($jobs, JobPostingResource::class);
        }
        $candidates = $this->candidateService->getAll($request->all());
        return $this->paginated($candidates, CandidateResource::class);
    }

    public function store(Request $request): JsonResponse
    {
        $this->resolve();
        if ($this->isJob) {
            $validated = app(StoreJobPostingRequest::class)->validated();
            $job = $this->jobPostingService->create($validated);
            return $this->created(new JobPostingResource($job), 'Job posting created');
        }
        $validated = app(StoreCandidateRequest::class)->validated();
        $candidate = $this->candidateService->create($validated);
        return $this->created(new CandidateResource($candidate), 'Candidate created');
    }

    public function show(int $id): JsonResponse
    {
        $this->resolve();
        if ($this->isJob) {
            $job = $this->jobPostingService->find($id);
            return $this->success(new JobPostingResource($job));
        }
        $candidate = $this->candidateService->find($id);
        return $this->success(new CandidateResource($candidate));
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $this->resolve();
        if ($this->isJob) {
            $validated = app(UpdateJobPostingRequest::class)->validated();
            $job = $this->jobPostingService->update($id, $validated);
            return $this->success(new JobPostingResource($job), 'Job posting updated');
        }
        $validated = app(UpdateCandidateRequest::class)->validated();
        $candidate = $this->candidateService->update($id, $validated);
        return $this->success(new CandidateResource($candidate), 'Candidate updated');
    }

    public function destroy(int $id): JsonResponse
    {
        $this->resolve();
        if ($this->isJob) {
            $this->jobPostingService->delete($id);
            return $this->noContent();
        }
        $this->candidateService->delete($id);
        return $this->noContent();
    }

    public function moveStage(Request $request, int $id): JsonResponse
    {
        $request->validate(['stage' => 'required|string']);
        $candidate = $this->candidateService->moveStage($id, $request->stage);
        return $this->success(new CandidateResource($candidate), 'Stage updated');
    }

    public function sendOffer(int $id): JsonResponse
    {
        $candidate = $this->candidateService->sendOffer($id);
        return $this->success(new CandidateResource($candidate), 'Offer sent');
    }

    public function pipeline(): JsonResponse
    {
        $pipeline = $this->jobPostingService->getPipeline();
        return $this->success($pipeline);
    }

    public function applications(int $jobId): JsonResponse
    {
        $job = $this->jobPostingService->find($jobId);
        return $this->paginated(
            $job->applications()->with('candidate')->paginate(20),
            JobApplicationResource::class
        );
    }
}
