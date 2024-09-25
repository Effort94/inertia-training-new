<?php

use App\Http\Controllers\Pokemon\PokemonController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Pokemon API
Route::prefix('pokemon')->group(function () {
    Route::get('/index-data', [PokemonController::class, 'indexData'])->name('pokemon.data');
});
