<?php

namespace App\Http\Controllers;

use App\Models\MyPokemon;
use Illuminate\Http\Request;

class MyPokemonController extends Controller
{

    public function getMyPokemons(Request $request)
    {

        // Fetch user's pokemons
        $my_pokemons = MyPokemon::getMyPokemons($request->user_id);

        if (is_null($my_pokemons) || $my_pokemons->isEmpty()) {
            return $this->failedResponse('No pokemons found for this user.');
        }

        return $this->successResponse('Success to get my pokemons data.', $my_pokemons);
    }

    public function catchPokemon(Request $request)
    {

    }

    private function failedResponse($errorMessage)
    {
        return response()->json([
            'success' => false,
            'status' => $errorMessage,
            'data' => null,
        ]);
    }

    private function successResponse($message, $data)
    {
        return response()->json([
            'success' => true,
            'status' => $message,
            'data' => $data,
        ]);
    }

}
