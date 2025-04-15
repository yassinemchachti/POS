<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        \App\Models\User::factory(10)->create();
        \App\Models\Famille::factory(5)->create();
        \App\Models\Marque::factory(5)->create();
        \App\Models\Unite::factory(4)->create();
        \App\Models\Article::factory(20)->create();
        \App\Models\Commande::factory(15)->create();
        \App\Models\DetailBL::factory(40)->create();
        \App\Models\ModeReglement::factory(4)->create();
        // \App\Models\Reglement::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
