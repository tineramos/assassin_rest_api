<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['games_won', 'total_games'];

    protected $table = 'profile';
    protected $primaryKey = 'user_id';

    public $timestamps = false;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
     protected $hidden = [];

    /**
     * Get the user of the profile
     *
     */
     public function user()
     {
         return $this->belongsTo('App\User');
     }

    /**
     * Get the stats for the user.
     *
     */
     public function stats()
     {
         return $this->hasMany('App\Player');
     }

}
