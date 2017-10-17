<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    public function transaction(){
    	return $this->hasMany('App\Transaction');
    }
}
