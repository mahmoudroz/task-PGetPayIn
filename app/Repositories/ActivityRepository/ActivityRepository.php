<?php

namespace App\Repositories\ActivityRepository;

use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Spatie\Activitylog\Models\Activity;

class ActivityRepository
{
   
    public function index($user): Paginator|Collection
    {
        return Activity::causedBy($user)->orderByDESC('id')->simplePaginate(config('general.paginationCount', 10));
    }
    
}

