<?php

namespace App\Http\Controllers\Api\V1\User\Post;

use Throwable;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PostService\PostService;
use App\Http\Resources\Api\V1\PostResource\PostResource;
use App\Traits\HandleApiJsonResponse\HandleApiJsonResponseTrait;
use App\Http\Requests\Api\V1\User\Post\StorePostRequest\StorePostRequest;
use App\Http\Requests\Api\V1\User\Post\UpdatePostRequest\UpdatePostRequest;

class PostController extends Controller
{
    use HandleApiJsonResponseTrait;

    public function __construct(protected PostService $postService)
    {
    }

    /**
     * Display a listing of posts for the authenticated user.
     */
    public function index(Request $request)
    {
        try {
            $user = auth('sanctum')->user();
            $filters = $request->only(['status', 'date']);
            $posts = $this->postService->index($user, $filters);
            return $this->success(PostResource::collection($posts), __('api.successfully'));
        } catch (Throwable $e) {
            return $this->errorUnExpected($e);
        }
    }

    /**
     * Store a newly created post.
     */
    public function store(StorePostRequest $request)
    {
        try {
            $user = auth('sanctum')->user();
            $data = $request->validated();
            $post = $this->postService->create($user, $data);

            return $this->success(PostResource::make($post), __('api.successfully'));
        } catch (Throwable $e) {
            return $this->errorUnExpected($e);
        }
    }
    public function show(Post $post)
    {
        try {
            return $this->success(PostResource::make($post), __('api.successfully'));
        } catch (Throwable $e) {
            return $this->errorUnExpected($e);
        }
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        try {
            $data = $request->validated();
            $updated = $this->postService->update($post, $data);

            if ($updated) {
                return $this->success(PostResource::make($post->fresh()), __('api.successfully'));
            }

            return $this->error('Failed to update post', 400);
        } catch (Throwable $e) {
            return $this->errorUnExpected($e);
        }
    }

    public function destroy(Post $post)
    {
        try {
            $deleted = $this->postService->delete($post);

            if ($deleted) {
                return $this->success([], __('api.successfully'));
            }

            return $this->error('Failed to delete post', 400);
        } catch (Throwable $e) {
            return $this->errorUnExpected($e);
        }
    }
}
