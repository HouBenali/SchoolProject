<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pokedex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('pokedex', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image_path');
            $table->integer('HP')->nullable();
            $table->integer('ATK')->nullable();
            $table->integer('DEF')->nullable();
            $table->integer('SPD')->nullable();
            $table->string('type')->nullable();
            $table->string('moves')->nullable();
            $table->string('rarity')->nullable();
            $table->integer('price')->nullable();
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
