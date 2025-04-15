<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'designation' => $this->faker->words(2, true),
            'prix_ht' => $this->faker->randomFloat(2, 5, 500),
            'tva' => $this->faker->randomElement([7, 10, 20]),
            'photo' => $this->faker->randomElement([
                'https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg',
                'https://fakestoreapi.com/img/71li-ujtlUL._AC_UX679_.jpg',
                'https://fakestoreapi.com/img/71YXzeOuslL._AC_UY879_.jpg',
                'https://fakestoreapi.com/img/61IBBVJvSDL._AC_SY879_.jpg',
                'https://fakestoreapi.com/img/61U7T1koQqL._AC_SX679_.jpg',
                'https://fakestoreapi.com/img/81Zt42ioCgL._AC_SX679_.jpg',
                'https://fakestoreapi.com/img/71HblAHs5xL._AC_UY879_-2.jpg',
                'https://fakestoreapi.com/img/61pHAEJ4NML._AC_UX679_.jpg',
            ]),

            'stock' => $this->faker->numberBetween(10, 100),
            'codebarre' => $this->faker->unique()->ean13(),
            'famille_id' => \App\Models\Famille::inRandomOrder()->first()->id ?? \App\Models\Famille::factory(),
            'marque_id' => \App\Models\Marque::inRandomOrder()->first()->id ?? \App\Models\Marque::factory(),
            'unite_id' => \App\Models\Unite::inRandomOrder()->first()->id ?? \App\Models\Unite::factory(),
        ];
    }
}
