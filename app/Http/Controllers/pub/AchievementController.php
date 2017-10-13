<?php

namespace App\Http\Controllers\pub;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AchievementController extends Controller
{
    public function index(){
    	
    }

    public function show($slug){
    	$student = Institution::whereSlug($slug)->first();
    	return view('public.student.show',['student'=>$student]);
    }    
}
