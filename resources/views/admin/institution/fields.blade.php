
<div class="box-body">
	<div class="row">
		<div class="col-md-12">	

			<div class="form-group">
				{!! Form::label('established_date', 'Tanggal Berdiri', ['class'=>'control-label']) !!}
				{!! Form::date('established_date', null, ['class' => 'form-control']) !!}
				@if ($errors->has('established_date'))
				    <div class="label label-danger">
				        {{ $errors->first('established_date') }}
				    </div>
				@endif
			</div>

			<div class="form-group">
				{!! Form::label('name', 'Nama Lembaga', ['class'=>'control-label']) !!}
				{!! Form::text('name', null, ['class' => 'form-control']) !!}
				@if ($errors->has('name'))
				    <div class="label label-danger">
				        {{ $errors->first('name') }}
				    </div>
				@endif
			</div>

			<div class="form-group">
				{!! Form::label('region_id', 'Wilayah TPQ',['class'=>'control-label']) !!}
				{!! Form::select('region_id', $regions, null, ['class' => 'form-control']) !!}
				@if ($errors->has('region_id'))
				    <div class="label label-danger">
				        {{ $errors->first('region_id') }}
				    </div>
				@endif
			</div>			

			<div class="form-group">
				{!! Form::label('headmaster', 'Kepala TPQ',['class'=>'control-label']) !!}
				{!! Form::select('headmaster', $persons, null, ['class' => 'form-control']) !!}
				@if ($errors->has('headmaster'))
				    <div class="label label-danger">
				        {{ $errors->first('headmaster') }}
				    </div>
				@endif
			</div>

			<div class="form-group">
				{!! Form::label('address', 'Alamat', ['class'=>'control-label']) !!}
				{!! Form::textarea('address', null, ['class' => 'form-control', 'rows'=>'2']) !!}
				@if ($errors->has('address'))
				    <div class="label label-danger">
				        {{ $errors->first('address') }}
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