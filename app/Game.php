<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public $timestamps = false;

    protected $table = 'games';
    protected $primaryKey = 'game_id';

    protected $fillable = ['game_title', 'game_status', 'max_players', 'open_until'];

    protected $guarded = ['players_joined', 'available_slots'];

    // define relationship
    // first argument passed to the hasOne method is the name of the related model
    public function game_details() {
        return $this->hasOne('App\GameInfo', 'game_id');
    }
}
