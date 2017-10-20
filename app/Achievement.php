<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;
use App\Student;


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

    public function scopeActiveStudent($query){
        $active_student_ids = Student::where('stop_date', null)->pluck('id');
        return $query->whereIn('student_id', $active_student_ids );
    }
}



