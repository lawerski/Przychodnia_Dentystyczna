<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dentist>
 */
class DentistFactory extends Factory
{
    protected int $maxPossibleUserId = 0;

    /**
     * Set the maximum possible user ID.
     *
     * @param int $maxPossibleUserId
     * @return $this
     */
    public function withMaxPossibleUserId(int $maxPossibleUserId): self
    {
        $this->maxPossibleUserId = $maxPossibleUserId;
        return $this;
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->unique()->numberBetween(1, $this->maxPossibleUserId),
            'name' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'specialization' => fake()->word(),
            'license_number' => fake()->unique()->word(),
        ];
    }
}
