<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        // Schema::create('cart', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('user_id')->constrained('users');
        //     $table->foreignId('poke_id')->constrained('pokemons');
        //     $table->dateTime('created_at');
        //     $table->dateTime('updated_at');
            
        //  });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
