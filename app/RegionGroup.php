<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegionGroup extends Model
{
    public function region(){
    	return $this->hasMany('App\Region');
    }
}
