<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Services\TaskService;
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
        ];

        return app(TaskService::class)->fetchIndexDataForDatatable($parameters);
    }
}
