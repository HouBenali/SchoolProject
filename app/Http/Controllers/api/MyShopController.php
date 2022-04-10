<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Shop;

class MyShopController extends ApiResponseController
{
    //
    public function getMyShops(){
       
        $id_user=\Auth::user()->id;
        $shops = Shop::where('user_id', $id_user)->get();
        //dd($shops);
        //$date = strtotime($shops[0]->created_at);
        // dd(date( 'Y-m-d H:i:s', $date ));
        //
        if (count($shops) > 0){
            for ( $x=0; $x < count($shops); $x++ ){
                
                $poke=getPokeById($shops[$x]->poke_id);
                
                //$poke = $shops[$x]->pokemon->first();
                $poke->moves = unserialize($poke->moves);
                $array_moves = [];
                for ( $i=0; $i < count($poke->moves); $i++ ){
                    array_push($array_moves, json_decode($poke->moves[$i]));
                    
                }
                $poke->moves = $array_moves;
                $shops[$x]->poke_id = $poke;
            }
            
            return $shops;
            // return $this->successResponse($shops);
        }else{
            
            return [];
        }
    }
}
