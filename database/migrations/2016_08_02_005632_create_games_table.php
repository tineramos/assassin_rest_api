<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('game_id');
            $table->string('game_title');
            $table->tinyInteger('game_status')->unsigned();
            $table->tinyInteger('max_players')->unsigned();
            $table->tinyInteger('players_joined')->unsigned();
            $table->tinyInteger('available_slots')->unsigned();
            $table->dateTime('open_until');
            $table->integer('winner_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('games');
    }
}
