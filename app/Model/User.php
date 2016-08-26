<?php

namespace App\Model;

// use Hash;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'code_name', 'course', 'age', 'height', 'gender', 'profile_photo', 'password', 'device_token'
    ];

    protected $guarded = ['user_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
     protected $hidden = [
         'password', 'device_token', 'profile_photo'
     ];

    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = \Hash::make($value);
    // }

    // define relationship
    // first argument passed to the hasOne method is the name of the related model
    public function user_profile() {
        return $this->hasOne('App\Model\Profile');
    }
}