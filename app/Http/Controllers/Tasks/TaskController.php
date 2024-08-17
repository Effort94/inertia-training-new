<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Services\TaskService;
use Inertia\Controller;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('Tasks/Index');
    }

    public function indexData()
    {
        return app(TaskService::class)->fetchIndexDataForDatatable();
    }
}
