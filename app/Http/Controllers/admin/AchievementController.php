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
    	$stages = Stage::option()->orderBy('id','asc')->get();
    	$students = Student::active()->whereIn('institution_id', $this->userInstitutions())->orderBy('fullname', 'asc'); //for option when add/edit

        $md_ins = new Institution;
        $institutions = $md_ins->filtered()->whereHas('student', function($q){$q->whereHas('achievement');})->get();
        $userInstitutions = Institution::whereIn('id',$this->userInstitutions())->pluck('id')->toArray();

        $sts =[];
        if($students->count() > 0){
    	   foreach ($students->get() as $student) {
    		  $sts[$student->id] = $student->fullname.'/'.$student->nickname;
    	   }    
    	}    

    	return view('admin.achievement.index',['stages'=>$stages, 'students'=>$sts, 'institutions'=> $institutions, 'ui'=> $userInstitutions]);
    }



    public function achievementStatistic($ins){

        if ($ins == 'default'){
            $ins = implode('_', $this->userInstitutions());
        }

        $ins = explode('_', $ins);
        
        $n_achievements = new Achievement;
        $tpqa_a = $n_achievements->activeStudent()
        ->where('is_latest','=', 1)        
        ->with('student','stage')
        ->orderBy('stage_id')
        ->whereHas('student', function($q) use ($ins) { $q->whereIn('institution_id',$ins); })
        ->whereHas('student', function($q) { $q->where('group_id',1); })
        ->get()
        ->groupBy('stage_id');
         
        $tpqd_a = $n_achievements->activeStudent()
        ->where('is_latest','=', 1)        
        ->with('student','stage')
        ->orderBy('stage_id')
        ->whereHas('student', function($q) use ($ins) { $q->whereIn('institution_id',$ins); })
        ->whereHas('student', function($q) { $q->where('group_id',3); })
        ->get()
        ->groupBy('stage_id');  

        


        $stages = Stage::orderBy('weight', 'asc')->get();
        
        foreach($stages as $k=>$stage){
            $key = $stage->id;                
            $achievement[$k]['stage_id'] = $key;
            
            if($k > 0){
                $achievement[$k-1]['stage'] = $stage->name;                
            }

            if($k > 20){
                $achievement[$k]['stage'] = '';
            }
            
            if(isset($tpqa_a[$key])){
                $achievement[$k]['tpqa'] = $tpqa_a[$key]->count();
            } else {
                $achievement[$k]['tpqa'] = 0;
            }

            if(isset($tpqd_a[$key])){
                $achievement[$k]['tpqd'] = $tpqd_a[$key]->count();
            } else {
                $achievement[$k]['tpqd'] = 0;
            } 
        
        }

         // dd($achievement); 

        //$achievements = Achievement::activeStudent()->where('is_latest','=', 1)->whereHas('student', function($q) {$q->headed(); })->with('student','stage')->orderBy('stage_id')->get()->groupBy('stage_id');
        
        return view('admin.achievement.block-statistic', ['achievements'=>$achievement, 'ins'=> implode('_',$ins) ]);
    }


    public function indexData($ins, $stg, $group){
        if ($ins == 'default'){
            $ins = implode('_', $this->userInstitutions());
        }
        
        if ($stg == 'all'){
            $stg = Stage::pluck('id')->toArray();
            $stg = implode('_', $stg);
        }

        if ($group == 'group'){
            $group = "1_3";
        }

        $group = explode('_', $group);
        $ins=explode('_', $ins);
        $stg=explode('_', $stg);

        //dd($ins);
        // if ($param1 == 'all'){
        //     $achievement = Achievement::select('achievements.*')->with('stage', 'student')->whereIs_latest('1')->activeStudent();
        // } else {
            $achievement = Achievement::select('achievements.*')
            ->whereHas('student', function($q) use ($group){ $q->whereIn('group_id', $group); })
            ->whereHas('student', function($q) use($ins){ $q->whereIn('institution_id', $ins); })
            ->whereIn('achievements.stage_id', $stg)
            ->with(['student','student.institution', 'stage'])->whereIs_latest('1')->activeStudent();
            
        // }

        $datatable = Datatables::of($achievement)
            ->addColumn('fname', function($achievement){      
                $name = $achievement->student->fullname;
                $nname = $achievement->student->nickname;
                $slug = $achievement->student->slug;
                $tpqd = $notes = '';
                if($achievement->student->group_id == 3){
                    $tpqd = "<i data-toggle='tooltip' title='Santri Dewasa' class='fa fa-user text-green'></i>";
                }
                if($achievement->notes != ''){
                    $notes = "<i data-toggle='tooltip' title='$achievement->notes' class='fa fa-info-circle text-warning'></i>";
                }
                return "<a href='/admin/students/$slug'><b>".str_limit($name,15,'~')."</b></a>/$nname ".$tpqd." ".$notes;
            })

            ->addColumn('fdate', function($achievement){                
                return $achievement->achievement_date->format('d-m-Y');
            })

            // ->addColumn('current_stage', function($achievement){
            //     $s = new Stage;
            //     $passed_stage = $s->where('id',$achievement->stage_id)->first();
            //     $current = $s->where('weight','>', $passed_stage->weight)->first();
            //     return $current->name;
            // })

 


            ->addColumn('actions', function($achievement){                
                $odate = $achievement->achievement_date->format('d-m-Y');
                $new_student = ($achievement->stage_id == 22 AND $achievement->is_latest == 1 ) ? 'disabled' : '';
                return "                
                <div class='btn-group'>
                    <button id='btn-modal-edit' class='btn btn-default btn-xs'  " . $new_student . " 
                        data-id = '$achievement->id' 
                        data-student_id = '$achievement->student_id' 
                        data-stage_id = '$achievement->stage_id' 
                        data-achievement_date = '$odate'                         
                        data-notes='$achievement->notes'>
                        <i class='glyphicon glyphicon-edit'></i>
                    </button>
                    <button id='btn-delete-achievement' " . $new_student . " class='btn btn-danger btn-xs' data-id='$achievement->id'>
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
        $input['achievement_date'] = $request->acda_alt;

        $stage_weight_request = Stage::where('id', $request->stage_id)->first();

        $stage_weight_latest_in_db = DB::table('achievements')
        ->join('stages', 'achievements.stage_id' ,'=', 'stages.id')
        ->where('achievements.student_id', $request->student_id)
        ->select('achievements.id', 'stages.weight')
        ->orderBy('stages.weight', 'desc')
        ->first();

        if ($stage_weight_latest_in_db == null){
            $input['is_latest'] = 1;
        } else {
            if ( $stage_weight_request->weight  > $stage_weight_latest_in_db->weight ){
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
        
        Achievement::where('student_id', '=', $request->student_id)->update(['is_latest'=>0]);

        $latest_stage_id = DB::table('achievements')
        ->join('stages', 'achievements.stage_id', '=', 'stages.id')
        ->select('achievements.id')
        ->where('achievements.student_id', $request->student_id)
        ->orderBy('stages.weight','desc')
        ->take(1)
        ->get()
        ->first()
        ->id;

        Achievement::where('id', $latest_stage_id)->update(['is_latest'=>1]);

        return response()->json(['achievement' => $achievement->load('student','stage')]);
    }    

	public function ajaxDelete(Request $request){
        $achievement = Achievement::findOrFail($request->id);
        $achievement->delete();
        return response()->json(['message'=>'Data kelulusan berhasil dihapus.']);
    }

}
