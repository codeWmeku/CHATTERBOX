<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
            'body' => fake()->paragraph(rand(1,3)),
            'likes_count' => fake()->numberBetween(0, 200),
            // store an image URL (picsum) as demo 'image' field
            'image' => 'https://picsum.photos/seed/post-' . Str::random(8) . '/1200/675',
        ];
    }
}
