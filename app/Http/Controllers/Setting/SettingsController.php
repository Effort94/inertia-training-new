<?php

namespace App\Http\Controllers\Setting;

use App\Http\Requests\AccountSettingsRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Controller;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    /**
     * Redirect user to 'Settings' view
     *
     * @codeCoverageIgnore Don't test views.
     * @return Response
     */
    public function show(Request $request, User $user): Response
    {
        return Inertia::render('Settings');
    }

    /**
     * Update settings
     *
     * @return RedirectResponse\
     */
    public function update(AccountSettingsRequest $request, User $user): RedirectResponse
    {
        $data = [
            'email' => $request->input('email'),
        ];

        // If Password is provided
        if (! empty($request->input('password'))) {
            $data['password'] = Hash::make($request->input('password'));
        }

        // Update the user details
        $user->update($data);

        return redirect()->back()->with('success', 'Account settings updated successfully');
    }
}
