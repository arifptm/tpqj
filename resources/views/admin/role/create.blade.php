@extends('template.layout')

@section('header-scripts')
  
@endsection

@section('footer-scripts')
@endsection 

@section('content-top')
  @include('flash::message')
  <h1>Create Role</h1>
@endsection

@section('content-main')
<div class="box box-primary">
    {!! Form::open(['action' => 'RoleController@store']) !!}
        @include('admin.role.fields')  
    {!! Form::close() !!}
</div>
@endsection	


