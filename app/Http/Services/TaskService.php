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
        $query = Task::query();

        $query = $this->filterIndexData($query, $parameters);

        // Format Data
        $tasks = $query->paginate($parameters['limit']);

        // assign pagination
        $last_page = $tasks->lastPage();
        $previous_page = $tasks->previousPageUrl();
        $next_page = $tasks->nextPageUrl();
        $current_page = $tasks->currentPage();
        $from = $tasks->firstItem();
        $to =  $tasks->lastItem();

        // Work out total records and format data
        $total_records = $tasks->total();

        $headers = $this->prepareDatatableHeaders();
        $tasks = $this->formatIndexData($tasks->items());

        return [
            'headers' => $headers,
            'data' => $tasks,
            'last_page' => $last_page,
            'total_records' => $total_records,
            'previous_page' => $previous_page,
            'next_page' => $next_page,
            'current_page' => $current_page,
            'from' => $from,
            'to' => $to
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
