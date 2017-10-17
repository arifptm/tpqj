<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\CreateStudent;
use Validator;
use \Carbon\Carbon;

use App\Student;
use App\Institution;
use App\ClassGroup;
use App\AlmarufTransaction;

use App\Achievement;

use Auth;


class StudentController extends Controller
{
    public function userInstitutions(){
        $ui = Auth::user()->institution->pluck('id')->toArray();
        return $ui;
    }

    public function index(){
        $groups = ClassGroup::all();
        $institutions = Institution::whereIn('id',$this->userInstitutions())->orderBy('name','asc')->pluck('name','id')->toArray();
        return view('admin.student.index',['groups'=>$groups, 'institutions'=> $institutions]);
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
        $student = Student::with(['group', 'transaction'=>function($q){
            $q->with('transactionType');
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
        
        return view('admin.student.show',['student'=>$student, 'achievements' => $achievements ]);
    }


    public function data(){

        $ui = $this->userInstitutions();
        
        $student = Student::where('group_id','!=','5')->with(['institution', 'group'])->get();

        $datatable = Datatables::of($student)
            ->addColumn('name_href', function ($student) {
                return '<a href="/admin/students/'.$student->slug.'"><strong>'.$student->fullname.'</strong></a> ('.$student->nickname.')';                    
            })

            

            ->addColumn('thumbnail_href', function ($student) {
                if($student->image <> null)
                    return '<a href="/admin/students/'.$student->id.'"><img src="/imagecache/thumbnail/'.$student->image.'" /></a>';
                else
                    return '<a href="/admin/students/'.$student->id.'"><img src="/imagecache/thumbnail/default.jpg" /></a>';
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

            ->rawColumns(['name_href','thumbnail_href','formated_registered_date','actions','status','gender_x']);
        return $datatable->make(true);
           
    }


}
