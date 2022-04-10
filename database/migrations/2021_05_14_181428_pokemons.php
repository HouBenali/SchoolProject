<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pokemons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        //  Schema::create('pokemons', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('user_id')->constrained('users');
        //     $table->foreignId('poke_id')->constrained('pokedex');
        //     $table->string('nature')->nullable();
        //     $table->string('ability')->nullable();
        //     $table->string('move1')->nullable();
        //     $table->string('move2')->nullable();
        //     $table->string('move3')->nullable();
        //     $table->string('move4')->nullable();
        //     $table->dateTime('created_at');
        //     $table->dateTime('updated_at');
            
        //   });
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
