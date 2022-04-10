<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $games=Game::all();
        return $games;
    }

    public function store(Request $request){
        $game=Game::create($request->all());
        return $game;
    }
}

