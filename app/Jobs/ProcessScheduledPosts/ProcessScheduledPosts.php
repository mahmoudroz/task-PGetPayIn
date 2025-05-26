<?php

namespace App\Jobs\ProcessScheduledPosts;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessScheduledPosts implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */ 
    protected $postId;

    public function __construct($postId)
    {
        $this->postId = $postId;
    }

    public function handle()
    {
        $post = Post::with('platforms')->find($this->postId);

        if (!$post || $post->status !== 1) return;
        DB::beginTransaction();
        foreach ($post->platforms as $platform) {
            // محاكاة النشر
            Log::info("Publishing post {$post->id} to {$platform->name}");
            $post->platforms()->updateExistingPivot($platform->id, [
                'platform_status' => 1
            ]);
        }
        $post->update(['status' => 2]);
        DB::commit();

    }
}

