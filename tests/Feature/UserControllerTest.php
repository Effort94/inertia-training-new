<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->beAuthenticatedUser();
    }

    public function testShow()
    {
        $this->get("users/{$this->user->id}/settings")->assertSuccessful();
    }

    public function testStore()
    {
        $old_user_details = $this->user;

        // Update Email Address
        $this->post("users/{$this->user->id}/settings/store", [
            'email' => $this->faker->email
        ]);

        // Check that the email address has been updated, but the password hasn't
        $this->assertNotEquals($this->user->fresh()->email, $old_user_details->email);
        $this->assertEquals($this->user->fresh()->password, $old_user_details->password);

        // Update the Password
        $password = $this->faker->password(8);
        $this->post("users/{$this->user->id}/settings/store", [
            'email' => $this->faker->email,
            'password' => $password,
            'password_confirmation' => $password
        ]);

        // Check that all user settings have been updated.
        $this->assertNotEquals($this->user->fresh()->password, $old_user_details->password);
        $this->assertNotEquals($this->user->fresh()->email, $old_user_details->email);
    }
}
