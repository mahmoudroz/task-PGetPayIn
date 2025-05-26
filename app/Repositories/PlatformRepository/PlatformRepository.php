<?php

namespace App\Repositories\PlatformRepository;

use App\Models\User;
use App\Models\Platform;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;

class PlatformRepository
{
   
    public function index(): Paginator|Collection
    {
        return Platform::simplePaginate(config('general.paginationCount', 10));
    }
    
}

