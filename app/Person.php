<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Person extends Model
{
	use Sluggable;

    protected $guarded = ['id'];
    protected $table = 'persons';

	public function sluggable(){
        return ['slug' => ['source' => 'name']];
    }

    public function mainInstitution(){
    	return $this->belongsToMany('App\Institution','institution_teachers','person_id','institution_id')->wherePivot('section','main');
    }

	public function extraInstitution(){
    	return $this->belongsToMany('App\Institution','institution_teachers','person_id','institution_id')->wherePivot('section','extra');
    }

    public function scopeTeacherFiltered($query){
        return $query->whereNotIn('id', [2116,2163,2115,2150] ); 
    }

    public function scopeNonTeacherFiltered($query){
        return $query->whereIn('id', [2116,2163,2115,2150] ); 
    }

}
