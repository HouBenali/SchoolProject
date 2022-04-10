<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamesOffline extends Model
{
    use HasFactory;
    protected $table = 'games_offline';

    public function pokemon_player(){
        return $this->belongsTo(Pokemon::class,"poke_player","id");
    }

    public function pokemon_op(){
        return $this->belongsTo(Pokemon::class,"poke_op","id");
    }

    public function pokemon_reward(){
        return $this->belongsTo(Pokemon::class,"rewards","id");
    }
    //

}