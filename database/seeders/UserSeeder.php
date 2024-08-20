<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'wdavey713@outlook.com',
            ],
            [
                'name' => 'Admin',
                'password' => bcrypt('password123'),
            ]
        );
    }
}
