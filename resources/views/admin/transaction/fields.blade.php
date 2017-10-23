<div class="box-body">
	<div class="row">	
		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('transaction_date', 'Tanggal transaksi:', ['class'=>'control-label']) !!}
				<div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>                  
                  {!! Form::text('transaction_date', null, ['class' => 'form-control date datepicker pull-right', 'id'=>'transaction_date']) !!}
                </div>								
				<div class="help-block err transaction_date" style="display:none"></div>
			</div>


			<div class="form-group icheck">				
				{!! Form::label('Jenis Transaksi:') !!}<br>
				@foreach ($t_types as $t_type)
					{!! Form::radio('transaction_type_id', $t_type->id, false,  ['id'=>$t_type->slug]) !!}
					{!! Form::label( $t_type->slug, $t_type->name , ['class'=>'control-label']) !!}<br>
				@endforeach
				<div class="help-block err transaction_type_id" style='display:none'></div>
			</div>	

			<div class="form-group tuition_month_wrapper" style='display:none'>				
				{!! Form::label('tuition_month', 'SPP bulan...:', ['class'=>'control-label']) !!}
				<div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>                  
                  {!! Form::text('tuition_month', null, ['class' => 'form-control date monthpicker pull-right', 'id'=>'tuition_month']) !!}
                </div>								
				<div class="help-block err tuition_month" style="display:none"></div>
				<div class="help-block err tuition_month_ymd" style="display:none"></div>
				{!! Form::hidden('tuition_month_ymd', null,['id'=>'tuition_month_ymd']) !!}
			</div>						

		</div>
		
		<div class="col-md-6">			
			<div class="form-group student_id_wrapper">
				{!! Form::label('student_id', 'Nama:', ['class'=>'control-label']) !!}
				{!! Form::select('student_id', ['' => '-Silakan Pilih-'] + $students ,false, ['class' => 'form-control select2', 'id'=>'student_id','style'=>'width: 100%;']) !!}
				<div class="help-block err student_id" style="display:none"></div>
			</div>

			<div class="form-group icheck class_group_id_wrapper">				
				{!! Form::label('Pemilik dana:') !!}<br>
				@foreach ($class_groups as $c_group)
					{!! Form::radio('class_group_id', $c_group->id, false,  ['id'=>$c_group->slug]) !!}
					{!! Form::label( $c_group->slug, $c_group->description , ['class'=>'control-label']) !!}<br>
				@endforeach
				<div class="help-block err class_group_id" style='display:none'></div>
			</div>	


			<div class="form-group">
				{!! Form::label('amount', 'Jumlah:', ['class'=>'control-label']) !!}
				{!! Form::text('amount', null, ['class' => 'form-control', 'id'=>'amount']) !!}
				<div class="help-block err amount" style="display:none"></div>
			</div>
			<div class="form-group">
				{!! Form::label('notes', 'Keterangan:', ['class'=>'control-label']) !!}
				{!! Form::text('notes', null, ['class' => 'form-control', 'id'=>'notes']) !!}
			</div>
				
		</div>
	</div>

</div>
{!! Form::hidden('id', null, ['id'=>'id']) !!}
{!! Form::hidden('credit', null, ['id'=>'credit']) !!}
