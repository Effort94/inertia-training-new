<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
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

    /**
     * Format data ready for datatable
     *
     * @param array $pokemons
     * @return array
     */
    public function formatDataForDatatable(array $pokemons): array
    {
        $client = new Client();
        $pokemon_names = Arr::pluck($pokemons['results'], 'name');

        $promises = [];
        foreach ($pokemon_names as $pokemon_name) {
            // Create an asynchronous request
            $promises[] = $client->getAsync("https://pokeapi.co/api/v2/pokemon/{$pokemon_name}")
                ->then(
                    function ($response) use ($pokemon_name) {
                        $body = json_decode($response->getBody(), true);

                        $formattedData = [];
                        foreach (['abilities' => 'ability', 'types' => 'type'] as $key => $item) {
                            $values = Arr::pluck($body[$key], "{$item}.name");
                            $formattedData[$key] = implode("<br>", $values);
                        }
                        return [
                            'name' => $pokemon_name,
                            'abilities' => $formattedData['abilities'],
                            'types' => $formattedData['types'],
                            'height' => $body['height'],
                            'weight' => $body['weight'],
                        ];
                    }
                );
        }

        $data = [];
        foreach ($promises as $promise) {
            $result = $promise->wait();
            if ($result['name']) {
                $data[] = $result;
            }
        }

        return $data;
    }
    public function prepareDatatableHeaders(): array
    {
        return [
            'name',
            'abilities',
            'type',
            'height',
            'weight'
        ];
    }
}
