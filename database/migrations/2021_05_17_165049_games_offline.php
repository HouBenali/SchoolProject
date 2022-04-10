<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GamesOffline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('games_offline', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('user_id')->constrained('users');
        //     $table->foreignId('poke_player')->constrained('pokemons');
        //     $table->foreignId('poke_op')->constrained('pokemons');
        //     $table->integer('rewards')->nullable();
        //     $table->integer('wins')->nullable();
        //     $table->integer('coins')->default('0');
        //     $table->dateTime('created_at');
        //     $table->dateTime('updated_at');
        // });
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
