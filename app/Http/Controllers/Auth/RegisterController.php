<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

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
}
