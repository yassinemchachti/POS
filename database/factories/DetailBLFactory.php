<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetailBL>
 */
class DetailBLFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'commande_id' => \App\Models\Commande::inRandomOrder()->first()->id ?? \App\Models\Commande::factory(),
            'article_id' => \App\Models\Article::inRandomOrder()->first()->id ?? \App\Models\Article::factory(),
            'qnt' => $this->faker->numberBetween(1, 10),
            'tva' => $this->faker->randomElement([7, 10, 20]),
            'prix_ht' => $this->faker->randomFloat(2, 1, 100),
            'remise' => $this->faker->randomFloat(2, 0, 30),
        ];
    }
}
