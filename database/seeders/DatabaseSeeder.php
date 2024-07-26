<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CivilianSeeder::class,
            UserSeeder::class,
            MedicalCheckupSeeder::class,
            ActivitySeeder::class,
            ArticleSeeder::class,
        ]);
    }
}
