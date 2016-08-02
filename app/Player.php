<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = ['eliminated_by_user', 'total_number_kills', 'is_eliminated'];

    protected $table = 'players';
    protected $primaryKey = 'player_id';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
     protected $hidden = [
         'user_id',
     ];

    /**
     * Get the profile of the player
     *
     **/
     public function user_profile()
     {
         return $this->belongsTo('App\Profile');
     }

     /**
      * Get the game_info of the of specific game
      *
      **/
      public function game_info()
      {
          return $this->belongsTo('App\GameInfo');
      }
}
