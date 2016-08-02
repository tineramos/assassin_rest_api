<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    protected $table = 'weapons';
    protected $primaryKey = 'weapon_id';

    protected $fillable = ['weapon_name'];

    // define relationship
    // first argument passed to the hasOne method is the name of the related model
    // public function game_details() {
    //     return $this->hasOne('App\GameInfo');
    // }

    /**
     * Get the players using the weapon
     *
     **/
     public function players()
     {
         return $this->belongsToMany('App\Players');
     }
}
