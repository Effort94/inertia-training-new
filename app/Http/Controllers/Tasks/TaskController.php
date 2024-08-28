<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Services\TaskService;
use App\Models\Priority;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Controller;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('Tasks/Index');
    }

    public function indexData(Request $request)
    {
        $parameters = [
            'search' => $request->get('search'),
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
        $test = Priority::select('name', 'id')->distinct()->pluck('name', 'id');

        return response()->json([
            'priorities' => $priorities,
            'test' => $test
        ]);
    }
}
