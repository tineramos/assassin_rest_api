<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Defence extends Model
{
    protected $table = 'defences';
    protected $primaryKey = 'defence_id';

    protected $fillable = ['defence_name'];

    // define relationship
    // first argument passed to the hasOne method is the name of the related model
    // public function game_details() {
    //     return $this->hasOne('App\GameInfo');
    // }

    /**
     * Get the players using the defence
     *
     **/
     public function players()
     {
         return $this->belongsToMany('App\Players');
     }
}
