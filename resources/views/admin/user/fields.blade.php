
<div class="box-body">
	<div class="row">
		@if(\Request::is('manage/users/*/edit'))
		<div class="col-md-4">
			<div class="form-group">
				<img src="/images/profiles/b/{{ $user->userProfile->image }}" alt="" class="img-responsive img-circle profile-user-img" >
			</div>
		</div>
		
		<div class="col-md-8">
		@else
		<div class="col-md-12">
		@endif
			<div class="form-group">
				{!! Form::label('image', 'Upload Foto', ['class'=>'btn btn-primary']) !!}
				{!! Form::file('image' , ['class' => 'hidden', 'onchange' => "$('#upload-file-info').html(this.files[0].name)"]) !!}
				@if ($errors->has('image'))
				    <div class="label label-danger">
				        {{ $errors->first('image') }}
				    </div>
				@endif
			<span class='label label-info' id="upload-file-info"></span>
			</div>

		
			<div class="form-group">
				{!! Form::label('name', 'Name', ['class'=>'control-label']) !!}
				{!! Form::text('name', null, ['class' => 'form-control']) !!}
				@if ($errors->has('name'))
				    <div class="label label-danger">
				        {{ $errors->first('name') }}
				    </div>
				@endif
			</div>

			<div class="form-group">
				{!! Form::label('email', 'Email',['class'=>'control-label']) !!}
				{!! Form::text('email', null, ['class' => 'form-control']) !!}
				@if ($errors->has('email'))
				    <div class="label label-danger">
				        {{ $errors->first('email') }}
				    </div>
				@endif
			</div>

		 	@can('manage-users')
		 	<div class="form-group">  
			    <div class="icheck">
			        {!! Form::checkbox('verified') !!} 
			        {!! Form::label('verified', 'Aktif',['class'=>'control-label']) !!}             
			    </div>
			</div>
			@endcan
		</div>
	</div>
</div>

<div class="box-footer">
	<div class="form-group">
		{!! Form::submit('Simpan',  ['class' => 'btn btn-primary']) !!}
	</div>
</div>	