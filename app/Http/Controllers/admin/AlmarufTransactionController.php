<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use \Carbon\Carbon;

use App\AlmarufTransaction;
use App\TransactionType;
use App\Student;
use App\ClassGroup;


class AlmarufTransactionController extends Controller
{
    public function index(){
    	$transactions = AlmarufTransaction::where('created_at','>=', Carbon::now()->subMonth() )->orderBy('created_at','desc')->with('student','studentGroup', 'transactionType')->get()->groupBy(function($item, $key){ return $item->created_at->format('d-m-Y');});
                
        //dd($transactions[0]->created_at->format('Y'));

        // dd($transactions->groupBy(function($item, $key){
        //     return $item->created_at->format('d-m-Y');
        // }));

        //dd($transactions);
        
    	$t_types = TransactionType::orderBy('id','asc')->get();
    	$class_groups = ClassGroup::all();
    	$students = Student::whereInstitution_id(9)->orderBy('fullname','asc')->pluck('fullname','id')->toArray();    	
    	
    	return view('admin.transaction.index',['transactions'=> $transactions, 't_types'=>$t_types, 'students'=>$students,'class_groups'=>$class_groups]);
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
        
        return response()->json(['new' => $transaction->load('student', 'transactionType')]);        
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

        return response()->json(['transaction' => $transaction->load('student')]);       
    }    



    public function ajaxDelete(Request $request)
    {
        $transaction = AlmarufTransaction::findOrFail($request->id);
        $transaction->delete();
        return response()->json(['transaction'=>$transaction]);
    }


    public function indexData($arg = 'all' ){
        if ($arg == 'all'){
            $transaction = AlmarufTransaction::select('almaruf_transactions.*')->with(['student', 'transactionType', 'studentGroup']);
        } else {
            $transaction = AlmarufTransaction::select('almaruf_transactions.*')->where('almaruf_transactions.created_at','=', $arg)->with(['student', 'transactionType', 'studentGroup']);
        }
    
        //dd($transaction);

        $datatable = Datatables::of($transaction)

            ->addColumn('type', function($transaction){
                $tp = "<small>";
                if($transaction->class_group_id == 1) {
                    $tp .= "<span class='label bg-green disable'>";
                } else if ($transaction->class_group_id == 3) {
                    $tp .= "<span class='label bg-orange disable'>";
                }  else if ($transaction->class_group_id == 5) {
                    $tp .= "<span class='label bg-teal disable'>";
                }                
                $tp .= $transaction->studentGroup->name. "</span></small> ";
                $tp .= $transaction->transactionType->name." ";
                $tp .= $transaction->tuition_month ? Carbon::parse($transaction->tuition_month)->format('M Y') : '';
                return $tp;
            })
            
            ->addColumn('fdate', function($transaction){
                $dt = explode('-', $transaction->transaction_date);
                return $dt[2]."-".$dt[1]."-".$dt[0];
            })

            ->addColumn('fname', function($transaction){      
                $name = $transaction->student->fullname;
                $slug = $transaction->student->slug;
                return "<a href='/admin/students/$slug'><b>$name</b></a>";
            })

            ->addColumn('famount', function($transaction){
                return "Rp. ".number_format($transaction->amount,0,',','.');
            })

            ->addColumn('actions', function($transaction){
                $tm = $transaction->tuition_month ?: '0';
                return "                
                <div class='btn-group'>
                    <button id='btn-modal-edit' class='btn btn-default btn-xs'
                        data-id = '$transaction->id' 
                        data-transaction_date = '$transaction->transaction_date' 
                        data-transaction_type_id = '$transaction->transaction_type_id'                         
                        data-tuition_month='$tm'
                        data-student_id='$transaction->student_id' 
                        data-class_group_id='$transaction->class_group_id' 
                        data-amount='$transaction->amount' 
                        data-notes='$transaction->notes' >
                        <i class='glyphicon glyphicon-edit'></i>
                    </button>

                    <button id='btn-delete-transaction' class='btn btn-danger btn-xs' data-id='$transaction->id'>
                        <i class='glyphicon glyphicon-trash'></i>
                    </button>
                </div>
                ";
            })

            ->rawColumns(['actions', 'type', 'famount', 'fdate', 'fname']);
        return $datatable->make(true);           
    }
    
}
