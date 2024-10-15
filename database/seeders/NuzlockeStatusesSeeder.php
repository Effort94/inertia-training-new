<?php

namespace Database\Seeders;

use App\Models\NuzlockeStatus;
use Illuminate\Database\Seeder;

class NuzlockeStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['alias' => 'in-progress', 'name' => 'In Progress', 'icon' => 'fa-spinner fa-spin'],
            ['alias' => 'complete', 'name' => 'Complete', 'icon' => 'fa-check'],
        ];

        // Upsert statuses in a single query
        NuzlockeStatus::upsert(
            $statuses,
            ['alias'],
            ['name', 'icon']
        );
    }
}
