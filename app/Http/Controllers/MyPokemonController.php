<?php

namespace App\Http\Controllers;

use App\Models\MyPokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MyPokemonController extends Controller
{

    public function getMyPokemons(Request $request)
    {

        // Fetch user's pokemons
        $myPokemons = MyPokemon::getMyPokemons($request->user_id);

        if ($myPokemons->isEmpty()) {
            return $this->failedResponse('No pokemons found for this user.');
        }

        return $this->successResponse('Success to get my pokemons data.', $myPokemons);
    }

    public function catchPokemon(Request $request)
    {
        // Generate a random number (0 or 1)
        $catchSuccess = rand(0, 1);

        $pokemonId = $request->pokemon_id;
        $userId = $request->user_id;

        $isExist = MyPokemon::checkPokemon($userId, $pokemonId);

        if ($isExist == null) {
            // Check if catching the Pokémon is successful
            if ($catchSuccess === 1) {
                // Catch successful
                return $this->successResponse('Catch successful', null);
            } else {
                // Catch failed
                return $this->failedResponse('Catch failed');
            }
        } else {
            // pokemon already caught
            return $this->failedResponse('Pokemon already in your bag.');

        }

    }

    public function storePokemon(Request $request)
    {
        // Custom validation rules
        $rules = [
            'user_id' => ['required'],
            'pokemon_id' => 'required',
            'name' => 'required', // Limit name length to 255 characters
            'nickname' => 'nullable', // Limit nickname length to 255 characters (optional)
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            // Retrieve the first error message
            $firstErrorMessage = $validator->errors()->first();

            // Return an error response with the first error message
            return $this->failedResponse($firstErrorMessage);
        }

        // Prepare the parameters for insertion
        $params = [
            'user_id' => $request->user_id,
            'pokemon_id' => $request->pokemon_id,
            'name' => $request->name,
            'nickname' => $request->nickname,
            'rename_flag' => null,
        ];

        // Insert the Pokémon into the my_pokemons table
        try {
            $store = MyPokemon::insertPokemon($params);
            if ($store) {
                return $this->successResponse('Pokémon stored successfully', $params);
            } else {
                return $this->failedResponse('Failed to store Pokémon (Insert failed)'); // More specific error message
            }
        } catch (\Exception $e) {
            // Handle potential database errors or other exceptions during insert
            return $this->failedResponse('Failed to store Pokémon (Database error): ' . $e->getMessage());
        }
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
