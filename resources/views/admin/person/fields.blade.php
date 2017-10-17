<div class="box-body">
	<div class="row">		
		<div class="col-md-3">	
			<div class="form-group">
				{!! Form::label('registration_number', 'Nomor Induk:', ['class'=>'control-label']) !!}
				{!! Form::text('registration_number', null, ['class' => 'form-control', 'id'=>'registration_number']) !!}
				<div class="help-block registration_number" style="display:none" ></div>
			</div>		
			<div class="form-group">
				@if (isset($person->image))
					<img filename="{{ $person->image }}" src="/imagecache/medium_sq/{{ $person->image }}" alt="" class="img-responsive img-circle" id="dataimage">
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
				{!! Form::label('registered_date', 'Terdaftar Tanggal:', ['class'=>'control-label']) !!}
				{!! Form::date('registered_date', null, ['class' => 'form-control', 'id'=>'registered_date']) !!}
			</div>

			<div class="form-group">
				{!! Form::label('name', 'Nama Lengkap:', ['class'=>'control-label' ]) !!}
				{!! Form::text('name', null, ['class' => 'form-control','id'=>'name']) !!}
				<div class="help-block name" style='display:none'></div>			
			</div>

			<div class="form-group">
				{!! Form::label('address', 'Alamat:', ['class'=>'control-label']) !!}
				{!! Form::textarea('address', null, ['class' => 'form-control', 'rows' => '2', 'id'=>'address']) !!}
				<div class="help-block address" style='display:none'></div>
			</div>						

			<div class="form-group">
				{!! Form::label('phone', 'Telepon:',['class'=>'control-label']) !!}
				{!! Form::number('phone', null, ['class' => 'form-control', 'id'=>'phone']) !!}
				<div class="label label-danger e phone hidden"></div>			
			</div>

		</div>

		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('main_institution_id', 'Lembaga Utama:',['class'=>'control-label']) !!}
				@if (count($filtered_institutions) == 1)
					{!! Form::select('main_institution_id', $filtered_institutions, null, ['class' => 'form-control select2', 'id'=>'main_institution_id', 'style'=>'width:100%']) !!}
				@else
					{!! Form::select('main_institution_id', array('' => '-Silakan Pilih-') + $filtered_institutions, null, ['class' => 'form-control select2', 'id'=>'main_institution_id', 'style'=>'width:100%']) !!}
				@endif
				
				<div class="help-block main_institution_id" style='display:none'></div>
			</div>
			
			<div class="form-group">
				{!! Form::label('extra_institution_id', 'Lembaga Tambahan:',['class'=>'control-label']) !!}
				{!! Form::select('extra_institution_id[]', $all_institutions, null, ['class' => 'form-control select2', 'id'=>'extra_institution_id', 'multiple'=>'multiple', 'data-placeholder'=>'-Pilih, jika ada-' ,'style'=>'width:100%']) !!}
				<div class="help-block extra_institution_id" style='display:none'></div>		
			</div>

			<div class="form-group icheck">				
				{!! Form::label('Jenis Kelamin:') !!}<br>
				{!! Form::radio('gender', 'L', false,  ['class' => 'form-control', 'id'=>'male']) !!}
				{!! Form::label('male', 'Laki-laki', ['class'=>'control-label']) !!}<br>
				{!! Form::radio('gender', 'P', false, ['class' => 'form-control', 'id'=>'female']) !!}
				{!! Form::label('female', 'Perempuan', ['class'=>'control-label']) !!}				
				<br>
				<div class="help-block gender" style='display:none'></div>
			</div>	
				
			<div class="form-group icheck status_wrapper" style="display:none;">				
				{!! Form::checkbox('status', null, false,  ['class' => 'form-control', 'id'=>'status']) !!}
				{!! Form::label('status', 'Non Aktif', ['class'=>'control-label']) !!}
			</div>
		
			<div class="form-group stop_date_wrapper" style="display:none;">
				{!! Form::label('stop_date', 'Mulai tanggal:', ['class'=>'control-label']) !!}
				{!! Form::date('stop_date', null, ['class' => 'form-control', 'id'=>'stop_date']) !!}
			</div>	
		</div>

	</div>
</div>			
{!! Form::hidden('id',null, ['id'=>'id'] ) !!}