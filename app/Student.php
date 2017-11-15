<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use \Carbon\Carbon;
use Auth;

class Student extends Model
{
    use Sluggable;

    protected $guarded = ['id'];

	public function sluggable(){
        return ['slug' => ['source' => 'fullname']];
    }

    public function scopeFiltered($query){
        return $query->whereNotIn('id', [256] );
    } 

    public function scopeActive($query){
        return $query->where('stop_date', '=', null );
    }

    public function scopeHeaded($query){
        $ui = Auth::user()->institution->pluck('id')->toArray();
        return $query->whereIn('institution_id', $ui);
    }

    public function lastAchievement(){
        return $this->hasOne('App\Achievement')->orderBy('stage_id', 'desc');
    }

    public function achievement(){
        return $this->hasMany('App\Achievement');
    }    

    public function institution(){
    	return $this->belongsTo('App\Institution');
    }

    public function group(){
    	return $this->belongsTo('App\ClassGroup');
    }

    function transaction(){
        return $this->hasMany('App\AlmarufTransaction');
    }

    public function getBirthDateAttribute($date){
        if ($date !=null){
            return Carbon::parse($date);
        } else {
            return $date;
        }
    }

}
