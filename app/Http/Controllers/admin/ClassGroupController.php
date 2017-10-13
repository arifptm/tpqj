<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\ClassGroup;
use Flash;

class ClassGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = ClassGroup::all();
        return view('admin.class-group.index', ['groups'=>$groups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.class-group.create');
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
        ClassGroup::create($input);
        Flash::success('Data kelompok baru berhasil ditambahkan.');
        return redirect('/admin/class-groups');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = ClassGroup::findOrFail($id);
        return view('admin.class-group.edit',['group'=>$group]);
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
        $group = ClassGroup::findOrFail($id);
        $input = $request->except('_token');
        $group->update($input);
        Flash::success('Data kelompok berhasil diperbarui.');
        return redirect('/admin/class-groups');        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = ClassGroup::findOrFail($id);        
        $group->delete();
        Flash::success('Data kelompok berhasil dihapus.');
        return redirect('/admin/class-groups');             
    }
}
