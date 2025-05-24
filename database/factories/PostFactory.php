<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'          => fake()->sentence,
            'content'        => fake()->paragraph,
            'image_url'      => fake()->optional()->imageUrl(),
            'scheduled_time' => fake()->dateTimeBetween('+1 hour', '+5 days'),
            'status'         => fake()->randomElement([0, 1, 2]),
            'user_id'        => User::factory()
        ];
    }
}
