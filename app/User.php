<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable
{
    use Notifiable;
    use HasRolesAndAbilities;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userProfile()
    {
        return $this->hasOne('App\UserProfile');
    }

    public function institution(){
        return $this->belongsToMany('App\Institution','user_institutions');
    }    

    public function scopeFiltered($query){
        return $query->whereNotIn('id',[10]);
    }

}
