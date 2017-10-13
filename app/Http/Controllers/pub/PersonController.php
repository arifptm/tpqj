<?php

namespace App\Http\Controllers\pub;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//use Illuminate\Support\Facades\Redis;
use Yajra\DataTables\Facades\DataTables;

use App\Person;


class PersonController extends Controller
{
	public function index(){					
		$persons = Person::with('mainInstitution','mainInstitution.region','extraInstitution')->orderBy('name','asc')->paginate(20);	
		return view('public.person.index',['persons'=>$persons]);
	}



    public function show($slug){
    	$person = Person::whereSlug($slug)->first();
    	return view('public.person.show',['person'=>$person]);
    }

	public function dataIndex(){
		$person = Person::with(['mainInstitution'=>function($q){
			$q->select('name');
		},'extraInstitution'])->select('persons.*');
        
        $datatable = Datatables::of($person)
            ->addColumn('name_href', function ($person) {
                return '<a href="/persons/'.$person->slug.'"><strong>'.$person->name.'</strong></a>';                    
            })

            ->addColumn('institutions', function($person){
                $mi = ''; $ei = '';
                	foreach($person->mainInstitution as $min){
                		$mins[] = $min->name;	
                	}
                
                $mi = $mins[0];
                
                
                if(count($person->extraInstitution) != 0){                    
                    foreach ($person->extraInstitution as $ein) {
                        $eins[] = $ein->name .' ('.$ein->region->name.')';
                    }
                    $ei = implode('<br> ', $eins);
                    $ei = '<br><small><span class="fa fa-plus-circle"></span> '.$ei;
                }
                
                return $mi.''.$ei;
            })

            ->rawColumns(['name_href','institutions']);
        return $datatable->make(true);
	}    
}
