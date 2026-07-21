<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Announcement\StoreAnnouncementRequest;
use App\Http\Requests\Announcement\UpdateAnnouncementRequest;
use App\Http\Resources\Announcement\AnnouncementResource;
use App\Services\Announcement\AnnouncementService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnnouncementController extends BaseController
{
    public function __construct(
        private AnnouncementService $announcementService
    ) {}

    public function index(Request $request): JsonResponse
    {
        return $this->paginated($this->announcementService->getAll($request->all()), AnnouncementResource::class);
    }

    public function store(StoreAnnouncementRequest $request): JsonResponse
    {
        $announcement = $this->announcementService->create($request->validated());
        return $this->created(new AnnouncementResource($announcement), 'Announcement created');
    }

    public function show(int $id): JsonResponse
    {
        return $this->success(new AnnouncementResource($this->announcementService->find($id)));
    }

    public function update(UpdateAnnouncementRequest $request, int $id): JsonResponse
    {
        $announcement = $this->announcementService->update($id, $request->validated());
        return $this->success(new AnnouncementResource($announcement), 'Announcement updated');
    }

    public function destroy(int $id): JsonResponse
    {
        $this->announcementService->delete($id);
        return $this->noContent();
    }

    public function togglePin(int $id): JsonResponse
    {
        $announcement = $this->announcementService->togglePin($id);
        return $this->success(new AnnouncementResource($announcement), 'Pin toggled');
    }

    public function markAsRead(int $id): JsonResponse
    {
        $this->announcementService->markAsRead($id);
        return $this->success(null, 'Marked as read');
    }
}
