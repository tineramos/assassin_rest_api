<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Defence extends Model
{
    public $timestamps = false;

    protected $table = 'defences';
    protected $primaryKey = 'defence_id';

    protected $fillable = ['defence_name'];

    /**
     * Get the players using the defence
     *
     **/
     public function players()
     {
         return $this->belongsToMany('App\Player', 'player_defences', 'defence_id', 'player_id');
     }
}
