<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller
{
    /**
     * Redirect to log in view
     *
     * @return Response
     */
    public function show(): Response
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Attempt to log in
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended();
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records'
        ]);
    }

    /**
     * logout
     *
     * @return void
     */
    public function logout(): void
    {
        Auth::logout();
    }
}
