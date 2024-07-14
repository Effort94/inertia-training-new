<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Game\LeagueOfLegendController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Non Auth Routes
Route::get('login', [LoginController::class, 'create'])->name('login');
Route::post('login', [LoginController::class, 'store']);

// Auth Routes
Route::middleware('auth')->group(function() {
    Route::get('/', function () {
        return Inertia::render('Home', [
            'name' => 'Warren',
            'frameworks' => [
                'Laravel', 'Vue', 'Inertia'
            ],
        ]);
    });

    Route::prefix('/users/{user}/')->group(function () {
        Route::prefix('/settings')->group(function () {
            Route::get('', [UserController::class, 'show']);
            Route::post('/store', [UserController::class, 'store']);
        });
    });

    Route::prefix('league-of-legends')->group(function () {
        Route::get('/', [LeagueOfLegendController::class, 'show']);
    });

    Route::post('logout', [LoginController::class, 'logout']);
});

