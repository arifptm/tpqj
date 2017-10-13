@extends('template.layout')

@section('header-scripts')
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/flat/purple.css">
@endsection

@section('footer-scripts')
	<script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>
	<script src="/js/custom.js"></script>
@endsection

@section('content-top')
  @include('flash::message')
  <h1>Lembaga <span class="badge bg-black">{{ $institutions->count() }}</span>
  @can ('manage-institutions')
    <a href="/admin/institutions/create" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah Lembaga</a>
  @endcan
  </h1>
@endsection

@section('content-main')
  <div class="box">    
    <div class="box-body">
      <table class="table table-bordered">
        <tr>
          <th style="width: 50px">ID</th>
          <th >Tgl Berdiri</th>
          <th >Nama Lembaga</th>
          <th>Kepala TPQ</th>
          <th>Wilayah</th>
          <th>Area</th>
          @can ('manage-institutions')
            <th style="width: 64px">Action</th>
          @endcan
        </tr>
        @if (count($institutions) > 0)
          @foreach ($institutions as $institution)
            @if ( in_array($institution->id, Auth::user()->institution->pluck('id')->toArray() ))
              <tr class='bg-info'>
            @else
              <tr>
            @endif  
              <td>
                {{ $institution->id }}
              </td>
              <td>                
                @if ($institution->established_date)
                  {{ \Carbon\Carbon::parse($institution->established_date)->format('d M y') }}                
                @else
                  ...
                @endif 
              </td>
              <td>
                <a href="/admin/institutions/{{ $institution->slug }}"><strong>{{ $institution->name }}</strong></a>                 
              </td>
              <td>
                {{ $institution->theheadmaster->name }}
              </td>
              <td>
                {{ $institution->region->name }}
              </td>
              <td>
                {{ $institution->region->regionGroup->groupname }}
              </td>
              @can ('manage-institutions')
                <td>
                  {!! Form::open(['url' => '/admin/institutions/'.$institution->id, 'method' => 'delete']) !!}
                  <div class='btn-group'>
                    <a href="/admin/institutions/{{$institution->id}}/edit" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Apakah anda yakin?')"]) !!}
                  </div>
                  {!! Form::close() !!}	                  
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

@endsection