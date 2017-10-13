<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlmarufTransaction extends Model
{
	protected $guarded = ['id'];

	public function student(){
		return $this->belongsTo('App\Student');
	}

	public function transactionType(){
		return $this->belongsTo('App\TransactionType');
	}

	public function studentGroup(){
		return $this->belongsTo('App\ClassGroup','class_group_id');
	}

}
