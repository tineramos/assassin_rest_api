<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameInfo extends Model
{
    protected $fillable = ['winner', 'date_started', 'date_finished'];

    protected $table = 'game_info';
    protected $primaryKey = 'game_id';

    /**
     * Get the game of the game_info
     *
     **/
     public function user()
     {
         return $this->belongsTo('App\Game');
     }

     /**
      * Get the stats for the user.
      */
      public function players()
      {
          return $this->hasMany('App\Player');
      }
}
