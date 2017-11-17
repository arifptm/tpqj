<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    public function achievement(){
    	return $this->hasMany('App\Achievement');
    }

    public function scopeOption($q){
    	$q->whereNotIn('id', [20,22]); // finishing & pasca tpq not included
    }

    public function scopeCurrent($q){
    	$q->whereNotIn('id', [21]); // finishing & pasca tpq not included
    }
}
