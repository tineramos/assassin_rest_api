<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public $timestamps = false;

    protected $fillable = ['games_won_count', 'total_games_count'];

    protected $guarded = ['user_id', 'average_kill_per_game'];

    protected $table = 'profile';
    protected $primaryKey = 'user_id';

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
    //
    // /**
    //  * Get the stats for the user.
    //  *
    //  */
    //  public function games()
    //  {
    //      return $this->hasMany('App\Games');
    //  }

    /**
     * Get the stats for the user.
     *
     */
     public function stats()
     {
         return $this->hasMany('App\Player');
     }

}
