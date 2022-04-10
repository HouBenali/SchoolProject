<?php

use App\Models\User;
use App\Models\Pokemon;
use App\Models\Pokedex;

if (! function_exists('current_user')) {
    function userData()
    {   
        
        $id=auth()->user()->id;
        return $user=User::where('id',$id)->first();
    }

    function userPokes()
    {   
        $user = userData();
        $pokemons = Pokemon::where('user_id',$user->id)->get();
        return $pokemons;
    }

    function getPokeById($id)
    {   
        $pokemon = Pokedex::where('id',$id)->first();
        return $pokemon;
    }

    function userPokesID()
    {  
        $arrayIdPokes=[];
        $pokemons = userPokes();
        for ($i=0; $i < count($pokemons) ; $i++) { 
            array_push($arrayIdPokes,$pokemons[$i]->poke_id);
        }
        return $arrayIdPokes;
    }
}
