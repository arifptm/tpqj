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
                              {!! Form::hidden('id',null,['id'=>'id']) !!}
                              {!! Form::hidden('student_id',null,['id'=>'student_id']) !!}
                     </div>
                  </form> 
               </div>   
               <div class="modal-footer bg-blue">
                  <button id='submit-edit-achievement' class='btn btn-primary pull-left btn-lg'>Simpan</button>
                  <button class='btn pull-left bg-olive btn-lg' data-dismiss='modal'>Batal</button>
               </div>            
         </div>
      </div>
   </div>