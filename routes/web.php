<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Setting\SettingsController;
use App\Http\Controllers\Task\TaskController;
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
Route::get('login', [LoginController::class, 'show'])->name('login.show');
Route::post('login', [LoginController::class, 'store'])->name('login.store');
Route::get('register', [RegisterController::class, 'show'])->name('register.show');
Route::post('register', [RegisterController::class, 'create'])->name('register.create');

// Auth Routes
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Home', [
           'profilePhotoUrl' => asset('images/profile-photo.jpg')
        ]);
    })->name('home');

    Route::prefix('users/{user}')->group(function () {
        Route::prefix('settings')->group(function () {
            Route::get('/', [SettingsController::class, 'show'])->name('settings.show');
            Route::post('update', [SettingsController::class, 'update'])->name('settings.update');
        });
    });

    Route::prefix('tasks')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
        Route::get('/index-data', [TaskController::class, 'indexData'])->name('tasks.data');
        Route::get('/index-data/filters', [TaskController::class, 'getFilters'])->name('tasks.filters');
        Route::post('/', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('/{task}', [TaskController::class, 'show'])->name('tasks.show');
        Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('task.edit');
        Route::put('/{task}', [TaskController::class, 'update'])->name('task.update');
        Route::delete('/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    });

    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});
