<?php

use App\Http\Controllers\MyPokemonController;
use App\Http\Controllers\UserController;
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

Route::prefix('v1')->group(function () {

    Route::post('/auth/login/', [UserController::class, 'login']);
    Route::post('/auth/register/', [UserController::class, 'register']);

    Route::post('/pokemon/my-pokemons/', [MyPokemonController::class, 'getMyPokemons']);

    Route::post('/pokemon/catch-pokemon/', [MyPokemonController::class, 'catchPokemon']);
    Route::post('/pokemon/store-pokemon/', [MyPokemonController::class, 'storePokemon']);
    Route::post('/pokemon/rename-pokemon/', [MyPokemonController::class, 'renamePokemon']);

    Route::post('/pokemon/release-pokemon/', [MyPokemonController::class, 'releasePokemon']);
    Route::post('/pokemon/delete-pokemon/', [MyPokemonController::class, 'deletePokemon']);

});
