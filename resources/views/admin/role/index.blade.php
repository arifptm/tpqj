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
  <h1>Roles <a href="/manage/roles/create" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Role</a> <a href="/manage/ability/create" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Ability</a></h1>
@endsection

@section('content-main')
  <div class="box">    
    <div class="box-body">
      <table class="table table-bordered">
        <tr>
          
          <th style="width: 40px">ID</th>
          <th>Role Name</th>
          <th>Title</th>
          <th style="width: 64px">Action</th>
        </tr>
        @if (count($roles) == 0)
          Gak ada data
        @endif

          @foreach ($roles as $role)
            <tr>
              <td>
                {{ $role->id }}
              </td>
              <td>
              	{{ $role->name }}
              </td>
              <td>
                {{ $role->title }}
              </td>
              <td>
                {{ $role->abilities }}
              </td>              
              <td>
                {!! Form::open(['url' => '/manage/roles/'.$role->id, 'method' => 'delete']) !!}
                <div class='btn-group'>
                  <a href="/manage/roles/{{$role->id}}/edit" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                  {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}	                  
              </td>
            </tr>
          @endforeach

      </table>
    </div>
  </div>

@endsection