<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Region extends Model
{
    use Sluggable;

    protected $guarded = ['id'];

	public function sluggable(){
        return ['slug' => ['source' => 'name']];
    }

    public function regionGroup(){
    	return $this->belongsTo('App\RegionGroup');
    }

    public function institution(){
    	return $this->hasMany('App\Institution');
    }

}
