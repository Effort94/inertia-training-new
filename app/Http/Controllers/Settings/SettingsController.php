<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    /**
     * Redirect user to 'Settings' view
     *
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function show(Request $request, User $user): Response
    {
        return Inertia::render('Settings');
    }

    /**
     * Update settings
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $data = [
            'email' => $request->input('email')
        ];

        // If Password is provided
        if (!empty($request->input('password'))) {
            $data['password'] = Hash::make($request->input('password'));
        }

        // Update the user details
        $user->update($data);

        return redirect()->back()->with('success', 'Account settings submitted successfully');
    }
}
