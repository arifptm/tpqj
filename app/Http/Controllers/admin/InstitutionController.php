<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Person;
use App\Institution;
use App\Region;
use Flash;
use App\Student;
use App\RegionGroup;

class InstitutionController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:manage-institution', ['except'=>['index','show']]);
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {        
        $institutions = Institution::filtered()->with('region','theheadmaster','region.regionGroup')->orderBy('name','asc')->paginate(20);
        return view('admin.institution.index', ['institutions'=>$institutions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $persons = Person::orderBy('name','asc')->pluck('name','id');
        $regions = Region::orderBy('name','asc')->pluck('name','id');
        return view('admin.institution.create', ['persons' => $persons, 'regions'=>$regions] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except('_token');
        Institution::create($input);
        Flash::success('Data lembaga baru berhasil disimpan.');
        return redirect('/admin/institutions');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $institution = Institution::whereSlug($slug)->first();
        return view('admin.institution.show', ['institution'=>$institution]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $institution = Institution::findOrFail($id);        
        $persons = Person::orderBy('name','asc')->pluck('name','id');
        $regions = Region::orderBy('name','asc')->pluck('name','id');
        return view('admin.institution.edit',['institution'=>$institution,'persons'=>$persons, 'regions'=> $regions]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $institution = Institution::findOrFail($id); 
        $institution->update($input);
        Flash::success('Data lembaga baru berhasil diperbarui.');
        return redirect('/admin/institutions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $institution = Institution::findOrFail($id); 
        $institution->delete();
        Flash::success('Data lembaga baru berhasil dihapus.');
        return redirect('/admin/institutions');        
    }



}
