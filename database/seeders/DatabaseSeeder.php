<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Critic;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            LanguageSeeder::class,
            ActorSeeder::class,
            ActorFilmSeeder::class,
            FilmSeeder::class,
        ]);

        User::factory(10)->has(Critic::factory(30))->create();
    }
}
