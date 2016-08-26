<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    public $timestamps = false;

    protected $table = 'weapons';
    protected $primaryKey = 'weapon_id';

    protected $fillable = ['weapon_name'];

    protected $hidden = ['pivot'];

    /**
     * Get the players using the weapon
     *
     **/

     // SPECIAL NOTE: The third argument is the foreign key name of the model on which you are defining the relationship
     // the fourth argument is the foreign key name of the model that you are joining to
     public function players()
     {
         return $this->belongsToMany('App\Model\Player', 'player_weapons', 'weapon_id', 'player_id')
                     ->withPivot('shots_left', 'in_use')
                     ->withTimestamps();
     }
}
