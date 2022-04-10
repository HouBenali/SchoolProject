<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('users', function (Blueprint $table) {
        // $table->id();
        // $table->string('nick');
        // $table->string('email')->unique();
        // $table->string('password');
        // $table->string('image')->nullable();
        // $table->integer('coins')->default('0');
        // $table->string('cart')->nullable();
        // $table->string('pokemons')->nullable();
        // $table->integer('game_played')->default('0');
        // $table->integer('wins')->default('0');
        // $table->integer('loses')->default('0');
        // $table->string('turn')->nullable();
        // $table->dateTime('created_at');
        // $table->dateTime('updated_at');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
