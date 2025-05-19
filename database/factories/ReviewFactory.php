<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\review>
 */
class ReviewFactory extends Factory
{
    protected int $maxPossibleUserId = 0;
    protected int $maxPossibleDentistId = 0;

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
     * Set the maximum possible dentist ID.
     *
     * @param int $maxPossibleDentistId
     * @return $this
     */

    public function withMaxPossibleDentistId(int $maxPossibleDentistId): self
    {
        $this->maxPossibleDentistId = $maxPossibleDentistId;
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
            'user_id' => fake()->numberBetween(1, $this->maxPossibleUserId),
            'dentist_id' => fake()->numberBetween(1, $this->maxPossibleDentistId),
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->sentence(),
        ];
    }
}
