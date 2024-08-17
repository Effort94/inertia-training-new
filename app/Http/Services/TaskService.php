<?php

namespace App\Http\Services;

use App\Models\Task;

class TaskService
{
    public function fetchIndexDataForDatatable(): array
    {
        $tasks = Task::get()->take(10);

        return [
            'data' => $tasks
        ];
    }
}
