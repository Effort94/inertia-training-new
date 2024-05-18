<?php

use App\Http\Controllers\Auth\LoginController;
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
Route::post('login', [LoginController::class, 'store'])->name('store');


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

    Route::get('/settings', function () {
        return Inertia::render('Settings');
    });

    Route::post('logout', function () {
        dd('logging the user out');
    });
});

