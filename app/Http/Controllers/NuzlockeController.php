<?php

namespace App\Http\Controllers;

use App\Http\Requests\NuzlockeRequest;
use App\Models\NuzlockeGame;
use App\Models\NuzlockeStatus;
use Auth;
use Illuminate\Http\RedirectResponse;
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
            'games' => auth()->user()->nuzlockeGames()->with('status')->get()
        ]);
    }

    /**
     * Create Nuzlocke
     *
     * @return RedirectResponse
     */
    public function create(NuzlockeRequest $request):RedirectResponse
    {
        NuzlockeGame::create([
            'name' => $request->get('name'),
            'player_count' => $request->get('player_count'),
            'status_id' => NuzlockeStatus::where('alias', 'in-progress')->first()->id,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->back()->with('success', 'Nuzlocke game created successfully.');
    }
}
