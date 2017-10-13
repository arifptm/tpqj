@extends('template.layout')

@section('header-scripts')
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/flat/purple.css">
@endsection

@section('footer-scripts')
@endsection 

@section('content-top')
  @include('flash::message')
  <h1>Edit Role</h1>
@endsection


@section('content-main')
<div class="box box-primary">
    {!! Form::model($role, ['action'=> ['RoleController@update', $role->id], 'method'=>'patch', 'role' => 'form']) !!}
        @include('admin.role.fields')  
    {!! Form::close() !!}
</div>
@endsection	