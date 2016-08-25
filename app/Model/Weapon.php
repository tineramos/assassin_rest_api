<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    protected $table = 'weapons';
    protected $primaryKey = 'weapon_id';

    protected $fillable = ['weapon_name'];

    public $timestamps = false;

    /**
     * Get the players using the weapon
     *
     **/
     public function players()
     {
         return $this->belongsToMany('App\Model\Player', 'player_weapons', 'weapon_id', 'player_id')
                     ->withPivot('shots_left', 'in_use')
                     ->withTimestamps();
     }
}
