<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Person;
use App\Student;
use App\Institution;
use App\RegionGroup;
use App\Region;

use DB;

class TesController extends Controller
{
    
  public function tes(){
  
  public function toGregorian($hijri){
  	$d =explode('_', $hijri);  	
  	return $date = \GeniusTS\HijriDate\Hijri::convertToGregorian($d[0], $d[1], $d[2])->format('d-m-Y');
  }

}
