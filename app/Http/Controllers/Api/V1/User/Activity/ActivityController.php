<?php

namespace App\Http\Controllers\Api\V1\User\Activity;

use Throwable;
use App\Http\Controllers\Controller;
use App\Services\ActivityService\ActivityService;
use App\Traits\HandleApiJsonResponse\HandleApiJsonResponseTrait;

class ActivityController extends Controller
{
    use HandleApiJsonResponseTrait;

    public function __construct(protected ActivityService $activityService)
    {
    }

    /**
     * Display a listing of posts for the authenticated user.
     */
    public function index()
    {
        try {
            $user = auth('sanctum')->user();
            $activities = $this->activityService->index($user);
            return $this->success($activities, __('api.successfully'));
        } catch (Throwable $e) {
            return $this->errorUnExpected($e);
        }
    }
}
