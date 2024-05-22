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

    public static function getMyPokemons($user_id)
    {
        return DB::table('my_pokemons as a')
            ->where('a.user_id', $user_id)
            ->get();
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
}
