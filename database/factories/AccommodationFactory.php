<?php

namespace Database\Factories;

use App\Models\Accommodation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Accommodation>
 */
class AccommodationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Accommodation::class;

    public function definition(): array
    {
        return [
            'hotel_id' => \App\Models\Hotel::factory(),
            'room_type_id' => \App\Models\RoomType::factory(),
            'type' => $this->faker->randomElement(['Sencilla', 'Doble', 'Triple', 'Cuádruple']),
            'quantity' => $this->faker->numberBetween(1, 20),
        ];
    }
}
