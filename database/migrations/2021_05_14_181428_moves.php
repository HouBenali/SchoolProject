<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Moves extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {       
         Schema::create('moves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poke_id')->constrained('pokemons');
            $table->string('move')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
          });
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
