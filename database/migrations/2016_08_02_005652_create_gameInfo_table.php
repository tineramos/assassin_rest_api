<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_info', function (Blueprint $table) {
            $table->integer('game_id')->primary();
            $table->dateTime('date_started');
            $table->dateTime('date_finished');
            $table->string('winner');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('game_info');
    }
}
