<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;

class DashboardController extends BaseController
{
    public function index(): JsonResponse
    {
        return $this->success([]);
    }

    public function metrics(): JsonResponse
    {
        return $this->success([]);
    }
}
