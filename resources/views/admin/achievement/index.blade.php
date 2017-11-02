@extends('template.layout')

@section('header-scripts')
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/flat/purple.css">
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.css">
  <!-- <link rel="stylesheet" href="/plugins/datepicker/css/bootstrap-datepicker3.css"> -->
  <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css"> -->
  <link rel="stylesheet" href="/bower_components/jquery.calendars-2.1.0/css/ui.calendars.picker.css">
  <link rel="stylesheet" href="/bower_components/jquery.calendars-2.1.0/css/jquery.calendars.picker.css">


  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.0/css/responsive.dataTables.min.css">

  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('footer-scripts')
  <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
  
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment.min.js"></script> -->
  <!-- <script src="/bower_components/datepicker-moment/moment-datepicker/moment-datepicker.min.js"></script> -->
  <script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>
  <script src="/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.js"></script>
  <script src="/bower_components/AdminLTE/plugins/select2/select2.min.js"></script>
  <!-- <script src="/plugins/datepicker/js/bootstrap-datepicker.js"></script> -->
  <!-- <script src="/plugins/datepicker/locales/bootstrap-datepicker.id.min.js"></script> -->
  
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.plugin.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.min.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.plus.min.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.picker.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.islamic.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.picker-id.js"></script>
  
  <script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script> 
  <script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js"></script>
  <script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>   
  @include('admin.achievement.datatables')
  @include('admin.achievement.ajax')

  <script src="/js/custom.js"></script>
  @endsection

@section('content-top')
  <div class="alert bg-green lead" style='display:none;'><i class="icon fa fa-check"></i> <span id="ajaxmessage"></span></div>
  <h1>Prestasi
    <button id='btn-modal-create' class='btn btn-primary' ><i class="fa fa-plus-circle"></i> Kelulusan</button> 
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
          @foreach ($institutions->chunk(5) as $chunk)
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
      <div class="box-body" style="min-height:200px;">
        <table class="table table-bordered" id="achievements-data">
          <thead>
            <tr>              
              <th>ID</th>          
              <th>Tgl Lulus</th>
              <th>Nama Santri</th>          
              <th>Kelas</th>              
              <th>Aksi</th>          
            </tr>
          </thead>
        </table>
      </div>        
      <div class="box-footer clearfix">        
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="row">        
      <div id="achievement-stat">
        <div class="loader" style="min-height: 200px;"></div>          
      </div>        
    </div>
  </div>
</div>
@include('/admin/achievement/modal')
@endsection
