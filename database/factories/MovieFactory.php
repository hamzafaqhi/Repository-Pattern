<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{

    protected $model = Movie::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'overview' => $this->faker->paragraph,
            'release_date' => $this->faker->date,
            'popularity' => $this->faker->randomFloat(2, 0, 100),
            'vote_average' => $this->faker->randomFloat(2, 0, 10),
            'vote_count' => $this->faker->randomNumber(),
            'image' => $this->faker->imageUrl,
        ];
    }
}
