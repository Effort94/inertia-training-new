<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountSettingsRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
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
     * @return JsonResponse
     */
    function store(AccountSettingsRequest $request, User $user): JsonResponse
    {
        // Update the user details
        $user->update([
            'email' => $request->input('email'),
            'password' => !empty($request->input('password')) ?? bcrypt($request->input('password'))
        ]);

        // Redirect back
        return response()->json([
            'status' => 200,
            'message'=>'Account settings updated'
        ]);
    }
}
