<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class ClassGroup extends Model
{
	use Sluggable;

    protected $guarded = ['id'];
    public $timestamps = false;

	public function sluggable(){
        return ['slug' => ['source' => 'name']];
    }

    public function transaction(){
    	return $this->hasMany('App\AlmarufTransaction','class_group_id');
    }
}
