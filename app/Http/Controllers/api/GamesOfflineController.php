<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GamesOffline;

class GamesOfflineController extends Controller
{
    //
    public function getGamesOff(){
        $id_user=\Auth::user()->id;
        $gmoff = GamesOffline::where('user_id', $id_user)->get();
        //dd($gmoff);
        if (count($gmoff) > 0){
            for ( $x=0; $x < count($gmoff); $x++ ){
                if ($gmoff[$x]->rewards != null ){
                    $gmoff[$x]->pokemon_op;
                    $gmoff[$x]->pokemon_player;
                    error_log($gmoff[$x]->pokemon_player);
                    $gmoff[$x]->rewards = "Yes";
                }else{
                    $gmoff[$x]->pokemon_op;
                    $gmoff[$x]->pokemon_player;
                    $gmoff[$x]->rewards = "No";
                }
            }
            return $gmoff;
        }else{
            return $gmoff;
        }
    }

}
