<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Position\StorePositionRequest;
use App\Http\Requests\Position\UpdatePositionRequest;
use App\Http\Resources\PositionResource;
use App\Services\Settings\PositionService;
use Illuminate\Http\JsonResponse;

class PositionController extends BaseController
{
    public function __construct(
        private PositionService $positionService,
    ) {}

    public function index(): JsonResponse
    {
        $positions = $this->positionService->getAll(request()->all());
        return $this->paginated($positions);
    }

    public function store(StorePositionRequest $request): JsonResponse
    {
        $position = $this->positionService->create($request->validated());
        return $this->created(new PositionResource($position));
    }

    public function show(int $id): JsonResponse
    {
        $position = $this->positionService->find($id);
        $position->load('department');
        return $this->success(new PositionResource($position));
    }

    public function update(UpdatePositionRequest $request, int $id): JsonResponse
    {
        $position = $this->positionService->update($id, $request->validated());
        return $this->success(new PositionResource($position), 'Position updated.');
    }

    public function destroy(int $id): JsonResponse
    {
        $this->positionService->delete($id);
        return $this->noContent();
    }
}
