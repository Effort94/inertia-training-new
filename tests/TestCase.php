<?php

namespace Tests;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();

        // Run Migrations
        Artisan::call('migrate', ['--env' => 'testing']);

        // Run Seeders
        Artisan::call('db:seed', [
            '--class' => 'Database\Seeders\PrioritySeeder',
            '--env' => 'testing',
        ]);

        $this->beAuthenticatedUser();
    }

    public function beAuthenticatedUser(): User
    {
        $user = User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ]);

        $this->be($user);

        return $user;
    }
}
