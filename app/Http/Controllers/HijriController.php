<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HijriController extends Controller
{
    public function toGregorian($hijri){
  		$d =explode(',', $hijri);  	
  	return $date = \GeniusTS\HijriDate\Hijri::convertToGregorian($d[0], $d[1], $d[2])->format('d-m-Y');
  }
}
