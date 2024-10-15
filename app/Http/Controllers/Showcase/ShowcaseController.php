<?php

namespace App\Http\Controllers\Showcase;

use Inertia\Controller;
use Inertia\Inertia;
use Inertia\Response;

class ShowcaseController extends Controller
{
    public function index(): Response
    {
        $showcases = [
            [
                'name' => 'Task Datatable + CRUD',
                'description' => 'A datatable created with Vue.JS. Also contains a working Task CRUD system.',
                'link' => route('tasks.index'),
                'skills'=> ['Laravel', 'vue.js', 'tailwind']
            ],
            [
                'name' => 'Authorization System',
                'description' => 'A user authentication system with registration, login, and account settings.',
                'link' => route('login.show')
            ],
            [
                'name' => 'Pokemon Nuzlocke Helper',
                'description' => 'A system to help track soul links, nuzlockes through useful tracking, advice and help.',
                'link' => route('nuzlocke.show')
            ],
        ];

        return Inertia::render('Showcase/Index', [
            'showcases' => $showcases
        ]);
    }
}
