<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['Standard','Deluxe','Suite','Family'];
        return [
            'hotel_id' => Hotel::factory(),
            'name' => 'Room ' . fake()->numberBetween(100, 999),
            'description' => fake()->optional()->sentence(8),
            'poster_url' => "https://picsum.photos/seed/".fake()->uuid()."/800/600",
            'floor_area' => fake()->randomFloat(2, 12, 80),
            'type' => fake()->randomElement($types),
            'price' => fake()->numberBetween(2500, 15000),
        ];
    }
}
