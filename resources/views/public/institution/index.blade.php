@extends('template.layout')

@section('header-scripts')
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/flat/purple.css">
@endsection

@section('footer-scripts')
	<script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>
	<script src="/js/custom.js"></script>
@endsection

@section('content-top')
  <h1>Daftar Lembaga Qiraati
  </h1>
@endsection

@section('content-main')
	<div class="row">  	
		<div class="col-xs-12 col-md-8">
          <div class="box box-success box-solid">
            <div class="box-body">
              Lembaga = {{ $institutions->count() }}
            </div>          
          </div>          
        </div>

    </div>

  <div class="row">
  	<div class="col-md-8">
		  <div class="box">    
		    <div class="box-body">
		      <table class="table table-bordered">
		        <tr>
		          <th class="hidden-xs" style="width: 50px">No</th>
		          <th >Nama Lembaga</th>
		          <th class="hidden-xs">Kepala TPQ</th>
		          <th>Wilayah</th>
		        </tr>
		        @if (count($institutions) > 0)
		          @foreach ($institutions as $institution)
		            <tr>
		              <td class="hidden-xs">
		                {{ $loop->iteration }}
		              </td>
		              <td>
		                <a href="/institutions/{{ $institution->slug }}"><strong>{{ $institution->name }}</strong></a>
		              </td>
		              <td class="hidden-xs">
		                {{ $institution->theheadmaster->name }}
		              </td>
		              <td>
		                {{ $institution->region->name }}
		              </td>
		            </tr>
		          @endforeach
		        @endif
		      </table>
		    </div>    
		  </div>
		</div>
	</div>

@endsection