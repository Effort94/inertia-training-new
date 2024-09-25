<?php

namespace App\Http\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class PokemonService
{
    /**
     * Prepare the data required for the tasks datatable.
     *
     * @param array $parameters
     * @return array[]
     */
    public function fetchIndexDataForDatatable(array $parameters): array
    {
        $pokemons = Http::get("https://pokeapi.co/api/v2/pokemon/?limit={$parameters['limit']}")->json();

        $next_page = $pokemons['next'];
        $previous_page = $pokemons['previous'];

        $data = $this->formatDataForDatatable($pokemons);

        return [
            'headers' => $this->prepareDatatableHeaders(),
            'data' => $data,
            'previous_page' => $previous_page,
            'next_page' => $next_page,
        ];
    }

    public function formatDataForDatatable(array $pokemons)
    {
        $pokemon_names = Arr::pluck($pokemons['results'], 'name');

        foreach ($pokemon_names as $pokemon_name)
        {

        }
    }

    public function prepareDatatableHeaders(): array
    {
        return [
            'icon',
            'name',
            'type',
            'generation'
        ];
    }
}
