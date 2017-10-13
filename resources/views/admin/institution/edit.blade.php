@extends('template.layout')

@section('header-scripts')
@endsection

@section('footer-scripts')
@endsection 

@section('content-main')
<div class="box box-primary">
    {!! Form::model($institution, ['action'=> ['admin\InstitutionController@update', $institution->id], 'method'=>'patch', 'role' => 'form']) !!}
        @include('admin.institution.fields')  
    {!! Form::close() !!}
</div>
@endsection	


