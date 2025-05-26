<?php

namespace App\Services\PlatformService;

use App\Models\User;
use App\Repositories\PlatformRepository\PlatformRepository;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

class PlatformService
{
    public function __construct(
        protected PlatformRepository $platformRepository
    ) {}

    public function index(): Paginator|Collection
    {
        return $this->platformRepository->index();
    }

}
