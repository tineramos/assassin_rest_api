<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public $timestamps = false;

    protected $table = 'games';
    protected $primaryKey = 'game_id';

    protected $fillable = ['game_title', 'game_location', 'game_status', 'max_players'];
    protected $guarded = ['players_joined', 'available_slots', 'winner_user_id', 'open_until', 'date_started', 'date_finished'];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the stats for the user.
     */
    public function players()
    {
        return $this->hasMany('App\Model\Player');
    }

    public function winner()
    {
        return $this->hasOne('App\Model\Profile', 'user_id');
    }

}
