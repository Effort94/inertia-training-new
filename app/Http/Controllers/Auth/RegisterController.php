<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class RegisterController extends Controller
{
    /**
     * Redirect to register view
     *
     * @return Response
     */
    public function show(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Attempt to create new user
     *
     * @param RegisterRequest $request
     * @return HttpResponse
     */
    public function create(RegisterRequest $request): HttpResponse
    {
        // Store the credentials
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        // Attempt to create the user
        try {
            User::create([
                'email' => $credentials['email'],
                'name' => $request->get('name'),
                'password' => $credentials['password'],
            ]);
        } catch (Exception) {
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
