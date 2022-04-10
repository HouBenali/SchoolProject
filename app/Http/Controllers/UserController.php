<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pokemon;
use App\Models\Pokedex;
use App\Models\Cart;
use App\Models\Shop;
use App\Models\GamesOffline;
use Cookie;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $users=User::all();
        return $users;
    }

    public function store(Request $request){
        $user=User::create($request->all());
        return $user;
    }

    public function setPokemon(Request $request){
        //Añade pokemon a la tabla pokemons
        $user=userData();
        $poke = Pokemon::create([
            'user_id' => $user->id,
            'poke_id' => $request->id,
        ]);
        
        return $poke;
    }

    public function setRewards(Request $request){
        $user=userData();
  
        $gmOff = new GamesOffline();
        $gmOff->user_id = $user->id;
        $gmOff->poke_player = $request->poke_player;
        $gmOff->poke_op = $request->poke_op;
        $gmOff->wins = $request->wins;
        $pokemons= userPokesID();

        //error_log($request->coins);
        //error_log($request->droppedPokemon);
        
        $coins=$request->coins;
        $gmOff->coins = $coins;
        $coins=$coins+$user->coins;
        //error_log($coins);

        DB::table('users')
            ->where('id',$user->id)
            ->update(['coins' => $coins]); 
        
        if (in_array($request->droppedPokemon, $pokemons) || $request->droppedPokemon==null){
            //error_log('pokemon already owned');
            $gmOff->rewards = null;
            $request->droppedPokemon=null;
        } else{
            $gmOff->rewards = $request->droppedPokemon;
            $poke = Pokemon::create([
                'user_id' => $user->id,
                'poke_id' => $request->droppedPokemon,
            ]);
        }
        $gmOff->save();
    }


    public function restar_price (Request $request) {
        
        $price = $request->all()['price'];
        $user=userData();
        $res = $user->coins -= $price;
        $user->save();
        return $res;
    }

    public function sumar_price (Request $request) {

        $price = $request->all()['price'];
        $user=userData();
        $res = $user->coins += $price;
        // dd($user);
        $user->save();
        return $res;
    }

    public function pokesUser(){

        $myPokes=[];
        $pokemons = userPokes();
       
        for ($i=0; $i < count($pokemons); $i++) { 
            array_push($myPokes, $pokemons[$i]->poke_id);
            }
            
        return $myPokes;
    }

    public function hasPokes(){
        
        if(count(userPokes())>0){
            return true;
        } 
        else {
            return false;
        }
    }

    public function setCookie(Request $request){
        $response = new Response('Set Cookie');
        $response->withCookie(Cookie::make('data001', 'data', null, null, null, false, false));
        return $response;

    }

}

