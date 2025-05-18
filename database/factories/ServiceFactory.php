<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
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
            'dentist_id' => fake()->numberBetween(1, $this->maxPossibleDoctorId),
            'service_name' => fake()->randomElement([
                'Konsultacja',
                'RTG',
                'Czyszczenie',
                'Wypełnienie',
                'Leczenie kanałowe',
                'Ekstrakcja zęba',
                'Wybielanie zębów',
                'Konsultacja ortodontyczna',
                'Implanty dentystyczne',
                'Prace protetyczne (korony i mosty)',
            ]),
            'cost' => fake()->randomFloat(2, 10, 1000),
        ];
    }
}
