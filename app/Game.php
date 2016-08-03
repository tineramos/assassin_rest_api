<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['game_title', 'game_status', 'max_players',
                           'players_joined', 'available_slots', 'open_until'];

    protected $table = 'games';
    protected $primaryKey = 'game_id';

    public $timestamps = false;

    // define relationship
    // first argument passed to the hasOne method is the name of the related model
    public function game_details() {
        return $this->hasOne('App\GameInfo', 'game_id');
    }
}
