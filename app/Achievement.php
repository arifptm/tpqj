<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;

class Achievement extends Model
{
    protected $guarded = ['id'];
    
    public function getAchievementDateAttribute($date){
        if ($date !=null){
            return Carbon::parse($date);
        } else {
            return $date;
        }
    }

    public function student(){
    	return $this->belongsTo('App\Student');
    }

    public function stage(){
    	return $this->belongsTo('App\Stage');
    }    
}
