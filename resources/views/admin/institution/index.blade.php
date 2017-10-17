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
  @include('/admin/institution/ajax')
  <script src="/js/custom.js"></script>
@endsection

@section('content-top')
  <div class="alert bg-green lead" style='display:none;'><i class="icon fa fa-check"></i> <span id="ajaxmessage"></span></div>
  <h1>Daftar Lembaga
  @can ('manage-institutions')
    <!-- <a href="/admin/institutions/create" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah</a> -->
    <button id='btn-modal-create' class='btn btn-primary' ><i class="fa fa-plus-circle"></i> Tambah</button> 
  @endcan
  </h1>
@endsection

@section('content-main')
  <div class="row">   
    <div class="col-xs-12 col-md-12">
          <div class="box box-success box-solid">
            <div class="box-body">
              Lembaga = <span id="institution_count">{{ $institutions->total() }}</span>
            </div>          
          </div>          
        </div>
    </div>

  <div class="box">    
    <div class="box-body">
      <table class="table table-bordered" id="table-institution">
        <tr>
          <th style="width: 50px" class="hidden-xs">ID</th>
          <th class="hidden-xs">Tgl Berdiri</th>
          <th >Nama Lembaga</th>
          <th class="hidden-xs">Kepala TPQ</th>
          <th>Wilayah</th>
          <th class="hidden-xs">Area</th>
          @can ('manage-institutions')
            <th style="width: 64px">Aksi</th>
          @endcan
        </tr>
        @if (count($institutions) > 0)
          @foreach ($institutions as $institution)
            @if ( in_array($institution->id, Auth::user()->institution->pluck('id')->toArray() ))
              <tr class='bg-info' id="row-{{$institution->id}}">
            @else
              <tr id="row-{{$institution->id}}">
            @endif  
              <td class="hidden-xs">
                {{ $institution->id }}
              </td>
              <td class="hidden-xs">                
                @if ($institution->established_date)
                  {{ \Carbon\Carbon::parse($institution->established_date)->format('d-m-Y') }}                
                @else
                  ...
                @endif 
              </td>
              <td>
                <a href="/admin/institutions/{{ $institution->slug }}"><strong>{{ $institution->name }}</strong></a>                 
              </td>
              <td class="hidden-xs">
                {{ $institution->theheadmaster->name }}
              </td>
              <td>
                {{ $institution->region->name }}
              </td>
              <td class="hidden-xs">
                {{ $institution->region->regionGroup->groupname }}
              </td>
              @can ('manage-institutions')
                <td>
                  <div class="btn-group">
                      <button id='btn-modal-edit' class='btn btn-default btn-xs'
                            data-id =  "{{ $institution->id }}"
                            data-established_date =  "@if($institution->established_date) {{ \Carbon\Carbon::parse($institution->established_date)->format('d-m-Y') }} @endif"
                            data-name =  "{{ $institution->name }}"
                            data-region_id = "{{ $institution->region_id }}"
                            data-headmaster = "{{ $institution->headmaster }}"
                            data-address = "{{ $institution->address }}" >
                            <i class='glyphicon glyphicon-edit'></i>
                        </button>

                        <button id='btn-delete-institution' class='btn btn-danger btn-xs' data-id=" {{$institution->id}} ">
                            <i class='glyphicon glyphicon-trash'></i>
                        </button>
                      </div>
                </td>
              @endcan
            </tr>
          @endforeach
        @endif
      </table>
    </div>
    
    <div class="box-footer clearfix">
      {{ $institutions->links('vendor.pagination.bootstrap-4') }}  
    </div>
  </div>
  @include('/admin/institution/modal')
@endsection