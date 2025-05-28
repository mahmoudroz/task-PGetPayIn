<?php

namespace App\Services\ActivityService;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use App\Repositories\ActivityRepository\ActivityRepository;
use App\Repositories\PlatformRepository\PlatformRepository;

class ActivityService
{
    public function __construct(
        protected ActivityRepository $activityRepository
    ) {}

    public function index(User $user): Paginator|Collection
    {
        return $this->activityRepository->index($user);
    }

}
