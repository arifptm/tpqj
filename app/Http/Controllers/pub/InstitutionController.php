<?php

namespace App\Http\Controllers\pub;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Redis;

use App\Institution;

class InstitutionController extends Controller
{
    public function index(){    	

    	$institutions = Redis::get('institutions');
    	
    	if ($institutions == null) {    		
    		$institutions = Institution::filtered()->with('region','theheadmaster')->orderBy('name','asc')->get();
    		Redis::set('institutions', serialize($institutions));
    	} else {
    		$institutions = unserialize($institutions);
    	}    	
    	
    	return view('public.institution.index',['institutions'=>$institutions]);
    }

    public function show($slug){
    	$institution = Institution::whereSlug($slug)->first();
    	return view('public.institution.show',['institution'=>$institution]);
    }
}
