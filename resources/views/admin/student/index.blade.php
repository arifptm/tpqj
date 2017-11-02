@extends('template.layout')

@section('header-scripts')
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/flat/purple.css">
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css">

  <link rel="stylesheet" href="/bower_components/jquery.calendars-2.1.0/css/ui.calendars.picker.css">
  <link rel="stylesheet" href="/bower_components/jquery.calendars-2.1.0/css/jquery.calendars.picker.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.0/css/responsive.dataTables.min.css">

@endsection

@section('footer-scripts')
  <script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>
  <script src="/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.js"></script>

  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.plugin.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.min.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.plus.min.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.picker.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.islamic.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.picker-id.js"></script>  

  <script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script> 
  <script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js"></script>
  <script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>   
  @include('admin.student.datatable')
  @include('admin.student.ajax')

  <script src="/js/custom.js"></script>
  @endsection

@section('content-top')
  <div class="alert bg-green lead" style='display:none;'><i class="icon fa fa-check"></i> <span id="ajaxmessage"></span></div>
  <h1>Santri
    <button id='btn-modal-create' class='btn btn-primary'><i class="fa fa-plus-circle"></i> Tambah Santri</button>
  </h1>
@endsection

@section('content-main')

<div class="row">
  <div class="col-md-12">
    <div class="box box-default collapsed-box box-solid">
      
      <div class="box-header with-border" style="padding:5px;">              
        <button type="button" class="btn bg-olive" data-widget="collapse">
          <i class="fa fa-plus"></i> &nbsp; &nbsp;<h3 class="box-title"> Tampilkan lembaga</h3>
        </button>
      </div>
      
      <div class="box-body">
        <div class="form-group icheck">             
          @foreach ($institutions_filter->chunk(5) as $chunk)
            <div class="col-md-3">
              @foreach ($chunk as $institution)
                {!! Form::checkbox('chosen_institution[]', $institution->id, false,  ['id'=>$institution->slug]) !!}
                {!! Form::label( $institution->slug, $institution->name , ['class'=>'control-label']) !!}<br>
              @endforeach
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-8">
    <div class="box">    
      <div class="box-body">  
        <table class="table table-bordered" id="students-data">
          <thead>
          <tr>
            <th>ID</th>
            <th>Terdaftar</th>          
            <th>Lembaga</th>
            <th>Nama</th>
            <!-- <th>Jenis Kelamin</th> -->
            <th>Status</th>
            <th></th>          
          </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  

  <div class="col-md-4">
    <div class="row">        
      <div id="student-stat">
        <div class="loader" style="min-height: 200px;"></div>          
      </div>        
    </div>
  </div>

</div>  

@include('/admin/student/modal')

@endsection