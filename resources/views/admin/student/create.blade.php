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
  <h1>Tambah User</h1>
@endsection

@section('content-main')
<div class="box box-primary">
    {!! Form::open(['action' => 'admin\UserController@store', 'files' => true]) !!}    
        @include('admin.user.fields')  
    {!! Form::close() !!}
</div>
@endsection	