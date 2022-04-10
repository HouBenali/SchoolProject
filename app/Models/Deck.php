<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    use HasFactory;

    protected $table = 'decks';

    public function poke1(){
        // return $this->belongsTo(Pokemon::class,"id");
        
        // return $this->hasMany(Pokemon::class,"pk_cart","id");
        return $this->belongsTo(Pokedex::class,"poke_1","id");
        
    }
    public function poke2(){
        // return $this->belongsTo(Pokemon::class,"id");
        
        // return $this->hasMany(Pokemon::class,"pk_cart","id");
        return $this->belongsTo(Pokedex::class,"poke_2","id");
        
    }
    public function poke3(){
        // return $this->belongsTo(Pokemon::class,"id");
        
        // return $this->hasMany(Pokemon::class,"pk_cart","id");
        return $this->belongsTo(Pokedex::class,"poke_3","id");
        
    }
    public function poke4(){
        // return $this->belongsTo(Pokemon::class,"id");
        
        // return $this->hasMany(Pokemon::class,"pk_cart","id");
        return $this->belongsTo(Pokedex::class,"poke_4","id");
        
    }
}
