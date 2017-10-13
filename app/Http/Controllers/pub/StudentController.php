<?php

namespace App\Http\Controllers\pub;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//use Illuminate\Support\Facades\Redis;
use Yajra\DataTables\Facades\DataTables;

use App\Student;
use App\Institution;
use App\Achievement;

class StudentController extends Controller
{
    public function index(){
    	$students = Student::filtered()->with('institution', 'achievement','achievement.stage')->orderBy('fullname','asc')->paginate(20);
    	return view('public.student.index',['students'=>$students]);    	

    }


    public function show($slug){    	

        $student = Student::with(['group', 'transaction'=>function($q){
            $q->with('transactionType')->paginate(10);
        }])->whereSlug($slug)->first();        

        $achievements = Achievement::with('stage')->whereStudent_id($student->id)->orderBy('stage_id','asc')->get();
        if ($achievements->count() > 0 ) {
            $dur = $achievements[0]->achievement_date;

            $a_dur = $achievements->each(function($item,$key) use(&$dur){
                if($key == 0){
                    $item->setAttribute('duration','...');
                } else {
                    $item->setAttribute('duration', $item->achievement_date->diff($dur)->format('%m bln %d hr'));
                }
                $dur = $item->achievement_date;
            });        
        } else {
            $a_dur = [''];
        }
        //dd($student);        
        
        return view('public.student.show',['student'=>$student, 'achievements' => $achievements ]);
    }

	public function dataIndex(){
		$student = Student::with(['achievement'=>function($q){
			 $q->orderBy('stage_id','desc')->with('stage');
		}, 'institution'])->select('students.*');
        
        $datatable = Datatables::of($student)
            ->addColumn('name_href', function ($student) {
                return '<a href="/students/'.$student->slug.'"><strong>'.$student->fullname.'</strong></a>';                    
            })

            ->rawColumns(['name_href']);
        	
        	return $datatable->make(true);
	}    

}
