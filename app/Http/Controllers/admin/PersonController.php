<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePerson;

use App\Person;
use App\Institution;
use Auth;
use App\User;
use Yajra\DataTables\Facades\DataTables;
use Flash;
use Response;

class PersonController extends Controller
{
    public function userInstitutions(){
        $ui = Auth::user()->institution->pluck('id')->toArray();
        return $ui;
    }


    public function index(){
        $filtered_institutions = Institution::whereIn('id', $this->userInstitutions())->OrderBy('name','asc')->pluck('name','id')->toArray();
        $all_institutions = Institution::OrderBy('name','asc')->pluck('name','id')->toArray();
        return view('admin.person.index',['filtered_institutions'=>$filtered_institutions, 'all_institutions'=>$all_institutions]); 
    }

    public function show($slug)
    {
        $person = Person::whereSlug($slug)->first();
        return view('admin.person.show',['person'=>$person]);
    }    

    public function ajaxCreate(CreatePerson $request){
        $input = $request->except(['main_institution_id','extra_institution_id']);
        
        if ($request->image != ''){
            $input['image'] = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move('assets/persons/', $input['image']);
        }

        $person = Person::create($input);
        if (!empty($request->main_institution_id)){
            $person->mainInstitution()->attach($request->main_institution_id, ['section' => 'main']);
        }

        if (!empty($request->extra_institution_id)){
            foreach($request->extra_institution_id as $eii){
                $person->extraInstitution()->attach($eii, ['section' => 'extra']);
            }
        }
        

        return response()->json(['name' => $request->name]);        
    }    


    public function ajaxUpdate(Request $request)
    {
        $input = $request->except(['main_institution_id','extra_institution_id']);
        
        if ($request->image != ''){
            $input['image'] = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move('assets/persons/', $input['image']);
        } 

        $person = Person::findOrFail($request->id);
        $person->update($input);
        if (!empty($request->main_institution_id)){
            $person->mainInstitution()->sync($request->main_institution_id, ['section' => 'main']);  
        }    
        if (!empty($request->extra_institution_id)){
            foreach($request->extra_institution_id as $eii){
                $person->extraInstitution()->sync($eii, ['section' => 'extra']);
            }
        }   


        return response()->json(['name' => $person->name]);
    }

    

    public function ajaxDelete(Request $request)
    {
        $person = Person::findOrFail($request->id);
        $person->delete();
        return response()->json(['name'=>$person->name]);
    }




    public function data(){
        $userInstitutions=$this->userInstitutions();
        
        $person = Person::select(['id','registered_date','registration_number','name','slug','image','gender','phone', 'address' ])->with(['mainInstitution'
        ,'mainInstitution.region','extraInstitution','extraInstitution.region']);
        
        $datatable = Datatables::of($person)
            ->addColumn('name_href', function ($person) {
                return '<a href="/admin/persons/'.$person->slug.'"><strong>'.$person->name.'</strong></a>';                    
            })

            ->addColumn('thumbnail_href', function ($person) {
                if($person->image <> null)
                    return '<a href="/persons/'.$person->id.'"><img src="/imagecache/thumbnail/'.$person->image.'" /></a>';
                else
                    return '<a href="/persons/'.$person->id.'"><img src="/imagecache/thumbnail/default.jpg" /></a>';
            })       

            ->addColumn('formatted_registered_date', function($person){
                return \Carbon\Carbon::parse($person->registered_date)->format('d-m-Y');
            })

            ->addColumn('status', function($person){
                if($person->stop_date == null ){
                    return '<span class="badge bg-blue">Aktif</span>';
                } else {
                    return '<span class="badge bg-orange">Non Aktif</span>';
                }
            })

            ->addColumn('institutions', function($person){
                $mi = '';
                $ei = '';
                if(count($person->mainInstitution) != 0){                    
                    foreach ($person->mainInstitution as $min) {
                        $mins[] = $min->name .' ('.$min->region->name.')';
                    }
                    $mi = implode(', ', $mins);
                }
                if(count($person->extraInstitution) != 0){                    
                    foreach ($person->extraInstitution as $ein) {
                        $eins[] = $ein->name .' ('.$ein->region->name.')';
                    }
                    $ei = implode(', ', $eins);
                }
                if ($ei){
                    $ei = '<br><small><span class="fa fa-plus-circle"></span> '.$ei;
                }
                
                return $mi.''.$ei;
            })

            ->addColumn('actions', function($person) use($userInstitutions){
                $main_institutions ='[]';
                $extra_institutions ='[]';
                
                $cm = $person->mainInstitution;
                if(count($cm) != 0){                    
                    $main_institutions ='[';
                    foreach ($cm as $key=>$mins) {
                        $main_institutions .= $mins->id;
                        $main_ins[] = $mins->id;
                        $main_institutions .= $key+1 < count($cm) ? ',' : '';                        
                    }                    
                    $main_institutions .=']';
                }

                $ce = $person->extraInstitution;
                if(count($ce) != 0){
                    $extra_institutions ='[';
                    foreach ($ce as $key=>$eins) {
                        $extra_institutions .= $eins->id;
                        $extra_ins[] = $eins->id;
                        $extra_institutions .= $key+1 < count($ce) ? ',' : '';
                    }
                    $extra_institutions .=']';
                }
                
                if (in_array($main_ins[0], $userInstitutions) ) {
                return "
                    <div class='btn-group'>
                        <button id='btn-modal-edit' class='btn btn-default btn-xs'
                            data-id = '$person->id' 
                            data-main_institution_id = '$main_institutions'
                            data-extra_institution_id = '$extra_institutions'
                            data-registered_date = '$person->registered_date' 
                            data-name ='$person->name' 
                            data-phone ='$person->phone' 
                            data-address = '$person->address' 
                            data-gender='$person->gender' 
                            data-image='$person->image' 
                            data-stop_date='$person->stop_date' >
                            <i class='glyphicon glyphicon-edit'></i>
                        </button>

                        <button id='btn-delete-person' class='btn btn-danger btn-xs' data-id='$person->id'>
                            <i class='glyphicon glyphicon-trash'></i>
                        </button>
                    </div>
                    ";
                } else {
                    return "
                    <div class='btn-group'>
                        <button class='btn disabled btn-default btn-xs'> <i class='glyphicon glyphicon-edit'></i>
                        </button>

                        <button class='btn disabled btn-danger btn-xs'><i class='glyphicon glyphicon-trash'></i>
                        </button>
                    </div>
                    ";
                }
            })

            ->rawColumns(['name_href','thumbnail_href','formated_registered_date','actions', 'edit', 'status','institutions']);
        return $datatable->make(true);
           
    }
}
