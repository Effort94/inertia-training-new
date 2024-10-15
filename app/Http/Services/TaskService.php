<?php

namespace App\Http\Services;

use App\Models\Task;
use Auth;
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
        if (isset($parameters['search'])) {
            $query->where(function ($query) use ($parameters) {
                $query->where('title', 'like', '%' . $parameters['search'] . '%')
                    ->orWhere('description', 'like', '%' . $parameters['search'] . '%');
            });
        }

        // filters
        if (isset($parameters['filters'])) {
            foreach ($parameters['filters'] as $key => $value) {
                if ($key === 'priorities' && !empty($value)) {
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

    /**
     * Attempt to create / update a Task.
     *
     * @param array $data
     * @param ?Task $task
     * @return bool
     */
    public function save(array $data, ?Task $task = null): bool
    {
        $attributes = [
            'title' => $data['title'],
            'description' => $data['description'],
            'priority_id' => $data['priority'],
            'user_id' => Auth::user()->id,
        ];

        $conditions = isset($task) ? ['id' => $task->id] : [];

        Task::query()->updateOrCreate($conditions, $attributes);

        return true;
    }
}
