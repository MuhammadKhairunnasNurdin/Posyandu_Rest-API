<?php

namespace Database\Seeders;

use App\Models\Civilian;
use App\Models\User;
use Illuminate\Database\Seeder;

class CivilianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Civilian::factory()
            ->count(100)
            ->headOfFamily()
            ->create()
            ->each(function (Civilian $headOfFamily) {
                Civilian::factory()
                    ->wife()
                    ->create([
                        'NKK' => $headOfFamily->NKK,
                        'address' => $headOfFamily->address,
                        'RT' => $headOfFamily->RT,
                ]);
                Civilian::factory()
                    ->count(2)
                    ->children()
                    ->create([
                        'NKK' => $headOfFamily->NKK,
                        'address' => $headOfFamily->address,
                        'RT' => $headOfFamily->RT,
                ]);
        });
    }
}
