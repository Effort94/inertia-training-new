<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountSettingsRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * Redirect user to 'Account Settings' view
     *
     * @return Response
     */
    function show(): Response
    {
        return Inertia::render('Settings');
    }

    /**
     * Store account settings
     *
     * @param AccountSettingsRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    function store(AccountSettingsRequest $request, User $user): RedirectResponse
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
