<?php

namespace App\Http\Controllers\Task;

use App\Http\Requests\TaskRequest;
use App\Http\Services\TaskService;
use App\Models\Priority;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Controller;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    /**
     * Return Task Index view.
     *
     * @return Response
     * @codeCoverageIgnore Don't test views.
     */
    public function index(): Response
    {
        return Inertia::render('Tasks/Index');
    }

    /**
     * Fetch data required for tasks datatable.
     *
     * @param Request $request
     * @return array[]
     * @codeCoverageIgnore Don't test helpers. Tested in the service test.
     */
    public function indexData(Request $request): array
    {
        $parameters = [
            'search' => $request->get('search'),
            'filters' => $request->get('filters'),
            'sort_field' => $request->get('sortField', 'id'),
            'sort_order' => $request->get('sortOrder', 'asc'),
            'page' => $request->get('page', 1),
            'limit' => $request->get('limit', 10),
        ];

        return app(TaskService::class)->fetchIndexDataForDatatable($parameters);
    }

    /**
     * Get filter options for Tasks Datatable
     *
     * @return JsonResponse
     */
    public function getFilters(): JsonResponse
    {
        $priorities = Priority::select('name', 'id')->distinct()->pluck('name', 'id');

        return response()->json([
            'priorities' => $priorities,
        ]);
    }

    /**
     * get task details
     *
     * @param Task $task
     * @return JsonResponse
     * @codeCoverageIgnore Don't test views.
     */
    public function show(Task $task): JsonResponse
    {
        return response()->json([
            'task' => $task
        ]);
    }

    /**
     * Store a new Task
     *
     * @param TaskRequest $request
     * @return RedirectResponse
     */
    public function store(TaskRequest $request): RedirectResponse
    {
        try {
            app(TaskService::class)->save($request->all());
            return redirect()->back()->with('success', 'Task created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create task. Please try again.');
        }
    }

    /**
     * Update Task
     *
     * @param TaskRequest $request
     * @param Task $task
     * @return RedirectResponse
     */
    public function update(TaskRequest $request, Task $task): RedirectResponse
    {
        try {
            app(TaskService::class)->save($request->all(), $task);
            return redirect()->back()->with('success', 'Task updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update task. Please try again.');
        }
    }

    /**
     * Delete Task
     *
     * @param Task $task
     * @return RedirectResponse
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }
}
