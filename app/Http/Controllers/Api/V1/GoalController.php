<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Performance\StoreGoalRequest;
use App\Http\Resources\Performance\GoalResource;
use App\Services\Performance\GoalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GoalController extends BaseController
{
    public function __construct(
        private GoalService $goalService
    ) {}

    public function index(Request $request): JsonResponse
    {
        return $this->paginated($this->goalService->getAll($request->all()), GoalResource::class);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = app(StoreGoalRequest::class)->validated();
        $goal = $this->goalService->create($validated);
        return $this->created(new GoalResource($goal), 'Goal created');
    }

    public function show(int $id): JsonResponse
    {
        return $this->success(new GoalResource($this->goalService->find($id)));
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $goal = $this->goalService->update($id, $request->all());
        return $this->success(new GoalResource($goal), 'Goal updated');
    }

    public function destroy(int $id): JsonResponse
    {
        $this->goalService->delete($id);
        return $this->noContent();
    }
}
