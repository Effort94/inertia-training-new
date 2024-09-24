<?php

namespace Auth;

use App\Models\User;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
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
            'password' => $this->faker->password(),
        ])
            ->assertRedirect()
            ->assertSessionHasErrors('email', 'The provided credentials do not match our records');

        // Create a user
        $password = $this->faker->password();
        $user = User::create([
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => $password,
        ]);

        // Attempt to log in with existing user credentials
        $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        // Check we're logged in
        $this->assertAuthenticatedAs($user);
    }

    public function testLogout()
    {
        // Be an authenticated user
        $user = $this->beAuthenticatedUser();
        $this->assertAuthenticatedAs($user);

        $this->get('logout');

        // Check we're not authenticated
        $this->assertGuest();
    }
}
