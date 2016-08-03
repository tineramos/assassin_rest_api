<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'game_id'];

    protected $guarded = ['eliminated_by_user', 'total_number_kills', 'is_eliminated'];

    protected $table = 'players';
    protected $primaryKey = 'player_id';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
     protected $appends = ['player_code_name'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
     protected $hidden = [
         'user_id', 'game_id', 'profile'
     ];

     /**
      * Accessor of player_code_name
      *
      * @return string
      **/
      public function getPlayerCodeNameAttribute()
      {
          return $this->profile->user->code_name;
      }

     /**
      * Get user_profile of player
      *
      **/
      public function profile()
      {
          return $this->belongsTo('App\Profile', 'user_id');
      }

       /**
        * Get the game_info of the of specific game
        *
        **/
        public function gameplay()
        {
            return $this->belongsTo('App\GameInfo', 'game_id');
        }

       /**
        * Get all weapons
        *
        **/
       public function weapons()
       {
           return $this->hasMany('App\Weapon', 'player_weapons', 'player_id', 'weapon_id');
       }

       /**
        * Get all defences
        *
        **/
       public function defences()
       {
           return $this->hasMany('App\Defence', 'player_defences', 'player_id', 'defence_id');
       }
}
