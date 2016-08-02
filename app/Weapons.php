<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weapons extends Model
{
    protected $table = 'weapons';
    protected $primaryKey = 'weapon_id';

    protected $fillable = ['weapon_name'];

    // define relationship
    // first argument passed to the hasOne method is the name of the related model
    // public function game_details() {
    //     return $this->hasOne('App\GameInfo');
    // }
}
