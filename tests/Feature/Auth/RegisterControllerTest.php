<?php

namespace Auth;

use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Str;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $password = $this->faker->password;

        $this->routes = [
            'store' => 'register',
        ];

        $this->params = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $password,
            'password_confirmation' => $password
        ];
    }

    public function testCreate()
    {
        // Attempt to store user
        $this->post('register', $this->params)->assertRedirect();
        $user = User::where('email', $this->params['email'])->first();

        // Check the user has been logged in, this will verify the user has stored.
        $this->assertAuthenticatedAs($user);
    }

    public function testCreateFailureToException()
    {
        $this->app->instance(UserService::class, Mockery::mock(UserService::class, function ($mock) {
            $mock->shouldReceive('createUser')->andThrow(new \Exception('Error occurred'));
        }));

        $this->post('/register', $this->params)
            ->assertRedirect()
            ->assertSessionHas('error', 'Failed to create user.');
    }

    // Validation

    public function testValidateRequired()
    {
        $fields = ['name' => 'name', 'email' => 'email', 'password' => 'password', 'password_confirmation' => 'password confirmation'];

        foreach ($fields as $key => $field) {
            unset($this->params[$key]);

            if ($key === 'password_confirmation') {
                unset($this->params[$key]);
            }

            $this->json('post', $this->routes['store'], $this->params)
                ->assertJsonFragment([$key => ["The {$field} field is required."]]);
        }
    }

    public function testValidateString()
    {
        $fields = ['name', 'password'];

        foreach ($fields as $field) {
            $this->params[$field] = rand(111111, 999999);

            $this->json('post', $this->routes['store'], $this->params)
                ->assertJsonFragment([$field => ["The {$field} field must be a string."]]);
        }
    }

    public function testValidateEmail()
    {
        $fields = ['email'];

        foreach ($fields as $field) {
            $this->params[$field] = Str::random();

            $this->json('post', $this->routes['store'], $this->params)
                ->assertJsonFragment([$field => ["The {$field} field must be a valid email address."]]);
        }
    }

    public function testValidateMax()
    {
        $fields = ['name', 'email'];

        foreach ($fields as $field) {
            $this->params[$field] = Str::random(256);

            if ($field === 'email') {
                $this->params[$field] = Str::random(256) . $this->faker->email;
            }

            $this->json('post', $this->routes['store'], $this->params)
                ->assertJsonFragment([$field => ["The {$field} field must not be greater than 255 characters."]]);
        }
    }

    public function testValidateMin()
    {
        $fields = ['password'];

        foreach ($fields as $field) {
            $this->params[$field] = Str::random(1);

            $this->json('post', $this->routes['store'], $this->params)
                ->assertJsonFragment([$field => ["The {$field} field must be at least 6 characters."]]);
        }
    }

    public function testValidateUnique()
    {
        $fields = ['email'];

        // Create user with same email
        $user = $this->createUser();

        foreach($fields as $field) {
            $this->params[$field] = $user->email;

            $this->json('post', $this->routes['store'], $this->params)
                ->assertJsonFragment([$field => ["The {$field} has already been taken."]]);
        }
    }

    /**
     * @return User
     */
    private function createUser(): User
    {
        return User::factory()->create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => Hash::make('password'),
        ]);
    }
}
