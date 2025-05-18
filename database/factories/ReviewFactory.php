<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\review>
 */
class ReviewFactory extends Factory
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

    protected int $maxPossibleDoctorId = 0;
    /**
     * Set the maximum possible doctor ID.
     *
     * @param int $maxPossibleDoctorId
     * @return $this
     */

    public function withMaxPossibleDoctorId(int $maxPossibleDoctorId): self
    {
        $this->maxPossibleDoctorId = $maxPossibleDoctorId;
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
            'doctor_id' => fake()->numberBetween(1, $this->maxPossibleDoctorId),
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->sentence(),
        ];
    }
}
