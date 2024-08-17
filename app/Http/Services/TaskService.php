<?php

namespace App\Http\Services;

use App\Models\Task;

class TaskService
{
    public function fetchIndexDataForDatatable(array $parameters): array
    {
        $tasks = Task::when($parameters['search'], function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%')
                            ->orWhere('description', 'like', '%' . $search . '%');
        })
            ->orderBy($parameters['sort_field'], $parameters['sort_order'])
            ->paginate();

        return [
            'data' => $tasks
        ];
    }
}
