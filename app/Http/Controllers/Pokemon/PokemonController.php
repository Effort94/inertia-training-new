<?php

namespace App\Http\Controllers\Pokemon;

use App\Http\Services\PokemonService;
use Illuminate\Http\Request;
use Inertia\Controller;
use Inertia\Inertia;
use Inertia\Response;

class PokemonController extends Controller
{
    /**
     * Pokemon datatable index
     *
     * @codeCoverageIgnore Don't test views.
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Pokemon/Index');
    }

    public function indexData(Request $request)
    {
        $parameters = [
            'search' => $request->get('search'),
            'page' => $request->get('page', 1),
            'limit' => $request->get('limit', 10),
            'sort_field' => $request->get('sortField', 'id'),
            'sort_order' => $request->get('sortOrder', 'asc'),
        ];
        return app(PokemonService::class)->fetchIndexDataForDatatable($parameters);
    }
}
