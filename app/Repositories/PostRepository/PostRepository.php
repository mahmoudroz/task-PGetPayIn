<?php

namespace App\Repositories\PostRepository;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

class PostRepository
{
    public function index(User $user, array $filters = []): Paginator|Collection
    {
        return $user->posts()
            ->select('id', 'title', 'content', 'image_url', 'scheduled_time', 'status', 'created_at')
            ->with('platforms')
            ->when(isset($filters['status']), function ($q) use ($filters) {
                $q->where('status', $filters['status']);
            })
            ->when(isset($filters['date']), function ($q) use ($filters) {
                $q->whereDate('created_at', $filters['date']);
            })
            ->simplePaginate(config('general.paginationCount', 10));
    }
    public function create(User $user, array $data): Post
    {
        DB::beginTransaction();
        $post = $user->posts()->create([
            'title'          => $data['title'],
            'content'        => $data['content'],
            'image_url'      => $data['image_url'] ?? null,
            'scheduled_time' => $data['scheduled_time'],
            'status'         => $data['status'] ?? 0,
        ]);

        if (!empty($data['platform_ids'])) {
            $post->platforms()->attach($data['platform_ids']);
            if ($post->status == 2) {
                $post->platforms()->updateExistingPivot($data['platform_ids'], [
                    'platform_status' => 1
                ]);
            }
        }
        activity()
        ->causedBy($user)
        ->withProperties(['ip' => request()->ip()])
        ->log('Created Post Successfully');

        DB::commit();
        return $post;
    }

    public function update(Post $post, array $data): bool
    {
        DB::beginTransaction();
        $updated = $post->update([
            'title'          => $data['title'] ?? $post->title,
            'content'        => $data['content'] ?? $post->content,
            'image_url'      => $data['image_url'] ?? $post->image_url,
            'scheduled_time' => $data['scheduled_time'] ?? $post->scheduled_time,
            'status'         => $data['status'] ?? $post->status,
        ]);

        if (isset($data['platform_ids'])) {
            $post->platforms()->sync($data['platform_ids']);
            if ($post->status == 2) {
                $post->platforms()->updateExistingPivot($data['platform_ids'], [
                    'platform_status' => 1
                ]);
            }
        }
        DB::commit();
        return $updated;
    }
    public function delete(Post $post): bool
    {
        $post->platforms()->detach();
        return $post->delete();
    }
}
