<?php

namespace App\Http\Services;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;

class TaskService
{
    /**
     * Prepare the data required for the tasks datatable.
     *
     * @param array $parameters
     * @return array[]
     */
    public function fetchIndexDataForDatatable(array $parameters): array
    {
        // Base Query
        $query = Task::query();

        // Apply filters
        $query = $this->filterIndexData($query, $parameters);

        // Apply pagination
        $tasks = $query->paginate($parameters['limit']);

        // assign pagination variables
        $pagination = [
            'last_page' => $tasks->lastPage(),
            'previous_page' => $tasks->previousPageUrl(),
            'next_page' => $tasks->nextPageUrl(),
            'current_page' => $tasks->currentPage(),
            'from' => $tasks->firstItem(),
            'to' =>  $tasks->lastItem(),
        ];

        // Work out total records and format data
        $total_records = $tasks->total();


        // Format data for datatable
        $tasks = $this->formatIndexData($tasks->items());

        return [
            'headers' => $this->prepareDatatableHeaders(),
            'data' => $tasks,
            'last_page' => $pagination['last_page'],
            'total_records' => $total_records,
            'previous_page' =>  $pagination['previous_page'],
            'next_page' => $pagination['next_page'],
            'current_page' => $pagination['current_page'],
            'from' => $pagination['from'],
            'to' => $pagination['to']
        ];
    }

    /**
     * Format data
     *
     * @param array $tasks
     * @return array
     */
    public function formatIndexData(array $tasks): array
    {
        $data = [];
        foreach ($tasks as $task) {
            $data[] = [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'priority' => "<span class=\"{$task->priority->icon}\"></span>",
            ];
        }

        return $data;
    }

    /**
     * Handles filtering the query for the tasks datatable
     *
     * @param Builder $query
     * @param array $parameters
     * @return Builder
     */
    public function filterIndexData(Builder $query, array $parameters): Builder
    {
        // Search
        $query = $query->when($parameters['search'] ?? null, function ($query, $keyword) {
            return $query->where('title', 'like', '%' . $keyword . '%')
                ->orWhere('description', 'like', '%' . $keyword . '%');
        });

        //filters
        if (isset($parameters['filters'])) {
            foreach ($parameters['filters'] as $key => $value) {
                if ($key === 'priorities') {
                    $query->where('priority_id', $value);
                }
            }
        }

        // Order
        if (isset($parameters['sort_field'])) {

            if ($parameters['sort_field'] === 'priority') {
                $query->orderBy('priority_id', $parameters['sort_order']);
            } else {
                $query->orderBy($parameters['sort_field'], $parameters['sort_order']);
            }
        }

        return $query;
    }

    public function prepareDatatableHeaders(): array
    {
        return [
            'title',
            'description',
            'priority'
        ];
    }
}
