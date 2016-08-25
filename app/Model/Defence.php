<?php

namespace App\Model;

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
         return $this->belongsToMany('App\Model\Player', 'player_defences', 'defence_id', 'player_id')
                     ->withPivot('authorize_usage', 'in_use')
                     ->withTimestamps();
     }
}
