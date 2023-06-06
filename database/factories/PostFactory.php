<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
  //  protected $model = Post::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'user_id' => rand(1,2),
            'title' => $this->faker->sentence,
            'content' => $this->faker->text(500),
            'longitude' => $this->faker->longitude,
            'latitude' => $this->faker->latitude
        ];
    }
}
