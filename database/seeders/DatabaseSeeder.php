<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LanguageSeeder::class,
            FilmSeeder::class,
            ActorSeeder::class,
            Actor_FilmSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            CriticSeeder::class,
        ]);
    }
}
