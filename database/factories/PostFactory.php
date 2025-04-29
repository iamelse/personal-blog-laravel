<?php

namespace Database\Factories;

use App\Models\PostCategory;
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
            'cover' => 'https://picsum.photos/400/250?random=' . $this->faker->numberBetween(1, 1000),
            'title' => $this->faker->unique()->sentence,
            'slug' => $this->faker->unique()->slug,
            'excerpt' => $this->faker->paragraphs(1, true),
            'body' => $this->faker->paragraphs(10, true),
            'post_category_id' => PostCategory::inRandomOrder()->value('id'),
            'user_id' => User::factory(),
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'status' => $this->faker->randomElement(['draft', 'published']),
            'seo_title' => $this->faker->unique()->sentence,
            'seo_description' => $this->faker->paragraphs(3, true),
            'seo_keywords' => $this->faker->words(5, true),
        ];
    }
}
