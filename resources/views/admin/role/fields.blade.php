
<div class="box-body">
	<div class="col-md-6">					

		<div class="form-group">
			{!! Form::label('name', 'Role Name', ['class'=>'control-label']) !!}
			{!! Form::text('name', null, ['class' => 'form-control']) !!}
			@if ($errors->has('name'))
			    <div class="label label-danger">
			        {{ $errors->first('name') }}
			    </div>
			@endif
		</div>	

		<div class="form-group">
			{!! Form::label('title', 'Role Title', ['class'=>'control-label']) !!}
			{!! Form::text('title', null, ['class' => 'form-control']) !!}
			@if ($errors->has('title'))
			    <div class="label label-danger">
			        {{ $errors->first('title') }}
			    </div>
			@endif
		</div>	

	</div>
</div>


<div class="box-footer">
	<div class="form-group">
		{!! Form::submit('Simpan',  ['class' => 'btn btn-primary']) !!}
	</div>
</div>	