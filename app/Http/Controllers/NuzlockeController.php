<?php

namespace App\Http\Controllers;

use App\Http\Requests\NuzlockeRequest;
use App\Models\NuzlockeGame;
use Inertia\Controller;
use Inertia\Inertia;
use Inertia\Response;

class NuzlockeController extends Controller
{
    /**
     * Nuzlocke index view.
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render("Pokemon/Nuzlocke/Show", [
            'games' => auth()->user()->nuzlockeGames()->get()
        ]);
    }

    /**
     * Create Nuzlocke
     *
     * @return void
     */
    public function create(NuzlockeRequest $request)
    {
        NuzlockeGame::create([
            'name' => $request->get('name'),
            'player_count' => $request->get('player_count'),
        ]);
    }
}
