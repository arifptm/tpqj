@extends('template.layout')

@section('header-scripts')
  
@endsection

@section('footer-scripts')
@endsection 

@section('content-top')
  @include('flash::message')
@endsection

@section('content-main')
<div class="row">
	<div class="col-md-6">	
		<div class="box box-primary">
		    {!! Form::open(['action' => 'RoleController@storeUserRole']) !!}
		        <div class="box-header">
		        	<h3 class="block-title">Assign</h3>
		        </div>
		        <div class="box-body">									
					<div class="form-group">
						{!! Form::label('user_id', 'User Name', ['class'=>'control-label']) !!}
						{!! Form::select('user_id', $users ,null, ['class' => 'form-control']) !!}
						@if ($errors->has('user_id'))
						    <div class="label label-danger">
						        {{ $errors->first('user_id') }}
						    </div>
						@endif
					</div>	

					<div class="form-group">
						{!! Form::label('role_id', 'Role Title', ['class'=>'control-label']) !!}
						{!! Form::select('role_id', $roles ,null, ['class' => 'form-control']) !!}
						@if ($errors->has('role_id'))
						    <div class="label label-danger">
						        {{ $errors->first('role_id') }}
						    </div>
						@endif
					</div>	
				</div>
				<div class="box-footer">
					<div class="form-group">
						{!! Form::submit('Simpan',  ['class' => 'btn btn-primary']) !!}
					</div>
				</div>	
			{!! Form::close() !!}
		</div>
	</div>
	<div class="col-md-6">	
		<div class="box box-primary">
		    {!! Form::open(['action' => 'RoleController@deleteUserRole']) !!}
		        <div class="box-header">
		        	<h3 class="block-title">Retract</h3>
		        </div>
		        <div class="box-body">									
					<div class="form-group">
						{!! Form::label('user_id', 'User Name', ['class'=>'control-label']) !!}
						{!! Form::select('user_id', $users ,null, ['class' => 'form-control']) !!}
						@if ($errors->has('user_id'))
						    <div class="label label-danger">
						        {{ $errors->first('user_id') }}
						    </div>
						@endif
					</div>	

					<div class="form-group">
						{!! Form::label('role_id', 'Role Title', ['class'=>'control-label']) !!}
						{!! Form::select('role_id', $roles ,null, ['class' => 'form-control']) !!}
						@if ($errors->has('role_id'))
						    <div class="label label-danger">
						        {{ $errors->first('role_id') }}
						    </div>
						@endif
					</div>	
				</div>
				<div class="box-footer">
					<div class="form-group">
						{!! Form::submit('Simpan',  ['class' => 'btn btn-primary']) !!}
					</div>
				</div>	
			{!! Form::close() !!}
		</div>
	</div>
</div>




@endsection	


