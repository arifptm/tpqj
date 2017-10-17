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
    

    $institution = Institution::find(26);
    //dd($institution);
    return response()->json(['institution' => $institution->with(['region','region.regionGroup','theheadmaster'])->first()]);
    }
  

}
