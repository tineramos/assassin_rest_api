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
        // DO NOT MODIFY //
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('email')->unique();
            $table->string('password');

            $table->string('code_name')->unique();
            $table->string('course');
            $table->string('gender');

            $table->tinyInteger('age')->unsigned();
            $table->tinyInteger('height')->unsigned();

            $table->binary('profile_photo');
        });

        // DO NOT MODIFY //
        Schema::create('profile', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->primary();
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->integer('games_won_count')->unsigned();
            $table->integer('total_games_count')->unsigned();

            $table->float('average_kill_per_game');
        });

        // DO NOT MODIFY //
        Schema::create('games', function (Blueprint $table) {
            $table->increments('game_id');

            $table->string('game_title');
            $table->string('game_location');

            $table->enum('game_status', array('open', 'ongoing', 'closed', 'finished', 'cancelled'))
                  ->default('open');

            $table->tinyInteger('max_players')->unsigned();
            $table->tinyInteger('players_joined')->unsigned();
            $table->tinyInteger('available_slots')->unsigned();

            $table->dateTime('open_until');
            $table->dateTime('date_started')->nullable();
            $table->dateTime('date_finished')->nullable();

            $table->integer('winner_user_id')->unsigned()->nullable();
            $table->foreign('winner_user_id')
                  ->references('user_id')
                  ->on('users');

            $table->integer('winner_player_id')->unsigned()->nullable();
            $table->foreign('winner_player_id')
                  ->references('player_id')
                  ->on('players');
        });

        // DO NOT MODIFY //
        Schema::create('players', function (Blueprint $table) {
            $table->increments('player_id');

            // null if the user object is deleted in the database
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users');

            $table->integer('game_id')->unsigned();
            $table->foreign('game_id')
                  ->references('game_id')
                  ->on('games')
                  ->onDelete('cascade');

            $table->integer('target_id')->unsigned()->nullable()->references('player_id')->on('players');
            $table->integer('assassin_id')->unsigned()->nullable()->references('player_id')->on('players');
            $table->integer('eliminated_by_player')->unsigned()->nullable()->references('player_id')->on('players');

            $table->boolean('is_eliminated')->default(false);
            $table->tinyInteger('kills_count')->unsigned();

            // initial health points - 100
            $table->float('health_points')->default('100.0');
            $table->timestamps();
        });

        // DO NOT MODIFY //
        Schema::create('weapons', function (Blueprint $table) {
            $table->increments('weapon_id');
            $table->string('weapon_name');
        });

        // DO NOT MODIFY //
        Schema::create('defences', function (Blueprint $table) {
            $table->increments('defence_id');
            $table->string('defence_name');
        });

        // DO NOT MODIFY //
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

            // update this value when user has chosen his/her weapons
            $table->tinyInteger('shots_left')->unsigned();
            $table->boolean('in_use')->default(false);

            $table->timestamps();
        });

        // DO NOT MODIFY //
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

            $table->tinyInteger('quantity')->unsigned()->default(1);
            $table->boolean('in_use')->default(false);
            $table->boolean('authorize_usage')->default(true);

            $table->timestamps();
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
        Schema::drop('players');
        Schema::drop('weapons');
        Schema::drop('defences');
        Schema::drop('player_weapons');
        Schema::drop('player_defences');
    }
}
