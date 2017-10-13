<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Carbon\Carbon;
use Auth;
use Bouncer;
use App\Person;
use App\Student;
use App\Institution;
use App\RegionGroup;
use App\AlmarufTransaction;
use App\ClassGroup;

use App\Achievement;
use App\Stage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
      
        $institutions = Institution::filtered()->get()->count();
        $students = Student::filtered()->get()->count();
        $teachers = Person::teacherFiltered()->get()->count();
        $nonteachers = Person::nonTeacherFiltered()->get()->count();
        
        return view('admin.index',[
            'institutions'=>$institutions,
            'teachers'=>$teachers,
            'students'=>$students,
            'nonteachers'=>$nonteachers          
        ]);
    }

        public function institutionTeacher(){
      $ins_teachers = Institution::filtered()->with('mainTeacher')->orderBy('name', 'asc')->get();
      $jl=0;$jp=0;$jtot=0;
      foreach ($ins_teachers as $k=>$institution) {
        $data[$k]['institution'] = $institution->name;
        
        $mt = $institution->mainTeacher->where('gender','=','L');
        $data[$k]['male_teacher']['count'] = count($mt);
        foreach($mt as $teacher){
          $data[$k]['male_teacher'][] = $teacher->name;
        }

        $ft = $institution->mainTeacher->where('gender','=','P');
        $data[$k]['female_teacher']['count'] = count($ft);            
        foreach($institution->mainTeacher->where('gender','=','P') as $teacher){
            $data[$k]['female_teacher'][] = $teacher->name;
        }

      }      


      return response()->json([
        'all_male_teacher'=>$jl, 
        'all_female_teacher'=>$jp, 
        'data_teacher'=>$data
      ]);
    }

    public function institutionStudent(){
      $ins_students = Institution::filtered()->with('student')->orderBy('name', 'asc')->get();      
      foreach ($ins_students as $k=>$institution) {
        $data[$k]['institution'] = $institution->name;
        $ta = $institution->student->where('group_id','=', 1)->where('stop_date','=',null); //tpqa
        $td = $institution->student->where('group_id','=', 3)->where('stop_date','=',null); //tpqd
        $na = $institution->student->where('stop_date','!=',null); //nonactive student
        $data[$k]['tpqa_ac_male'] = $ta->where('gender','=','L')->count();
        $data[$k]['tpqa_ac_female'] = $ta->where('gender','=','P')->count();
        $data[$k]['tpqd_ac_male'] = $td->where('gender','=','L')->count();
        $data[$k]['tpqd_ac_female'] = $td->where('gender','=','P')->count();
        $data[$k]['tpqa_na'] = $na->where('group_id','=','1')->count();
        $data[$k]['tpqd_na'] = $na->where('group_id','=','3')->count();
      }
      

      return response()->json([
        'data_student'=>$data
      ]);
    }  

    public function institutionAchievement(){

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
      
      return response()->json([
        'data_achievement'=>$de
      ]);

      // foreach($de as $k=> $val){
      //   echo $val['name']." =  " .count($val['student'])."<br>";
      // }
    }







}
