<div class="box-body">
			<div class="form-group">
				{!! Form::label('achievement_date', 'Tanggal ujian:', ['class'=>'control-label']) !!}
				<div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>                  
                  {!! Form::text('achievement_date', null, ['class' => 'form-control date datepicker pull-right', 'id'=>'achievement_date']) !!}
                </div>								
				<div class="help-block achievement_date" style="display:none"></div>
			</div>

			<div class="form-group">
				{!! Form::label('student_id', 'Nama santri:', ['class'=>'control-label']) !!}
				{!! Form::select('student_id', ['' => '-Silakan Pilih-'] + $students ,false, ['class' => 'form-control select2', 'id'=>'student_id','style'=>'width: 100%;']) !!}
				<div class="help-block student_id" style="display:none"></div>
			</div>

			<div class="form-group icheck">				
				<div class="row">
				{!! Form::label('Tingkat/jilid::') !!}<br>
				@foreach ($stages->chunk(7) as $chunk)
					<div class="col-md-4">
					@foreach ($chunk as $stage)
						{!! Form::radio('stage_id', $stage->id, false,  ['id'=>$stage->slug]) !!}
						{!! Form::label( $stage->slug, $stage->name , ['class'=>'control-label']) !!}<br>					
					@endforeach
					</div>
				@endforeach
				<div class="help-block stage_id" style="display:none"></div>
			</div></div>
			
			<div class="form-group">
				{!! Form::label('notes', 'Keterangan:', ['class'=>'control-label']) !!}
				{!! Form::text('notes', null, ['class' => 'form-control', 'id'=>'notes']) !!}
				<div class="help-block notes" style="display:none"></div>
			</div>				

</div>
{!! Form::hidden('id', null, ['id'=>'id']) !!}
