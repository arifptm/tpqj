
<div class="box-body">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label('name', 'Nama Kelompok', ['class'=>'control-label']) !!}
				{!! Form::text('name', null, ['class' => 'form-control']) !!}
				@if ($errors->has('name'))
				    <div class="label label-danger">
				        {{ $errors->first('name') }}
				    </div>
				@endif
			</div>
			<div class="form-group">
				{!! Form::label('description', 'Keterangan', ['class'=>'control-label']) !!}
				{!! Form::text('description', null, ['class' => 'form-control']) !!}
				@if ($errors->has('description'))
				    <div class="label label-danger">
				        {{ $errors->first('description') }}
				    </div>
				@endif
			</div>
			
		</div>
	</div>
</div>

<div class="box-footer">
	<div class="form-group">
		{!! Form::submit('Simpan',  ['class' => 'btn btn-primary']) !!}
	</div>
</div>	