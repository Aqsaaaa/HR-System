<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Performance\StorePerformanceCycleRequest;
use App\Http\Requests\Performance\StorePerformanceReviewRequest;
use App\Http\Requests\Performance\UpdatePerformanceCycleRequest;
use App\Http\Resources\Performance\PerformanceCycleResource;
use App\Http\Resources\Performance\PerformanceReviewResource;
use App\Services\Performance\PerformanceCycleService;
use App\Services\Performance\PerformanceReviewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PerformanceController extends BaseController
{
    private bool $isCycle;

    public function __construct(
        private PerformanceCycleService $cycleService,
        private PerformanceReviewService $reviewService
    ) {}

    private function resolve(): string
    {
        $path = request()->path();
        $this->isCycle = str_contains($path, '/cycles');
        return $this->isCycle ? 'cycle' : 'review';
    }

    public function index(Request $request): JsonResponse
    {
        $this->resolve();
        if ($this->isCycle) {
            return $this->paginated($this->cycleService->getAll($request->all()), PerformanceCycleResource::class);
        }
        return $this->paginated($this->reviewService->getAll($request->all()), PerformanceReviewResource::class);
    }

    public function store(Request $request): JsonResponse
    {
        $this->resolve();
        if ($this->isCycle) {
            $validated = app(StorePerformanceCycleRequest::class)->validated();
            $cycle = $this->cycleService->create($validated);
            return $this->created(new PerformanceCycleResource($cycle), 'Cycle created');
        }
        $validated = app(StorePerformanceReviewRequest::class)->validated();
        $review = $this->reviewService->create($validated);
        return $this->created(new PerformanceReviewResource($review), 'Review created');
    }

    public function show(int $id): JsonResponse
    {
        $this->resolve();
        if ($this->isCycle) {
            return $this->success(new PerformanceCycleResource($this->cycleService->find($id)));
        }
        return $this->success(new PerformanceReviewResource($this->reviewService->find($id)));
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $this->resolve();
        if ($this->isCycle) {
            $validated = app(UpdatePerformanceCycleRequest::class)->validated();
            return $this->success(new PerformanceCycleResource($this->cycleService->update($id, $validated)), 'Cycle updated');
        }
        $review = $this->reviewService->update($id, $request->all());
        return $this->success(new PerformanceReviewResource($review), 'Review updated');
    }

    public function destroy(int $id): JsonResponse
    {
        $this->resolve();
        if ($this->isCycle) {
            $this->cycleService->delete($id);
            return $this->noContent();
        }
        $this->reviewService->delete($id);
        return $this->noContent();
    }

    public function launchCycle(int $id): JsonResponse
    {
        $cycle = $this->cycleService->launch($id);
        return $this->success(new PerformanceCycleResource($cycle), 'Cycle launched');
    }

    public function submitReview(int $id): JsonResponse
    {
        $review = $this->reviewService->submit($id);
        return $this->success(new PerformanceReviewResource($review), 'Review submitted');
    }
}
