<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Pokemon;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';

    public function pokemon(){
        // return $this->belongsTo(Pokemon::class,"id");
        
        // return $this->hasMany(Pokemon::class,"pk_cart","id");
        return $this->belongsTo(Pokemon::class,"poke_id","id");
        
    }
    // public function pokemons(){
    //     return $this->hasMany(Pokemon::class,"id");
    // }

    // public function pokemon(){
    //     return $this->hasMany('\App\Models\Pokemon', 'id', 'poke_id');
    //     // return $this->HasMany(Pokemon::class);
    // }
}
