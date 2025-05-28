<?php

namespace App\Services\PostService;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Repositories\PostRepository\PostRepository;

class PostService
{
    private const MAX_DAILY_LIMIT = 10;
    
    public function __construct(
        protected PostRepository $postRepository
    ) {}

    public function index(User $user, array $filters = []): Paginator|Collection
    {
        return $this->postRepository->index($user, $filters);
    }

    public function create(User $user, array $data)
    {
        $userId   = $user->id;
        $dateKey  = now()->format('Y-m-d');
        $cacheKey = "scheduled_posts:{$userId}:{$dateKey}";
        $lockKey  = "lock:scheduled_post:{$userId}";

        Cache::lock($lockKey, 3)->block(5, function () use ($data, $cacheKey) {
            $count = Cache::get($cacheKey, 0);

            if ($count >= self::MAX_DAILY_LIMIT) {
                throw ValidationException::withMessages([
                    'status' => 'You have reached the maximum number of scheduled posts for today.',
                ]);
            }
            if ($data['status'] == 1) {
                Cache::put($cacheKey, $count + 1, now()->endOfDay());
            }
        });
        if (isset($data['image_url']) && $data['image_url'] != null) {
            $data['image_url'] = uploadImage($data['image_url'], 'posts');
        }
        return $this->postRepository->create($user, $data);
    }
    public function update(Post $post, array $data): bool
    {
        if (isset($data['image_url']) && $data['image_url'] != null) {
            if ($post->image_url != null) {
                Storage::disk('public_uploads')->delete('//categories/' . $post->image_url);
            }
            $data['image_url'] = uploadImage($data['image'], 'posts');
        }
        return $this->postRepository->update($post, $data);
    }
    public function delete(Post $post): bool
    {
        if($post['image_url'] != null){
            Storage::disk('public_uploads')->delete('//posts/' . $post['image_url']);
        }
        return $this->postRepository->delete($post);
    }
}
