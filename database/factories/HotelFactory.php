<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' Hotel',
            'description' => fake()->optional()->paragraphs(2, true),
            'poster_url' => "https://picsum.photos/seed/".fake()->uuid()."/800/450",
            'address' => fake()->address(),
            'stars' => fake()->numberBetween(3, 5),
        ];
    }
}
