<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Faker\Factory as Faker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();

        // Run Migrations
        Artisan::call('migrate', ['--env' => 'testing']);
    }

    public function beAuthenticatedUser() : User
    {
        $user = User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password
        ]);

        $this->be($user);

        return $user;
    }
}
