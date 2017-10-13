<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Institution extends Model
{
	use Sluggable;

    protected $guarded = ['id'];
    public $timestamps = false;

    public function scopeFiltered($query){
        return $query->whereNotIn('id', [7,8,13,14] );
    }

    public function sluggable(){
        return ['slug' => ['source' => 'name']];
    }

    public function theheadmaster(){
    	return $this->belongsTo('App\Person','headmaster');
    }

    public function mainTeacher(){
        return $this->belongsToMany('App\Person','institution_teachers','institution_id','person_id')->wherePivot('section','main');
    }

    public function extraTeacher(){
        return $this->belongsToMany('App\Person','institution_teachers','institution_id','person_id')->wherePivot('section','extra');
    }

    public function user(){
        return $this->belongsToMany('App\User','user_institutions');
    }

    public function region(){
    	return $this->belongsTo('App\Region');
    }

    public function student(){
        return $this->hasMany('App\Student');
    }    

    public function person(){
        return $this->hasOne('App\Person');
    }

}
