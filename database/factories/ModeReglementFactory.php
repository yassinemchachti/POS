<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ModeReglement>
 */
class ModeReglementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mode_reglement' => $this->faker->randomElement(['Espèce', 'Carte', 'Chèque', 'Virement']),
        ];
    }
}
