<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('email')->unique();
            $table->string('code_name')->unique();
            $table->string('password');
            $table->string('course');
            $table->tinyInteger('age')->unsigned();
            $table->tinyInteger('height')->unsigned();
            $table->string('gender');
        });

        Schema::create('profile', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->primary();
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users');

            $table->integer('games_won')->unsigned();
            $table->integer('total_games')->unsigned();
        });

        Schema::create('games', function (Blueprint $table) {
            $table->increments('game_id');
            $table->string('game_title');
            $table->tinyInteger('game_status')->unsigned();
            $table->tinyInteger('max_players')->unsigned();
            $table->tinyInteger('players_joined')->unsigned();
            $table->tinyInteger('available_slots')->unsigned();
            $table->dateTime('open_until');
        });

        Schema::create('game_info', function (Blueprint $table) {
            $table->integer('game_id')->unsigned()->primary();
            $table->foreign('game_id')
                  ->references('game_id')
                  ->on('games');

            $table->dateTime('date_started');
            $table->dateTime('date_finished');

            $table->integer('winner_user_id')->unsigned()->nullable();
            $table->foreign('winner_user_id')
                  ->references('user_id')
                  ->on('users');
        });

        Schema::create('players', function (Blueprint $table) {
            $table->increments('player_id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users');

            $table->integer('game_id')->unsigned();
            $table->foreign('game_id')
                  ->references('game_id')
                  ->on('games');

            $table->tinyInteger('total_number_kills')->unsigned();
            $table->boolean('is_eliminated');

            $table->integer('eliminated_by_user')->unsigned()->nullable();  // add nullable
            $table->foreign('eliminated_by_user')
                  ->references('user_id')
                  ->on('users');
        });

        Schema::create('weapons', function (Blueprint $table) {
            $table->increments('weapon_id');
            $table->string('weapon_name');
        });

        Schema::create('defences', function (Blueprint $table) {
            $table->increments('defence_id');
            $table->string('defence_name');
        });


        Schema::create('player_weapons', function (Blueprint $table) {
            $table->integer('player_id')->unsigned();
            $table->foreign('player_id')
                  ->references('player_id')
                  ->on('players')
                  ->onDelete('cascade');

            $table->integer('weapon_id')->unsigned();
            $table->foreign('weapon_id')
                  ->references('weapon_id')
                  ->on('weapons');
        });

        Schema::create('player_defences', function (Blueprint $table) {
            $table->integer('player_id')->unsigned();
            $table->foreign('player_id')
                  ->references('player_id')
                  ->on('players')
                  ->onDelete('cascade');

            $table->integer('defence_id')->unsigned();
            $table->foreign('defence_id')
                  ->references('defence_id')
                  ->on('defences');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
        Schema::drop('profile');
        Schema::drop('games');
        Schema::drop('game_info');
        Schema::drop('players');
        Schema::drop('weapons');
        Schema::drop('defences');
        Schema::drop('player_weapons');
        Schema::drop('player_defences');
    }
}
