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
        // return $this->hasMany('App\Model\Weapon', 'player_weapons', 'player_id', 'weapon_id');
        return $this->belongsToMany('App\Model\Weapon', 'player_weapons')
                    ->withPivot('shots_left', 'in_use');
    }

    public function formattedWeapons()
    {
        $format = array();
        $weapon_list = $this->weapons;

        foreach ($weapon_list as $weapon) {
            $shots_left = $weapon->pivot->shots_left;
            $in_use = $weapon->pivot->in_use;

            $sample = ['weapon_id' => $weapon->weapon_id,
                       'weapon_name' => $weapon->weapon_name,
                       'shots_left' => $shots_left,
                       'in_use' => $in_use];

            array_push($format, $sample);
        }

        return $format;

    }

   /**
    * Get all defences
    *
    **/
    public function defences()
    {
        // return $this->hasMany('App\Model\Defence', 'player_defences', 'player_id', 'defence_id');
        return $this->belongsToMany('App\Model\Defence', 'player_defences')
                    ->withPivot('quantity', 'in_use');
    }

    public function formattedDefences()
    {
        $format = array();
        $defence_list = $this->defences;

        foreach ($defence_list as $defence) {
            $quantity = $defence->pivot->quantity;
            $in_use = $defence->pivot->in_use;
            // $format.append($in_use);
            $sample = ['defence_id' => $defence->defence_id,
                       'defence_name' => $defence->defence_name,
                       'quantity' => $quantity,
                       'in_use' => $in_use];

            array_push($format, $sample);
        }

        return $format;

    }

}
