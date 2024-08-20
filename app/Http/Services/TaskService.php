<?php

namespace App\Http\Services;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class TaskService
{
    public function fetchIndexDataForDatatable(array $parameters): array
    {
        $query = Task::query();

        $query = $this->filterIndexData($query, $parameters);

        // Format Data
        $tasks = $query->get();
        $tasks = $this->formatIndexData($tasks);

        return [
            'data' => $tasks
        ];
    }

    public function formatIndexData(Collection $tasks): array
    {
        return [
            'data' => $tasks->map(function ($task) {
                return [
                    'title' => $task->title,
                    'description' => $task->description,
                    'priority' => $this->getPriorityIcon($task->priority),
                ];
            })->toArray()
        ];
    }

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
                $query->orderBy($parameters['sort_field'], $parameters['sort_order']);
            }

            $query->orderBy($parameters['sort_field'], $parameters['sort_order']);
        }

        return $query;
    }

    public function getPriorityIcon(String $priority): string
    {
        return match ($priority) {
            'high' => '<span class="fa-solid fa-arrow-up"></span>',
            'medium' => '<span class="fa-solid fa-arrow-right"></span>',
            'low' => '<span class="fa-solid fa-arrow-down"></span>',
            default => '❓',
        };
    }
}
