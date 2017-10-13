<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\AlmarufTransaction;
use App\TransactionType;
use App\Student;
use App\ClassGroup;

class AlmarufTransactionController extends Controller
{
    public function index(){
    	$transactions = AlmarufTransaction::with('student','studentGroup', 'transactionType')->orderBy('transaction_date','desc')->paginate(20);
    	$t_types = TransactionType::orderBy('id','asc')->get();
    	$class_groups = ClassGroup::all();
    	$students = Student::whereInstitution_id(9)->orderBy('fullname','asc')->pluck('fullname','id')->toArray();    	
    	
    	return view('admin.transaction.index',['transactions'=>$transactions,'t_types'=>$t_types, 'students'=>$students,'class_groups'=>$class_groups]);
    }

    public function ajaxCreate(Request $request){
        $input = $request->only(['amount','notes', 'transaction_type_id']);

        $transaction_date = explode('-', $request->transaction_date);        
        $input['transaction_date'] = $transaction_date[2].'-'.$transaction_date[1].'-'.$transaction_date[0];
        
        if ($request->credit == 'yes'){
            $input['student_id'] = 256;  
            $input['class_group_id'] = $request->class_group_id;            
            $input['amount'] = $request->amount * -1;        
        } else {
            $input['student_id'] = $request->student_id; 
            $input['class_group_id'] = Student::find($input['student_id'])->group->id;  
            if ($request->transaction_type_id == 4){
                $tuition_month = explode('-', $request->tuition_month);
                $input['tuition_month'] = $tuition_month[1].'-'.$tuition_month[0].'-01';
            }
        }

        $transaction = AlmarufTransaction::create($input);
        
        return response()->json(['transaction' => $transaction]);        
    }

    public function ajaxUpdate(Request $request){
        
        $input = $request->only(['amount','notes', 'transaction_type_id']);

        $transaction_date = explode('-', $request->transaction_date);        
        $input['transaction_date'] = $transaction_date[2].'-'.$transaction_date[1].'-'.$transaction_date[0];
        
        if ($request->credit == 'yes'){
            $input['student_id'] = 256;  
            $input['class_group_id'] = $request->class_group_id;            
            $input['amount'] = $request->amount * -1;        
        } else {
            $input['student_id'] = $request->student_id; 
            $input['class_group_id'] = Student::find($input['student_id'])->group->id;  
            if ($request->transaction_type_id == 4){
                $tuition_month = explode('-', $request->tuition_month);
                $input['tuition_month'] = $tuition_month[1].'-'.$tuition_month[0].'-01';
            } else {
                $input['tuition_month'] = null;
            }
        }

        $transaction = AlmarufTransaction::findOrFail($request->id);
        $transaction->update($input);                

        return response()->json(['name' => $transaction->student->fullname, 'input'=>$input]);       
    }    



    public function ajaxDelete(Request $request)
    {
        $transaction = AlmarufTransaction::findOrFail($request->id);
        $transaction->delete();
        return response()->json(['message'=>'Transaksi berhasil dihapus.']);
    }


    public function data(){
        
        $student = AlmarufTransaction::where('group_id','!=','5')->with(['institution', 'group'])->get();

        $datatable = Datatables::of($student)
            ->addColumn('name_href', function ($student) {
                return '<a href="/admin/students/'.$student->slug.'"><strong>'.$student->fullname.'</strong></a> ('.$student->nickname.')';                    
            })

            ->addColumn('institution', function($student){
                return $student->institution->name;
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

            ->addColumn('actions', function($student){
                $g = $student->group->slug;
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
                        data-group='$g'
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
            })

            ->rawColumns(['name_href','thumbnail_href','formated_registered_date','actions','status','gender_x']);
        return $datatable->make(true);
           
    }

    
}
