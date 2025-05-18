<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
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

    protected int $maxPossibleServiceId = 0;
    /**
     * Set the maximum possible service ID.
     *
     * @param int $maxPossibleServiceId
     * @return $this
     */
    public function withMaxPossibleServiceId(int $maxPossibleServiceId): self
    {
        $this->maxPossibleServiceId = $maxPossibleServiceId;
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
            'service_id' => fake()->numberBetween(1, $this->maxPossibleServiceId),
            'coupon_code' => fake()->unique()->word(),
            'discount_percentage' => fake()->numberBetween(5, 50),
            'valid_until' => fake()->dateTimeBetween('now', '+1 year'),
            'is_used' => fake()->boolean(),
        ];
    }
}
