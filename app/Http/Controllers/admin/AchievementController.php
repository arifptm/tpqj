<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
//use \Carbon\Carbon;

use App\Achievement;
use App\Stage;
use App\Student;
use App\Http\Requests\CreateAchievement;
use App\Http\Requests\EditAchievement;

use Auth;

use DB;


class AchievementController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function userInstitutions(){
        $ui = Auth::user()->institution->pluck('id')->toArray();
        return $ui;
    }
    
    public function index(){
    	$stages = Stage::orderBy('id','asc')->get();
    	$students = Student::active()->whereIn('institution_id', $this->userInstitutions());

        $sts =[];
        if($students->count() > 0){
    	   foreach ($students->get() as $student) {
    		  $sts[$student->id] = $student->fullname.'/'.$student->nickname;
    	   }    
    	}    

         //    $ss = Achievement::where('student_id',254)->orderBy('stage_id','desc')->get();
         //    $l = $ss->first()->stage_id;
         //    $ss->shift();


         // dd($ss);

    	return view('admin.achievement.index',['stages'=>$stages, 'students'=>$sts]);
    }

    public function achievementStatistic(){
        $achievements = Achievement::activeStudent()->where('is_latest','=', 1)->with('student','stage')->orderBy('stage_id')->get()->groupBy('stage_id');

        
        return view('admin.achievement.block-statistic', ['achievements'=>$achievements]);
    }


    public function indexData($arg){
        if ($arg == 'all'){
            $achievement = Achievement::select('achievements.*')->with('stage', 'student')->whereIs_latest('1')->activeStudent();
        } else {
            $achievement = Achievement::select('achievements.*')->where('achievements.stage_id','=', $arg)->with(['student', 'stage'])->whereIs_latest('1')->activeStudent();
        }

        $datatable = Datatables::of($achievement)
            ->addColumn('fname', function($achievement){      
                $name = $achievement->student->fullname;
                $nname = $achievement->student->nickname;
                $slug = $achievement->student->slug;
                return "<a href='/admin/students/$slug'><b>".str_limit($name,15,'~')."</b></a>/$nname";
            })

            ->addColumn('fdate', function($achievement){                
                return $achievement->achievement_date->format('d-m-Y');
            })

            ->addColumn('actions', function($achievement){                
                $odate = $achievement->achievement_date->format('d-m-Y');
                return "                
                <div class='btn-group'>
                    <button id='btn-modal-edit' class='btn btn-default btn-xs'
                        data-id = '$achievement->id' 
                        data-student_id = '$achievement->student_id' 
                        data-stage_id = '$achievement->stage_id' 
                        data-achievement_date = '$odate'                         
                        data-notes='$achievement->notes'>
                        <i class='glyphicon glyphicon-edit'></i>
                    </button>
                    <button id='btn-delete-achievement' class='btn btn-danger btn-xs' data-id='$achievement->id'>
                        <i class='glyphicon glyphicon-trash'></i>
                    </button>
                </div>
                ";
            })

            ->rawColumns(['actions', 'fstage', 'fname', 'fdate']);
        return $datatable->make(true); 
    }











    public function ajaxCreate(CreateAchievement $request){    
        $input = $request->all();        
        $achievement_date = explode('-', $request->achievement_date);        
        $input['achievement_date'] = $achievement_date[2].'-'.$achievement_date[1].'-'.$achievement_date[0];
        
        //$processed_student = Achievement::where('student_id', '=', $request->student_id);
        $latest_stage = Achievement::where('student_id', '=', $request->student_id)->orderBy('stage_id','desc')->first();
        if ($latest_stage == null){            
            $input['is_latest'] = 1;
        } else {
            if ( $request->stage_id  > $latest_stage->stage_id ){
                Achievement::where('student_id', '=', $request->student_id)->update(['is_latest'=>  0 ]);      
                $input['is_latest'] = 1;            
            }  else {
                $input['is_latest'] = 0;
            }
        }

        $achievement = Achievement::create($input);
                        
        return response()->json(['achievement' => $achievement->load('student', 'stage')]);
    }




    public function ajaxUpdate(EditAchievement $request){    
        $achievement = Achievement::findOrFail($request->id);    
            
        $input = $request->all();      
        $achievement_date = explode('-', $request->achievement_date);        
        $input['achievement_date'] = $achievement_date[2].'-'.$achievement_date[1].'-'.$achievement_date[0];
        $input['is_latest'] = 0;        
        
        $achievement->update($input);
        
        $chosen = Achievement::where('student_id', '=', $request->student_id);
        $reset = $chosen->update(['is_latest'=>0]);

        $latest_stage_id = $chosen->orderBy('stage_id', 'desc')->first()->stage_id;

        $chosen->where('stage_id', $latest_stage_id)->update(['is_latest'=>1]);

        return response()->json(['achievement' => $achievement->load('student','stage')]);
    }    

	public function ajaxDelete(Request $request){
        $achievement = Achievement::findOrFail($request->id);
        $achievement->delete();
        return response()->json(['message'=>'Data transaksi berhasil dihapus.']);
    }

}
