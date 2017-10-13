<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Achievement;
use App\Stage;
use App\Student;

use Auth;


class AchievementController extends Controller
{
    public function userInstitutions(){
        $ui = Auth::user()->institution->pluck('id')->toArray();
        return $ui;
    }

    public function index(){

    	$achievements = Achievement::with('student','stage')->orderBy('id','desc')->paginate(20);
    	$stages = Stage::orderBy('id','asc')->get();
    	$students = Student::whereIn('institution_id', $this->userInstitutions())->get();

        $sts =[];
        if($students->count() > 0){
    	   foreach ($students as $student) {
    		  $sts[$student->id] = $student->fullname.'/'.$student->nickname;
    	   }    
    	}

    	//$students = Student::whereInstitution_id(9)->orderBy('fullname','asc')->pluck('nickname', 'fullname' ,'id')->toArray();
    	return view('admin.achievement.index',['achievements'=>$achievements,'stages'=>$stages, 'students'=>$sts]);
    }

    public function ajaxCreate(Request $request){    
        $input = $request->all();        
        $achievement_date = explode('-', $request->achievement_date);        
        $input['achievement_date'] = $achievement_date[2].'-'.$achievement_date[1].'-'.$achievement_date[0];
        $achievement = Achievement::create($input);
        return response()->json(['fullname' => $achievement->student->fullname]);
    }

    public function ajaxUpdate(Request $request){    
        $input = $request->all();        
        $achievement_date = explode('-', $request->achievement_date);        
        $input['achievement_date'] = $achievement_date[2].'-'.$achievement_date[1].'-'.$achievement_date[0];
        
        $achievement = Achievement::findOrFail($request->id);
        $achievement->update($input);
        return response()->json(['fullname' => $achievement->student->fullname]);
    }    

	public function ajaxDelete(Request $request){
        $achievement = Achievement::findOrFail($request->id);
        $achievement->delete();
        return response()->json(['message'=>'Data transaksi berhasil dihapus.']);
    }

}
