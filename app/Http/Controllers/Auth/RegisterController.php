<?php

namespace App\Http\Controllers\Auth;

use App\Http\Services\UserService;
use Inertia\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class RegisterController extends Controller
{
    protected UserService $service;

    public function __construct(UserService $userService) {
        $this->service = $userService;
    }

    /**
     * Redirect to register view
     *
     * @codeCoverageIgnore Don't test views.
     */
    public function show(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Attempt to create new user
     */
    public function create(RegisterRequest $request): HttpResponse
    {
        // Store the credentials
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ];

        // Attempt to create the user
        try {
            $this->service->createUser([
                'email' => $credentials['email'],
                'name' => $request->get('name'),
                'password' => $credentials['password'],
            ]);
        } catch (\Exception $e) {
            // Return error message
            return redirect()->back()->with('error', 'Failed to create user.');
        }

        // If user registered correctly, let's just log the user in.
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
        }

        return Inertia::location('/');
    }
}
