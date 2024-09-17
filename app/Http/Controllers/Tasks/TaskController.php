<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Requests\TaskRequest;
use App\Http\Services\TaskService;
use App\Models\Priority;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Controller;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Tasks/Index');
    }

    public function indexData(Request $request)
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
            Task::create([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'status' => 'pending',
                'priority_id' => Priority::where('id', $request->get('priority'))->firstOrFail()->id,
                'user_id' => Auth::user()->id,
            ]);

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
            $task->update([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'priority_id' => Priority::where('id', $request->get('priority'))->firstOrFail()->id,
            ]);

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
        try {
            // Delete the task
            $task->delete();

            // Redirect with success message using Inertia
            return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
        } catch (\Exception $e) {
            // Handle exception
            return redirect()->route('tasks.index')->with('error', 'Failed to delete task. Please try again.');
        }
    }
}
