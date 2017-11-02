<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\CreateStudent;
use Validator;
use \Carbon\Carbon;

use App\Student;
use App\Stage;
use App\Institution;
use App\ClassGroup;
use App\AlmarufTransaction;
use App\TransactionType;

use App\Achievement;


use Auth;


class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function userInstitutions(){
        $ui = Auth::user()->institution->pluck('id')->toArray();
        return $ui;
    }

    public function index(){        

        $groups = ClassGroup::all();

        $md_ins = new Institution;
        $institutions = $md_ins->whereIn('id',$this->userInstitutions())->orderBy('name','asc')->pluck('name','id')->toArray(); //for modal input
        $institutions_filter = $md_ins->filtered()->whereHas('student', function($q){$q->whereHas('achievement');})->get();

        $userInstitutions = Institution::whereIn('id',$this->userInstitutions())->get();


        return view('admin.student.index',['groups'=>$groups, 'institutions'=> $institutions, 'institutions_filter'=>$institutions_filter]);

    }

    public function studentStatistic(){
        $students = Student::filtered()->active()->with('institution')->get()->groupBy('institution_id');

        //dd($students);

        return view('admin.student.block-statistic', ['students'=>$students]);

    }


    public function ajaxCreate(CreateStudent $request){        
        $input = $request->all();
        if ($request->image != ''){
            $input['image'] = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move('assets/students/', $input['image']);
        }

        $student = Student::create($input);
        return response()->json(['fullname' => $student->fullname]);
    }

    public function ajaxUpdate(CreateStudent $request){        
        $input = $request->all();
        
        if ($request->image != ''){
            $input['image'] = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move('assets/students/', $input['image']);
        } 

        $student = Student::findOrFail($request->id);
        $student->update($input);
        return response()->json(['fullname' => $student->fullname]);
    }

    public function ajaxDelete(Request $request)
    {
        $student = Student::findOrFail($request->id);
        $student->delete();
        return response()->json(['message'=>'Data santri berhasil dihapus.']);
    }




    public function show($slug)
    {
        $t_types = TransactionType::orderBy('id','asc')->get();

        $class_groups = ClassGroup::all();

        $stages = Stage::orderBy('id','asc')->get(); // For edit achievement        
        $students = Student::active()->whereInstitution_id(9)->orderBy('fullname','asc')->get();        
        foreach($students as $student){
            $option_stu[$student->id] = str_limit($student->fullname,17,'~')."/".$student->nickname;
        }
        $student = Student::whereSlug($slug)->first();
        return view('admin.student.show',['student'=>$student, 'students'=>$option_stu,  'stages'=>$stages, 't_types' => $t_types, 'class_groups' => $class_groups ]);
    }

    public function student($id){
        $student = Student::find($id);        
        return view('admin.student.block-student', ['student' => $student]);  
    }

    public function studentTransactions($id){
        $tr = AlmarufTransaction::whereStudent_id($id)->with('transactionType')->orderBy('transaction_date', 'desc');
        

        
        $total = $tr->sum('amount');
        $transactions = $tr->paginate(10);        
        return view('admin.student.block-transactions', ['transactions' => $transactions, 'total'=>$total]);  
    }

    public function studentAchievements($id){
        $registered = Carbon::parse(Student::find($id)->registered_date);
        
        $achievements = Achievement::whereStudent_id($id)->with('stage')->orderBy('stage_id','asc')->get();
        if ($achievements->count() > 0 ) {
            $dur = $achievements[0]->achievement_date;

            $a_dur = $achievements->each(function($item,$key) use(&$dur, $registered){
                if($key == 0){
                    $item->setAttribute('duration', $item->achievement_date->diff($registered)->format('%m bl + %d hr'));
                } else {
                    $item->setAttribute('duration', $item->achievement_date->diff($dur)->format('%m bl + %d hr'));
                }
                $dur = $item->achievement_date;
            });        
        } else {
            $a_dur = [''];
        }
        
         return view('admin.student.block-achievements',['achievements'=>$achievements]);
    }


    public function dataIndex($ins){

        $ui = $this->userInstitutions();
        
        if ($ins == 'all'){
            $ins = Institution::pluck('id')->toArray();
            $ins = implode('_', $ins);
        }

        $ins=explode('_', $ins);

        $student = Student::where('group_id','!=','5')->whereIn('institution_id', $ins)->with(['institution', 'group']);

        $datatable = Datatables::of($student)
            ->addColumn('name_href', function ($student) {
                return '<a href="/admin/students/'.$student->slug.'"><strong>'.str_limit($student->fullname,17,'~').'</strong></a>/'.$student->nickname;                    
            })      

            ->addColumn('formatted_registered_date', function($student){
                return \Carbon\Carbon::parse($student->registered_date)->format('d-m-y');
            })

            ->addColumn('status', function($student){
                if($student->stop_date != null ){
                    return '<span class="badge bg-orange">Non Aktif</span>';
                } elseif($student->status == 0){
                    return '<span class="badge bg-blue">Aktif</span>';                    
                }
            })

            ->addColumn('gender_x', function($student){
                if($student->gender == 'L' ){
                    return '<span class="badge bg-blue">Laki-laki</span>';
                } elseif($student->gender == 'P'){
                    return '<span class="badge bg-orange">Perempuan</span>';
                }
            })

            ->addColumn('actions', function($student) use($ui){
                $sgs = $student->group->slug;

                if(in_array($student->institution_id, $ui)){
                    return "                
                    <div class='btn-group'>
                        <button id='btn-modal-edit' class='btn btn-default btn-xs'
                            data-id = '$student->id' 
                            data-registered_date = '$student->registered_date' 
                            data-birth_date = '$student->birth_date' 
                            data-birth_place = '$student->birth_place' 
                            data-registration_number='$student->registration_number'
                            data-institution_id='$student->institution_id' 
                            data-fullname='$student->fullname' 
                            data-nickname='$student->nickname' 
                            data-parent='$student->parent' 
                            data-job='$student->job' 
                            data-address='$student->address' 
                            data-phone='$student->phone' 
                            data-tuition='$student->tuition' 
                            data-infrastructure_fee='$student->infrastructure_fee' 
                            data-group='$sgs'
                            data-gender='$student->gender'

                            data-image='$student->image' 

                            data-stop_date='$student->stop_date' >
                            <i class='glyphicon glyphicon-edit'></i>
                        </button>

                        <button id='btn-delete-student' class='btn btn-danger btn-xs' data-id='$student->id'>
                            <i class='glyphicon glyphicon-trash'></i>
                        </button>
                    </div>
                    ";
                } else {
                    return "
                    <div class='btn-group'>
                        <button class='btn disabled btn-default btn-xs'><i class='glyphicon glyphicon-edit'></i></button>

                        <button class='btn disabled btn-danger btn-xs'><i class='glyphicon glyphicon-trash'></i></button>
                    </div>
                    ";
                }
            })

            ->rawColumns(['name_href','formated_registered_date','actions','status','gender_x']);
        return $datatable->make(true);
           
    }


}
