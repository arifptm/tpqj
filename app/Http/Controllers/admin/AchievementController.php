<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
//use \Carbon\Carbon;

use App\Achievement;
use App\Institution;
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

        $md_ins = new Institution;
        $institutions = $md_ins->filtered()->whereHas('student', function($q){$q->whereHas('achievement');})->get();
        $userInstitutions = Institution::whereIn('id',$this->userInstitutions())->get();

        $sts =[];
        if($students->count() > 0){
    	   foreach ($students->get() as $student) {
    		  $sts[$student->id] = $student->fullname.'/'.$student->nickname;
    	   }    
    	}    

    	return view('admin.achievement.index',['stages'=>$stages, 'students'=>$sts, 'institutions'=> $institutions]);
    }

    



    public function achievementStatistic($ins){
        if ($ins == 'all'){
            $ins = Institution::pluck('id')->toArray();
            $ins = implode('_', $ins);
        }

        $ins = explode('_', $ins);

        $achievements = Achievement::activeStudent()->where('is_latest','=', 1)->whereHas('student', function($q) use ($ins) {$q->whereIn('institution_id',$ins); })->with('student','stage')->orderBy('stage_id')->get()->groupBy('stage_id');
        
        return view('admin.achievement.block-statistic', ['achievements'=>$achievements]);
    }



    public function indexData($ins=null, $stg=null){
        if ($ins == 'all'){
            $ins = Institution::pluck('id')->toArray();
            $ins = implode('_', $ins);
        }
        if ($stg == 'all'){
            $stg = Stage::pluck('id')->toArray();
            $stg = implode('_', $stg);
        }

        $ins=explode('_', $ins);
        $stg=explode('_', $stg);

        //dd($ins);
        // if ($param1 == 'all'){
        //     $achievement = Achievement::select('achievements.*')->with('stage', 'student')->whereIs_latest('1')->activeStudent();
        // } else {
            $achievement = Achievement::select('achievements.*')
            ->whereHas('student', function($q) use($ins){ $q->whereIn('institution_id', $ins); })
            ->whereIn('achievements.stage_id', $stg)
            ->with(['student', 'stage'])->whereIs_latest('1')->activeStudent();
            
        // }

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
        $input = $request->only(['student_id','stage_id','notes']);      
        //$achievement_date = explode('-', $request->achievement_date);        
        // $input['achievement_date'] = $achievement_date[2].'-'.$achievement_date[1].'-'.$achievement_date[0];
        $input['achievement_date'] = $request->acda_alt;

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
            
        $input = $request->only(['student_id','stage_id','notes']);   
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
        return response()->json(['message'=>'Data kelulusan berhasil dihapus.']);
    }

}
