<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Game\LeagueOfLegendController;
use App\Http\Controllers\Settings\SettingsController;
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
Route::get('login', [LoginController::class, 'show'])->name('login.show');
Route::post('login', [LoginController::class, 'store'])->name('login.store');
Route::get('register', [RegisterController::class, 'show'])->name('register.show');
Route::post('register', [RegisterController::class, 'create'])->name('register.create');

// Auth Routes
Route::middleware('auth')->group(function() {
    Route::get('/', function () {
        return Inertia::render('Home', [
            'name' => 'Warren',
            'frameworks' => [
                'Laravel', 'Vue', 'Inertia'
            ],
        ]);
    })->name('home');

    Route::prefix('users/{user}')->group(function () {
        Route::prefix('settings')->group(function () {
            Route::get('/', [SettingsController::class, 'show'])->name('settings.show');
            Route::post('update', [SettingsController::class, 'store'])->name('settings.update');
        });
    });

    Route::prefix('league-of-legends')->group(function () {
        Route::get('/', [LeagueOfLegendController::class, 'show'])->name('league.show');
    });

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});
