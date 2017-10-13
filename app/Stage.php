<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    public function achievement(){
    	return $this->hasMany('App\Achievement');
    }
}
