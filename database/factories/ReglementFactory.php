<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reglement>
 */
class ReglementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'montant' => $this->faker->randomFloat(2, 50, 2000),
            'user_id' => \App\Models\User::inRandomOrder()->first()->id ?? \App\Models\User::factory(),
            'mode_reglement_id' => \App\Models\ModeReglement::inRandomOrder()->first()->id ?? \App\Models\ModeReglement::factory(),
        ];
    }
}
