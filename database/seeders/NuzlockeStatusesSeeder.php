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
            ['alias' => 'in-progress', 'name' => 'In Progress'],
            ['alias' => 'complete', 'name' => 'Complete'],
        ];

        foreach ($statuses as $status) {
            NuzlockeStatus::updateOrCreate(
                ['alias' => $status['alias']],
                ['name' => $status['name']]
            );
        }
    }
}
