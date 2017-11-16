@extends('template.layout')

@section('header-scripts')
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/flat/purple.css">
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.css">

  <link rel="stylesheet" href="/bower_components/jquery.calendars-2.1.0/css/ui.calendars.picker.css">
  <link rel="stylesheet" href="/bower_components/jquery.calendars-2.1.0/css/jquery.calendars.picker.css">

  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.0/css/responsive.dataTables.min.css">

  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('footer-scripts')
  <script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>
  <script src="/bower_components/AdminLTE/plugins/select2/select2.min.js"></script>

  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.plugin.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.min.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.plus.min.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.picker.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.islamic.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.picker-id.js"></script>

  <script src="/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script> 
  <script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js"></script>
  
  @include('admin.achievement.datatables')
  @include('admin.achievement.ajax')

@endsection

@section('content-top')
  <div class="alert bg-green lead" style='display:none;'><i class="icon fa fa-check"></i> <span id="ajaxmessage"></span></div>
  <h1>Prestasi
    <button id='btn-modal-create' class='btn btn-primary' ><i class="fa fa-plus-circle"></i> Kelulusan</button> 
  </h1>
@endsection

@section('content-main')
  
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
    <div class="box box-primary" style="min-height: 100px;">
      <div class="box-header">
        <h3 class="box-title">Jumlah santri per kelas 
          @if (Auth::user()->institution->count() == 1 )
            : <b>TPQ {{ Auth::user()->institution[0]->name }}</b>
          @endif
        </h3>
      </div>

      
        <div class="box-body bg-gray-light 
          {{(Auth::user()->institution->count() == 1 ) ? 'hidden' : '' }}
        ">
          <div class="row">
            <div class="icheck"> 
              <div class="col-md-6">
                <button id="select_all" class="btn btn-xs bg-green">PILIH SEMUA</button>
              </div>
              @foreach ($institutions->chunk(1) as $chunk)            
                @foreach ($chunk as $institution)
                  <div class="col-md-6">
                    <input value="{{$institution->id}}" id="{{$institution->slug}}" type="checkbox" name="chosen_institution[]" {{ (in_array($institution->id, $ui)) ? "checked" : "" }} >
                    {!! Form::label( $institution->slug, $institution->name , ['class'=>'control-label']) !!}<br>
                  </div>  
                @endforeach           
              @endforeach
            </div>        
          </div>
        </div>
     
    
      <div id="achievement-stat">     
        <div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>  
      </div>        
    </div>
  </div>
</div>

@include('/admin/achievement/modal')
@endsection
