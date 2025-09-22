<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name,
            'description' => fake()->text,
            'salary' => fake()->numberBetween(1000, 10000),
            'location' => fake()->city,
            'job_type_id' => fake()->numberBetween(1, 5),
            'category_id' => fake()->numberBetween(1, 5),
            'experience' => fake()->numberBetween(1, 10),
            'company_name' => fake()->company,
            'company_location' => fake()->city,
            'company_website' => fake()->url,
            'vacancy' => fake()->numberBetween(1, 10),
            'user_id' => 1,
        ];
    }
}
