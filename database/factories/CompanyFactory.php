<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'code' => $this->faker->unique()->text(16),
            'description' => $this->faker->text,
            'address' => $this->faker->address,
            'image' => null,
            'founding_date' => now(),
        ];
    }
}
