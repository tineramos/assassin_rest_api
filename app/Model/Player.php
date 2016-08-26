<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $table = 'players';
    protected $primaryKey = 'player_id';

   /**
    * The accessors to append to the model's array form.
    *
    * @var array
    */
    protected $appends = ['player_code_name'];

    protected $fillable = ['eliminated_by_player', 'is_eliminated'];

    protected $guarded = ['user_id', 'game_id', 'kills_count'];

   /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
    protected $hidden = [
        'user_id', 'game_id', 'assassin_id', 'target_id', 'health_points', 'profile', 'created_at', 'updated_at'
    ];

   /**
    * Accessor of player_code_name
    *
    * @return string
    */
    public function getPlayerCodeNameAttribute()
    {
        return $this->profile->user->code_name;
    }

    /*
        Get device token
    */
    public function getPlayerDeviceTokenAttribute()
    {
        return $this->profile->user->device_token;
    }

    public function targetDetails()
    {
        $user = $this->profile->user;
        return ['target_id' => $this->player_id,
                'code_name' => $user->code_name,
                'course' => $user->course,
                'gender' => $user->gender,
                'age' => $user->age,
                'height' => $user->height];
    }

    /**
    * Get user_profile of player
    *
    */
    public function profile()
    {
        return $this->belongsTo('App\Model\Profile', 'user_id');
    }

   /**
    * Get the game_info of the of specific game
    *
    */
    public function gameplay()
    {
        return $this->belongsTo('App\Model\Game', 'game_id');
    }

   /**
    * Get target of player
    *
    */
    public function target()
    {
        return $this->hasOne('App\Model\Player', 'target');
    }

   /**
    * Get assassin of player
    *
    */
    public function assassin()
    {
        return $this->belongsTo('App\Model\Player', 'player_id');
    }

   /**
    * Get all kills of the player
    *
    **/
    public function kills()
    {
        return $this->hasMany('App\Model\Player', 'player_id');
    }

   /**
    * Get all weapons
    *
    **/
    public function weapons()
    {
        return $this->hasMany('App\Model\Weapon', 'player_weapons', 'player_id', 'weapon_id');
    }

   /**
    * Get all defences
    *
    **/
    public function defences()
    {
        return $this->hasMany('App\Model\Defence', 'player_defences', 'player_id', 'defence_id');
    }
}
