<?php

namespace App\Http\Controllers\Api\V1\User\Platform;

use Throwable;
use App\Models\Post;
use App\Models\Platform;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\PlatformResource\PlatformResource;
use App\Services\PlatformService\PlatformService;
use App\Traits\HandleApiJsonResponse\HandleApiJsonResponseTrait;

class PlatformController extends Controller
{
    use HandleApiJsonResponseTrait;

    public function __construct(protected PlatformService $platformService)
    {
    }

    /**
     * Display a listing of posts for the authenticated user.
     */
    public function index()
    {
        try {
            $posts = $this->platformService->index();
            return $this->success(PlatformResource::collection($posts)->response()->getData(true), __('api.successfully'));
        } catch (Throwable $e) {
            return $this->errorUnExpected($e);
        }
    }
}

