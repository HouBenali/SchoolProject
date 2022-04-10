<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainDeck extends Model
{
    use HasFactory;

    protected $table = 'main_decks';

    public function getMainDeck(){
        // return $this->belongsTo(Pokemon::class,"id");
        
        // return $this->hasMany(Pokemon::class,"pk_cart","id");
        return $this->belongsTo(Deck::class,"deck_id","id");
        
    }
}
