<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status'=>$this->faker->randomElement([
                'draft',
                'published',
                'sold',
                'rented',
            ]),
            'uploaded_at' => now(),
        ];
    }
}
