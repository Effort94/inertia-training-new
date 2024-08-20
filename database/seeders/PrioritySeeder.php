<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Priority::updateOrCreate(
            ['name' => 'Low'],
            ['icon' => 'fa-solid fa-arrow-down']
        );

        Priority::updateOrCreate(
            ['name' => 'Medium'],
            ['icon' => 'fa-solid fa-arrow-right']
        );

        Priority::updateOrCreate(
            ['name' => 'High'],
            ['icon' => 'fa-solid fa-arrow-up']
        );
    }
}
