<?php

namespace Tests\Feature;

use App\Models\User;
use Faker\Factory as Faker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Faker::create();
    }

    public function testCreate()
    {
        $this->get('/login')->assertSuccessful();
    }

    public function testStore()
    {
        // User does not exist
        $this->post('/login', [
            'email' => $this->faker->email(),
            'password' => $this->faker->password()
        ]);

        $error_message = $this->app->make('session')->get('errors')->first();
        $this->assertStringContainsString("do not match", $error_message);

        // Create a user
        $password = $this->faker->password();
        $user = User::create([
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => $password
        ]);

        // Attempt to log in with existing user credentials
        $this->post('/login', [
            'email' => $user->email,
            'password' => $password
        ]);

        // Check we're logged in
        $this->assertAuthenticatedAs($user);
    }

    public function testLogOut()
    {
        // Create a user
        $password = $this->faker->password();
        $user = User::create([
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => $password
        ]);

        // Attempt to log in with existing user credentials
        $this->post('/login', [
            'email' => $user->email,
            'password' => $password
        ]);

        $this->post('logout');

        // Check we're not authenticated
        $this->assertGuest();
    }
}
