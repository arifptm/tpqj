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
  <h1>Kelompok TPQ 
    <a href="/admin/class-groups/create" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah Kelompok</a>
  </h1>
@endsection

@section('content-main')
  <div class="box">    
    <div class="box-body">
      <table class="table table-bordered">
        <tr>
          <th style="width: 50px">ID</th>
          <th>Kelompok</th>          
          <th>Keterangan</th>  
          <th style="width: 64px">Action</th>
        </tr>
        @if (count($groups) > 0)
          @foreach ($groups as $group)
            <tr>
              <td>
                {{ $group->id }}
              </td>
              <td>
              	{{ $group->name }}
              </td>
              <td>
                {{ $group->description }}
              </td>
              <td>
                {!! Form::open(['url' => '/admin/class-groups/'.$group->id , 'method' => 'delete']) !!}
                <div class='btn-group'>
                  <a href="/admin/class-groups/{{$group->id}}/edit" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                  {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}	                  
              </td>
            </tr>
          @endforeach
        @endif
      </table>
    </div>
    
  </div>

@endsection