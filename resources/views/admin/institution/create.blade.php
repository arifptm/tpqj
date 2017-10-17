@extends('template.layout')

@section('header-scripts')
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/flat/purple.css">
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.css">
  <link rel="stylesheet" href="/plugins/datepicker/css/bootstrap-datepicker3.css">
@endsection

@section('footer-scripts')
  <script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>
  <script src="/bower_components/AdminLTE/plugins/select2/select2.min.js"></script>
  <script src="/plugins/datepicker/js/bootstrap-datepicker.js"></script>
  <script src="/plugins/datepicker/locales/bootstrap-datepicker.id.min.js"></script>  
  <script>
    $('input[type="checkbox"], input[type="radio"]').iCheck({
      checkboxClass: 'icheckbox_flat-purple',
      radioClass   : 'iradio_flat-purple'
    });
    
    $('.select2').select2();
    
    $('.datepicker').datepicker({      
      language: 'id',
      autoclose: true,
      todayHighlight:true,
      format: 'dd-mm-yyyy'
    });    
  </script>
@endsection 

@section('content-top')
  @include('flash::message')
  <h1>Tambah Lembaga</h1>
@endsection

@section('content-main')
<div class="box box-primary">
    {!! Form::open(['action' => 'admin\InstitutionController@store']) !!}
        @include('admin.institution.fields')  
    {!! Form::close() !!}
</div>
@endsection	