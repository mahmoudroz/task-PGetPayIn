<?php

namespace App\Console\Commands\ProcessScheduledPostsCommand;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Jobs\ProcessScheduledPosts\ProcessScheduledPosts;

class ProcessScheduledPostsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-scheduled-posts-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle()
    {
        DB::table('posts')->select('id')->where('scheduled_time', '<=', now())
        ->where('status', 1)
        ->chunkById(1000, function ($posts) {
            foreach ($posts as $post) {
                dispatch(new ProcessScheduledPosts($post->id));
            }
        });
    }
}
