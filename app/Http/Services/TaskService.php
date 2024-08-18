<?php

namespace App\Http\Services;

use App\Models\Task;

class TaskService
{
    public function fetchIndexDataForDatatable(array $parameters): array
    {
        $query = Task::query();

        // Search
        if (isset($parameters['search'])) {
            $query = $query->when($parameters['search'] ?? null, function ($query, $keyword) {
                return $query->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        }

        // Order
        if (isset($parameters['sort_field'])) {
            $query->orderBy($parameters['sort_field'], $parameters['sort_order']);
        }

        // data
        $tasks = $query->paginate();

        return [
            'data' => $tasks
        ];
    }
}
