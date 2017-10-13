@extends('template.layout')

@section('header-scripts')
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/flat/purple.css">
@endsection

@section('footer-scripts')
  <script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>
  <script>
    $('input[type="checkbox"], input[type="radio"]').iCheck({
      checkboxClass: 'icheckbox_flat-purple',
      radioClass   : 'iradio_flat-purple'
    })
  </script>
@endsection 

@section('content-top')
  @include('flash::message')
  <h1>Edit Kelompok</h1>
@endsection

@section('content-main')
<div class="box box-primary">
    {!! Form::model($person, ['action'=> ['admin\PersonController@update', $person->id], 'method'=>'patch','files'=> true, 'role' => 'form']) !!}
        @include('admin.person.fields')  
    {!! Form::close() !!}
</div>
@endsection	


