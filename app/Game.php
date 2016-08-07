<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public $timestamps = false;

    protected $table = 'games';
    protected $primaryKey = 'game_id';

    protected $fillable = ['game_title', 'game_status', 'max_players', 'open_until'];
    protected $guarded = ['players_joined', 'available_slots', 'winner', 'date_started', 'date_finished'];

    /**
     * Get the stats for the user.
     */
    public function players()
    {
        return $this->hasMany('App\Player');
    }
}
