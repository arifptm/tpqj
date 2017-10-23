<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    public function almarufTransaction(){
    	return $this->hasMany('App\AlmarufTransaction');
    }
}
