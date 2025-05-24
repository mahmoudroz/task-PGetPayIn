<?php

namespace Database\Seeders;

use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Platform;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory(5)->create()->each(function ($user) {
            Post::factory(3)->create([
                'user_id' => $user->id,
            ])->each(function ($post) {
                $platforms = Platform::inRandomOrder()->take(2)->get();
                $post->platforms()->attach($platforms->pluck('id'), ['platform_status' => 'pending']);
            });
        });

        Platform::factory()->count(5)->create();
    }
}
