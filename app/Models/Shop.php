<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $table = 'shop';

    public function pokemon(){
        // return $this->belongsTo(Pokemon::class,"id");
        
        // return $this->hasMany(Pokemon::class,"pk_cart","id");
        return $this->belongsTo(Pokemon::class,"poke_id","id");
        
    }

}
