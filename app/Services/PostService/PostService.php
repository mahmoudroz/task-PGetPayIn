<?php

namespace App\Services\PostService;

use App\Models\Post;
use App\Models\User;
use App\Repositories\PostRepository\PostRepository;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function __construct(
        protected PostRepository $postRepository
    ) {}

    public function index(User $user, array $filters = []): Paginator|Collection
    {
        return $this->postRepository->index($user, $filters);
    }

    public function create(User $user, array $data)
    {
        if (isset($data['image_url']) ) {
            $data['image_url'] = uploadImage($data['image_url'], 'posts');
        }
        return $this->postRepository->create($user, $data);
    }
    public function update(Post $post, array $data): bool
    {
        if (isset($data['image_url']) ) {
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
