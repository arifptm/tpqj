   <div class="modal fade" id="achievement-modal" role="dialog">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header bg-blue">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Edit kelulusan</h4>
            </div>   
               <div class="modal-body">
                  <form id='myForm' role='form' >         
                     <div class="box-body">
                              <div class="form-group">
                                 {!! Form::label('achievement_date', 'Tanggal:', ['class'=>'control-label']) !!}
                                 <div class="input-group date">
                                       <div class="input-group-addon">
                                         <i class="fa fa-calendar"></i>
                                       </div>                  
                                       {!! Form::text('achievement_date', null, ['class' => 'form-control date datepicker pull-right', 'id'=>'achievement_date']) !!}
                                     </div>                       
                                 <div class="help-block achievement_date" style="display:none"></div>
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
                              {!! Form::hidden('student_id', $student->id) !!}
                     </div>
                  </form> 
               </div>   
               <div class="modal-footer bg-blue">
                  <button id='submit-edit-achievement' class='btn btn-primary pull-left btn-lg'>Simpan</button>
                  <button class='btn btn-default bg-olive btn-lg' data-dismiss='modal'>Batal</button>
               </div>            
         </div>
      </div>
   </div>