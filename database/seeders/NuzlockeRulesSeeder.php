<?php

namespace Database\Seeders;

use App\Models\NuzlockeRule;
use Illuminate\Database\Seeder;

class NuzlockeRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nuzlocke_rules = [
            ['alias' => 'normal', 'name' => 'Normal'],
            ['alias' => 'soullink', 'name' => 'Soul link'],
        ];

        // Upsert statuses in a single query
        NuzlockeRule::upsert(
            $nuzlocke_rules,
            ['alias'],
            ['name']
        );
    }
}
