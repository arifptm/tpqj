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

use App\Http\Requests\CreateAlmarufTransaction;
use App\Http\Requests\EditAlmarufTransaction;


class AlmarufTransactionController extends Controller
{
    public function index(){        
    	$t_types = TransactionType::orderBy('id','asc')->get();
    	$class_groups = ClassGroup::all();
    	$students = Student::active()->whereInstitution_id(9)->orderBy('fullname','asc')->get();    	
        foreach($students as $student){
            $option_stu[$student->id] = str_limit($student->fullname,17,'~')."/".$student->nickname;
        }
    	return view('admin.transaction.index',['t_types'=>$t_types, 'students'=>$option_stu,'class_groups'=>$class_groups]);
    }






    public function AlmarufTransactionStatistic(){
        $trans = new AlmarufTransaction; 
        
        $transactions = $trans->where('created_at','>=', Carbon::now()->subMonth() )->orderBy('created_at','desc')->with('student','studentGroup', 'transactionType')->get()->groupBy(function($item, $key){ return $item->created_at->format('d-m-Y');});

        $stat['tpqa'] = $trans->whereClass_group_id(1)->sum('amount');
        $stat['tpqd'] = $trans->whereClass_group_id(3)->sum('amount');
        $stat['non-santri'] = $trans->whereClass_group_id(5)->sum('amount'); 

        $tr_type = TransactionType::with('almarufTransaction')->get(['id','name']);       
        
        foreach($tr_type as $i){            
            $d[$i->id]['id'] = $i['id'];
            $d[$i->id]['name'] = $i['name'];
            $d[$i->id]['debet_a'] = $i->almarufTransaction->where('amount', '>', 0)->where('class_group_id',1)->sum('amount');
            $d[$i->id]['credit_a'] = $i->almarufTransaction->where('amount', '<', 0)->where('class_group_id',1)->sum('amount');
            $d[$i->id]['debet_d'] = $i->almarufTransaction->where('amount', '>', 0)->where('class_group_id',3)->sum('amount');
            $d[$i->id]['credit_d'] = $i->almarufTransaction->where('amount', '<', 0)->where('class_group_id',3)->sum('amount');    
            $d[$i->id]['debet_ns'] = $i->almarufTransaction->where('amount', '>', 0)->where('class_group_id',5)->sum('amount');
            $d[$i->id]['credit_ns'] = $i->almarufTransaction->where('amount', '<', 0)->where('class_group_id',5)->sum('amount');    
        }
        return view('admin.transaction.block-statistic',['transactions_statistic'=>$d, 'total_stat'=>$stat, 'transactions'=> $transactions] );        
    }






    public function ajaxCreate(CreateAlmarufTransaction $request){
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
                $input['tuition_month'] = $request->tuition_month_ymd;
            }
        }

        $transaction = AlmarufTransaction::create($input);
        
        return response()->json(['new' => $transaction->load('student', 'transactionType')]);        
    }

    public function ajaxUpdate(EditAlmarufTransaction $request){
        
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
                $input['tuition_month'] = $request->tuition_month_ymd;
            } else {
                $input['tuition_month'] = null;
            }
        }

        $transaction = AlmarufTransaction::findOrFail($request->id);
        $transaction->update($input);                

        return response()->json(['new' => $transaction->load('student', 'transactionType')]);       
    }    



    public function ajaxDelete(Request $request)
    {
        $transaction = AlmarufTransaction::findOrFail($request->id);
        $transaction->delete();
        return response()->json(['transaction'=>$transaction]);
    }


    public function indexData($arg){
        if ($arg == 'all'){
            $transaction = AlmarufTransaction::select('almaruf_transactions.*')->with(['student', 'transactionType', 'studentGroup']);
        } else {
            $transaction = AlmarufTransaction::select('almaruf_transactions.*')->whereBetween('almaruf_transactions.created_at', [$arg.' 00:00:00', $arg.' 23:59:59'])->with(['student', 'transactionType', 'studentGroup']);
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
                $nname = $transaction->student->nickname;
                $slug = $transaction->student->slug;
                return "<a href='/admin/students/$slug'><b>".str_limit($name,15,'~')."</b></a>/$nname";
            })

            ->addColumn('famount', function($transaction){
                return "<div class='text-right'>Rp. ".number_format($transaction->amount,0,',','.')."</div>";
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
