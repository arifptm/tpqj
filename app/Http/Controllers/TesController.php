<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Person;
use App\Student;

use DB;

class TesController extends Controller
{
    
  public function tes(){
    $student = Student::with(['institution', 'achievement'=>function($q){
      $q->orderBy('stage_id','desc')->with('stage');
    }])
    ->get();
   
    foreach ($student as $key => $value) {
      if($value->achievement->first()){
        $de[$value->achievement->first()->stage->id]['id'] = $value->achievement->first()->stage->id;
        $de[$value->achievement->first()->stage->id]['name'] = $value->achievement->first()->stage->name;
        $de[$value->achievement->first()->stage->id]['student'][] = $value->fullname;
      }

    }
    

    foreach($de as $k=> $val){
      echo $val['name']." =  " .count($val['student'])."<br>";
    }
  }

}
