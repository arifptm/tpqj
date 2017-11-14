<script>
  
  /*
  * Edit Achievement - open form
  */

  $(document).on('click', '.edit-achievement', function() {    
    
    $('.modal-title').text('Edit kelulusan');
    $('.achievement-modal').attr('id','modal-update-achievement');

    $('#id').val($(this).data('id'));
    $('#achievement_date').val($(this).data('achievement_date'));
    $('#notes').val($(this).data('notes')); 
    

    var student_stage_id = $(this).data('stage_id')
    $("input[name='stage_id'][value='"+student_stage_id+"']").iCheck('check');                                 

    dt = ($(this).data('achievement_date')).split('-')      
    $('#acda_alt').val(dt[2]+'-'+dt[1]+'-'+dt[0]);
    var gc = $.calendars.instance('gregorian');
    var d = gc.newDate(
        parseInt(dt[2], 10),
        parseInt(dt[1], 10),
        parseInt(dt[0], 10)
      ).toJD();

    var gcn = $.calendars.instance('islamic').fromJD(d);
      $('#achievement_hijri_date').val(gcn.formatDate('dd-mm-yyyy'))
      $('#achida_alt').val(gcn.formatDate('yyyy-mm-dd')) 

    $('.modal-footer')
      .html("<button id='submit-update-achievement' class='btn btn-primary pull-left btn-lg'>Simpan</button><button class='btn btn-lg pull-left bg-olive' data-dismiss='modal'>Batal</button>")
    $('#modal-update-achievement').modal('show');     
  });
</script>



<script>
  
  /*
  * Edit Achievement - klik submit
  */

  $(document).on('click', '#submit-update-achievement', function() {    
    var form = $('#achievementForm')[0];
    var formData = new FormData(form);      
    $.ajax({
      type: 'post',
      url: '/admin/achievements/ajax/update',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: formData,
      type:"POST",
      contentType: false,
      processData: false,
      
      error: function(response){
        var msg = response.responseJSON.errors;
        $('#modalmessage').html(msg.stage_id).parent().slideDown();
      },

      success: function(response) {   

        $('#student_achievements').load('/data/student-achievements/'+sid);

        clearAchievementForm();
        
        $('#modal-update-achievement').modal('hide');
        $('#ajaxmessage').html('Data kelulusan <strong>' +response.achievement.student.fullname+ '</strong> (' +response.achievement.stage.name+ ') berhasil diperbarui.').parent().slideDown();  
      }
    });
  });
</script>


<script>
  /*
  ** Show modal to add new achievement
  */    

  $(document).on('click', '#btn-modal-create-achievement', function() {
    $('.modal-title').text('Tambah kelulusan');
    $('.achievement-modal').attr('id','modal-create-achievement');

    gcm = $.calendars.instance('gregorian','id').today();
    $('#achievement_date').val(gcm.formatDate('dd-mm-yyyy'))
    $('#acda_alt').val(gcm.formatDate('yyyy-mm-dd'))

    gch = $.calendars.instance('islamic','id').today();
    $('#achievement_hijri_date').val(gch.formatDate('dd-mm-yyyy'))      
    $('#achida_alt').val(gch.formatDate('yyyy-mm-dd'))
          
    $('.modal-footer')
      .html("<button id='submit-create-achievement' class='btn btn-primary pull-left btn-lg'>Simpan</button><button class='btn btn-lg pull-left bg-olive' data-dismiss='modal'>Batal</button>")
    $('#modal-create-achievement').modal('show');
  });
</script>

<script>
  /*
  ** Submit button: create achievement
  */ 
  $(document).on('click', '#submit-create-achievement', function() {
    
    var form = $('#achievementForm')[0];
    var formData = new FormData(form);
    $.ajax({
      url: '/admin/achievements/ajax/create',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: formData,
      type:"POST",
      contentType: false,
      processData: false,

      error: function(response){
        var msg = response.responseJSON.errors;
        $('#modalmessage').html(msg.stage_id).parent().slideDown();
      },

      success: function(response){
        $('#student_achievements').load('/data/student-achievements/'+sid);
        
        clearAchievementForm(); 

        $('#modal-create-achievement').modal('hide');
        $('#ajaxmessage').html('Data kelulusan <strong>' +response.achievement.student.fullname+ '</strong> (' +response.achievement.stage.name+ ') berhasil disimpan.').parent().slideDown();          
      }
    });
  });

</script>  


<script>
  /*
  ** Delete achievement
  */   
  $(document).on('click', '.btn-delete-achievement', function() {  
    if (confirm('Apakah anda yakin?')){
      $.ajax({
        type: 'post',
        url: '/admin/achievements/ajax/delete',
        data: {
          'id': ($(this).data('id')),
          '_token': $('input[name=_token]').val(),
        },

        error: function(data){
          $('#ajaxmessage').text('Maaf, ada masalah, silakan kontak admin').slideDown();
        },            
        
        success: function(data) {              
          $('#ajaxmessage').html(data.message).parent().slideDown();
          $('#student_achievements').load('/data/student-achievements/'+sid);
        }
      });
    }
  });
</script>


<script>
    /*
    ** Clear Form when modal closed && mode update
    */  
    $('.achievement-modal').on('hidden.bs.modal', function(){
      if ($(this).attr('id') == 'modal-update-achievement'){
        clearAchievementForm();
      }
    });

    function clearAchievementForm(){
      $('#achievementForm').find('input,select').not('[name=stage_id],[name=student_id]').val('');
      $('#achievementForm').find('[name=stage_id]').iCheck('uncheck')  
      $('#modalmessage').parent().hide();      
    }

</script>
