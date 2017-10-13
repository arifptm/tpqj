@extends('template.layout')

@section('header-scripts')
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/flat/purple.css">
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.css">
  <link rel="stylesheet" href="/plugins/datepicker/css/bootstrap-datepicker3.css">

  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('footer-scripts')
  <script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>
  <script src="/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.js"></script>
  <script src="/bower_components/AdminLTE/plugins/select2/select2.min.js"></script>
  <script src="/plugins/datepicker/js/bootstrap-datepicker.js"></script>
  <script src="/plugins/datepicker/locales/bootstrap-datepicker.id.min.js"></script>
  @include('admin.achievement.ajax')

  <script src="/js/custom.js"></script>
  @endsection

@section('content-top')
  <div class="alert bg-green lead" style='display:none;'><i class="icon fa fa-check"></i> <span id="ajaxmessage"></span></div>
  <h1>Prestasi
    <button id='btn-modal-create' class='btn btn-primary' ><i class="fa fa-plus-circle"></i> Kenaikan Jilid</button> 
  </h1>
@endsection

@section('content-main')
  <div class="box">    
    <div class="box-body">
      <table class="table table-bordered" id="achievements-data">
        <tr>
          <th>#</th>
          <th>Tanggal</th>
          <th>Nama Santri</th>
          <th>Prestasi</th>
          <th>Waktu berjalan</th>
          <th>Keterangan</th>
        </tr>
        @foreach($achievements as $achievement)
        <tr>
          <td>
            {{ $achievement->id }}
          </td>
          <td>
            {{ $achievement->achievement_date->format('d-M-y') }}
          </td>
          <td>
            {{ $achievement->student->fullname }}
          </td> 

          <td>
            {{ $achievement->stage->name }}
          </td> 
          <td>
            {{ $achievement->achievement_date->diff(\Carbon\Carbon::now())->format('%m bulan %d hari') }}            
          </td>           
          <td>
            {{ $achievement->notes or '...' }}
          </td> 
          <td>
            
            @if( in_array($achievement->student->institution_id, Auth::user()->institution->pluck('id')->toArray() ) )
              <div class='btn-group'>                
                {!! Form::button('<i class="glyphicon glyphicon-edit"></i>' ,[
                  'class'=> 'btn btn-default btn-xs',
                  'id'=>'btn-modal-edit',
                  'data-id' => $achievement->id,
                  'data-achievement_date' => $achievement->achievement_date->format('d-m-Y'),
                  'data-student_id' => $achievement->student_id,
                  'data-stage_id' => $achievement->stage_id,
                  'data-notes' => $achievement->notes,
                ]) !!}

                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['class' => 'btn btn-danger btn-xs', 'id'=>'btn-delete-achievement', 'data-id'=> $achievement->id ]) !!}
              </div>
            @else
              <div class='btn-group'>                
                {!! Form::button('<i class="glyphicon glyphicon-edit"></i>' ,['class'=> 'btn disabled btn-default btn-xs' ]) !!}

                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['class' => 'btn disabled btn-danger btn-xs' ]) !!}
              </div>            
            @endif  

          </td>                   
                  
        </tr> 
        @endforeach
      </table>
    </div>
    
    <div class="box-footer clearfix">      
    </div>
  </div>
@include('/admin/achievement/modal')

@endsection