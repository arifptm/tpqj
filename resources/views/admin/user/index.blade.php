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
  <h1>Users 
  @can('manage-roles')
    <a href="/manage/roles/create-user-role" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Role</a>
  @endcan
  <a href="/manage/users/create" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah User</a>
  </h1>
@endsection

@section('content-main')
  <div class="box">    
    <div class="box-body">
      <table class="table table-bordered">
        <tr>
          <th style="width: 40px" class="icheck">{!! Form::checkbox("select-all",null,false, ['class'=>'flat-purple', 'id'=>'select-all']) !!}</th>
          <th style="width: 50px">ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Roles</th>
          @can('manage-roles')
            <th>Abilities</th>
          @endcan
          <th>Status</th>
          <th style="width: 64px">Action</th>
        </tr>
        @if (count($users) > 0)
          @foreach ($users as $user)
            <tr>
              <td class="icheck">
                {!! Form::checkbox("$user->id",null,false, ['class'=>'flat-purple item']) !!}
              </td>
              <td>
                {{ $user->id }}
              </td>
              <td>
              	<a href="/admin/users/{{$user->id}}"><b>{{ $user->name }}</b></a>
              </td>
              <td>
                {{ $user->email }}
              </td>
              <td>
                <ul>
                  @foreach($user->roles as $role)
                    <li>{{ $role->name }}</li>
                  @endforeach
                </ul>
              </td>
              @can('manage-roles')
              <td>
                @foreach($user->getAbilities() as $able)
                  {{ $able->name }} {{ $able->entity_type }}<br>
                @endforeach
              </td>            
              @endcan 
              <td>
                @if ($user->verified == 1) <span class="label bg-green">Verified</span> @else <span class="label bg-orange">Pending</span>  @endif
              </td>
              <td>
                {!! Form::open(['url' => '/admin/users/'.$user->id, 'method' => 'delete']) !!}
                <div class='btn-group'>
                  <a href="/admin/users/{{$user->id}}/edit" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                  {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}	                  
              </td>
            </tr>
          @endforeach
        @else
          Gak ada data
        @endif
      </table>
    </div>
    
    <div class="box-footer clearfix">
<!--       @if (count($users) > 0)
      <div class="pull-left pagination">  
        {!! Form::model($user, ['action'=> ['admin\UserController@index'], 'role' => 'form']) !!}
          {!! Form::button('Massal', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
          {!! Form::hidden('ids', '0', ['class'=>'selected-id']) !!}
        {!! Form::close() !!} 
      </div>
      @endif -->
      {{ $users->links('vendor.pagination.bootstrap-4') }}  
    </div>
  </div>

@endsection