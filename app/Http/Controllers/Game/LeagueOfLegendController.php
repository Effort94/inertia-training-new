<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class LeagueOfLegendController extends Controller
{
    /**
     * Redirect user to 'Account Settings' view
     *
     * @return Response
     */
    function show(): Response
    {
        return Inertia::render('Game/LeagueOfLegends');
    }
}
