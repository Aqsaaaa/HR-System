<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;

class LeaveTypeController extends BaseController
{
    public function index(): JsonResponse
    {
        return $this->success([]);
    }

    public function store(): JsonResponse
    {
        return $this->success([], 'Created', 201);
    }

    public function show($id): JsonResponse
    {
        return $this->success([]);
    }

    public function update($id): JsonResponse
    {
        return $this->success([]);
    }

    public function destroy($id): JsonResponse
    {
        return $this->noContent();
    }
}
