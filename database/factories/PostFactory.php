<?php

namespace Database\Factories;

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
    {   $title = $this->faker->sentence();
        return [
            'image' => $this->faker->imageUrl(),
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'content' => $this->faker->paragraphs(5, true),
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id,    
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'published_at' => $this->faker->optional()->dateTime(),
        ];
    }
}
