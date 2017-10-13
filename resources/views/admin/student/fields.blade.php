<div class="box-body">
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				{!! Form::label('registration_number', 'Nomor induk', ['class'=>'control-label']) !!}
				{!! Form::text('registration_number', null, ['class' => 'form-control', 'id'=>'registration_number']) !!}
				<div class="help-block registration_number" style="display:none" ></div>
			</div>	
			<div class="form-group">
				@if (isset($student->image))
					<img filename="{{ $student->image }}" src="/imagecache/medium_sq/{{ $student->image }}" alt="" class="img-responsive img-circle" id="dataimage">
				@else
					<img filename="default.jpg" src="/imagecache/medium_sq/default.jpg" alt="" class="img-responsive img-circle " id="dataimage">
				@endif
			</div>
			<div class="form-group">
				{!! Form::label('image', 'Upload Foto', ['class'=>'btn btn-primary btn-block']) !!}
				{!! Form::file('image' , ['id'=>'image', 'class'=>'hidden']) !!}
				<div class="help-block image" style='display:none'></div>				
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('registered_date', 'Tanggal terdaftar', ['class'=>'control-label']) !!}
				{!! Form::date('registered_date', null, ['class' => 'form-control', 'id'=>'registered_date']) !!}
				<div class="help-block registered_date" style="display:none"></div>
			</div>
			<div class="form-group">
				{!! Form::label('birth_date', 'Tanggal lahir', ['class'=>'control-label']) !!}
				{!! Form::date('birth_date', null, ['class' => 'form-control', 'id'=>'birth_date']) !!}
				<div class="help-block birth_date" style="display:none"></div>
			</div>			
			<div class="form-group">
				{!! Form::label('birth_place', 'Tempat lahir', ['class'=>'control-label']) !!}
				{!! Form::text('birth_place', null, ['class' => 'form-control', 'id'=>'birth_place']) !!}
				<div class="help-block birth_place" style="display:none"></div>
			</div>			
			<div class="form-group">
				{!! Form::label('institution_id', 'Lembaga', ['class'=>'control-label']) !!}
				@if(count($institutions) == 1)
					{!! Form::select('institution_id', $institutions, false, ['class' => 'form-control', 'id'=>'institution_id']) !!}				
				@else
					{!! Form::select('institution_id',array('' => '-Silakan Pilih-') + $institutions, false, ['class' => 'form-control', 'id'=>'institution_id']) !!}				
				@endif
				<div class="help-block institution_id" style='display:none'></div>
			</div>

		</div>
		<div class="col-md-5">
			
			<div class="form-group icheck">				
				{!! Form::label('Jenis kelamin') !!}<br>
				{!! Form::radio('gender', 'L', false,  ['class' => 'form-control', 'id'=>'male']) !!}
				{!! Form::label('male', 'Laki-laki', ['class'=>'control-label']) !!}<br>
				{!! Form::radio('gender', 'P', false, ['class' => 'form-control', 'id'=>'female']) !!}
				{!! Form::label('female', 'Perempuan', ['class'=>'control-label']) !!}				
				<br>
				<div class="help-block gender" style='display:none'></div>
			</div>	
			<div class="form-group icheck">				
				{!! Form::label('Kelompok') !!}<br>
				@foreach($groups as $group)
					{!! Form::radio('group_id', $group->id, false,  ['class' => 'form-control', 'id'=>strtolower($group->name)]) !!}
					{!! Form::label( strtolower($group->name), $group->name , ['class'=>'control-label']) !!}<br>
				@endforeach
				<br>
				<div class="help-block  group_id" style='display:none'></div>
			</div>			
			<div class="form-group icheck status_wrapper">				
				{!! Form::checkbox('status', null, false,  ['class' => 'form-control', 'id'=>'status']) !!}
				{!! Form::label('datastatus', 'Non Aktif', ['class'=>'control-label']) !!}
			</div>
			<div class="form-group stop_date_wrapper" style="display:none;">
				{!! Form::label('datastop_date', 'Mulai tanggal:', ['class'=>'control-label']) !!}
				{!! Form::date('stop_date', null, ['class' => 'form-control', 'id'=>'stop_date']) !!}
			</div>					
		</div>
	</div>

	<hr>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('fullname', 'Nama lengkap', ['class'=>'control-label']) !!}
				{!! Form::text('fullname', null, ['class' => 'form-control', 'id'=>'fullname']) !!}
				<div class="help-block  fullname" style="display:none"></div>
			</div>
			<div class="form-group">
				{!! Form::label('nickname', 'Nama panggilan', ['class'=>'control-label']) !!}
				{!! Form::text('nickname', null, ['class' => 'form-control', 'id'=>'nickname']) !!}
				<div class="help-block  nickname" style="display:none"></div>
			</div>
			<div class="form-group parent_wrapper">
				{!! Form::label('parent', 'Nama orang tua', ['class'=>'control-label']) !!}
				{!! Form::text('parent', null, ['class' => 'form-control', 'id'=>'parent']) !!}
				<div class="help-block parent" style="display:none"></div>
			</div>			
			<div class="form-group">
				{!! Form::label('address', 'Alamat', ['class'=>'control-label']) !!}
				{!! Form::textarea('address', null, ['class' => 'form-control', 'id'=>'address', 'rows'=>'2']) !!}
				<div class="help-block address" style="display:none"></div>
			</div>	
		</div>
		
		<div class="col-md-6">
			<div class="form-group job_wrapper">
				{!! Form::label('job', 'Pekerjaan orang tua', ['class'=>'control-label']) !!}
				{!! Form::text('job', null, ['class' => 'form-control', 'id'=>'job']) !!}
				<div class="help-block job" style="display:none"></div>
			</div>						
			<div class="form-group phone_wrapper">
				{!! Form::label('phone', 'Telepon', ['class'=>'control-label']) !!}
				{!! Form::number('phone', null, ['class' => 'form-control', 'id'=>'phone']) !!}
				<div class="help-block phone" style="display:none"></div>
			</div>			
			<div class="form-group">
				{!! Form::label('tuition', 'Syahriyah', ['class'=>'control-label']) !!}
				{!! Form::number('tuition', null, ['class' => 'form-control', 'id'=>'tuition']) !!}
				<div class="help-block tuition" style="display:none"></div>
			</div>		
			<div class="form-group">
				{!! Form::label('infrastructure_fee', 'Uang gedung ', ['class'=>'control-label']) !!}
				{!! Form::number('infrastructure_fee', null, ['class' => 'form-control', 'id'=>'infrastructure_fee']) !!}
				<div class="help-block infrastructure_fee" style="display:none"></div>
			</div>					
		</div>
	</div>
</div>
{!! Form::hidden('id', null, ['id'=>'id']) !!}
