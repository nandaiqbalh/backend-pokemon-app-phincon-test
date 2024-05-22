<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MyPokemon extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'pokemon_id',
        'name',
        'nickname',
        'url',
        'rename_flag',
    ];

    public static function getMyPokemons($userId)
    {
        return DB::table('my_pokemons')
            ->where('user_id', $userId)
            ->orderBy('id', 'desc') // Sort by ID in descending order
            ->paginate(20);
    }

    public static function checkPokemon($userId, $pokemonId)
    {
        return DB::table('my_pokemons as a')
            ->where('a.user_id', $userId)
            ->where('a.pokemon_id', $pokemonId)
            ->first();
    }

    public static function insertPokemon($params)
    {
        return DB::table('my_pokemons')->insert($params);
    }

    public static function deletePokemon($userId, $pokemonId)
    {
        return DB::table('my_pokemons')
            ->where('user_id', $userId)
            ->where('pokemon_id', $pokemonId)
            ->delete();
    }

}
