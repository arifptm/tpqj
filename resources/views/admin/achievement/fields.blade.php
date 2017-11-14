<div class="box-body">
	
	<div class="form-group">
		{!! Form::label('student_id', 'Nama santri:', ['class'=>'control-label']) !!}
		{!! Form::select('student_id', ['' => '-Silakan Pilih-'] + $students ,false, ['class' => 'form-control select2', 'id'=>'student_id','style'=>'width: 100%;']) !!}
		<div class="help-block err student_id" style="display:none"></div>
	</div>

	<div class="form-group">
		<div class='row'>
			<div class='col-md-6'>
				{!! Form::label('achievement_date', 'Tanggal ujian (Masehi):', ['class'=>'control-label']) !!}
				<div class="input-group">                  
                  	{!! Form::text('achievement_date', null, ['class' => 'form-control', 'id'=>'achievement_date']) !!}
                  	{!! Form::hidden('acda_alt', null, ['id'=>'acda_alt']) !!}
                </div>		
            </div>	
            <div class='col-md-6'>
            	{!! Form::label('achievement_hijri_date', 'Tanggal ujian (Hijriah):', ['class'=>'control-label']) !!}
				<div class="input-group">
	                {!! Form::text('achievement_hijri_date', null, ['class' => 'form-control', 'id'=>'achievement_hijri_date']) !!}
	                {!! Form::hidden('achida_alt', null, [ 'id'=>'achida_alt']) !!}
		        </div>
            </div>	            
            <div class='col-md-12'>				
				<div class="help-block err achievement_date" style="display:none"></div>
			</div>
		</div>
	</div>



	<div class="form-group icheck">				
		<div class="row">
			<div class="col-md-12">
				{!! Form::label('Tingkat/jilid::') !!}
			</div>
			@foreach ($stages->chunk(7) as $chunk)
				<div class="col-md-4">
				@foreach ($chunk as $stage)
					{!! Form::radio('stage_id', $stage->id, false,  ['id'=>$stage->slug]) !!}
					{!! Form::label( $stage->slug, $stage->name , ['class'=>'control-label']) !!}<br>					
				@endforeach
				</div>
			@endforeach
			<div class="help-block err stage_id" style="display:none"></div>
		</div>
	</div>
			
	<div class="form-group">
		{!! Form::label('notes', 'Keterangan:', ['class'=>'control-label']) !!}
		{!! Form::text('notes', null, ['class' => 'form-control', 'id'=>'notes']) !!}
	</div>				
	{!! Form::hidden('id', null, ['id'=>'id']) !!}
</div>