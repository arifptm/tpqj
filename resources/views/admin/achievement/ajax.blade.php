<script>
    $('input[type="checkbox"], input[type="radio"]').iCheck({
      checkboxClass: 'icheckbox_flat-purple',
      radioClass   : 'iradio_flat-purple'
    });

    $('.select2').select2();
    
    $('.datepicker').datepicker({      
      language: 'id',
      autoclose: true,
      todayHighlight:true,
      format: 'dd-mm-yyyy'
    });

    $('#achievement-stat').load('/admin/data/block-achievement-statistic');


    /*
     *
     * Create Achievement
     *
     */
    $('#btn-modal-create').click(function() {      
      $('#datatitle').text('Tambah Kelulusan');               

      $('.shared-modal').attr('id','modal-create-achievement');

      var dt = new Date(); d = ('0'+(dt.getDate())).slice(-2); m = ('0'+(dt.getMonth()+1)).slice(-2); y = dt.getFullYear();        
      $("#achievement_date").val(d+'-'+ m +'-'+y);      
            
      $('.modal-footer')
        .html("<button id='submit-create' class='btn btn-primary pull-left btn-lg'>Simpan</button><button class='btn btn-lg pull-left bg-olive' data-dismiss='modal'>Batal</button>")
      $('#modal-create-achievement').modal('show');
    });

    $('.modal-footer').on('click', '#submit-create', function(e) {      
      var form = $('#myForm')[0];
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

          $('#achievements-data').DataTable().ajax.reload();
          $('#achievement-stat').load('/admin/data/block-achievement-statistic');
          //location.reload();
          // $('.fullname, .nickname, .institution_id, .gender, .group_id' ).hide().parent().removeClass('has-error');      
          clearForm();          
          $('#modal-create-achievement').modal('hide');
          $('#ajaxmessage').html('Data kelulusan <strong>' +response.achievement.student.fullname+ '</strong> (' +response.achievement.stage.name+ ') berhasil disimpan.').parent().slideDown();          
        }
      });
    });


    /*
     *
     * Edit Achievement
     *
     */
    $(document).on('click', '#btn-modal-edit', function() {      
      $('.shared-modal').attr('id','modal-edit-achievement')
      $('#datatitle').text('Edit data prestasi')

      $('#id').val($(this).data('id'));      
      
      $('#achievement_date').val($(this).data('achievement_date'));

      $('#student_id').val($(this).data('student_id')).trigger("change");
      var tr_value = $(this).data('stage_id')
      $('input[name="stage_id"][value='+tr_value+']').iCheck('check');
      
      $('.modal-footer')
      .html("<button id='submit-update' class='btn btn-primary pull-left btn-lg'>Update</button><button class='btn btn-lg pull-left bg-olive' data-dismiss='modal'>Batal</button>")
      $('#modal-edit-achievement').modal('show');      
    });


    $('.modal-footer').on('click', '#submit-update', function() {    
      var form = $('#myForm')[0];
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
          $('#achievements-data').DataTable().ajax.reload();
          $('#achievement-stat').load('/admin/data/block-achievement-statistic');
          clearForm();
          
          $('#modal-edit-achievement').modal('hide');
          $('#ajaxmessage').html('Data kelulusan <strong>' +response.achievement.student.fullname+ '</strong> (' +response.achievement.stage.name+ ') berhasil diperbarui.').parent().slideDown();  
        }
      });
    });






/*
     *
     * Delete Achievement
     *
     */
    $(document).on('click', '#btn-delete-achievement', function() {  
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
            //$('#students-data').DataTable().ajax.reload();
            location.reload();
          }
        });
      }
    });
  
    $('.shared-modal').on('hidden.bs.modal', function(){
      if ($(this).attr('id') == 'modal-edit-achievement'){
        clearForm();
      }
    });

    function clearForm(){
      $('#myForm').find('input,select').not('[name=stage_id]').val('');
      $('#myForm .select2').val(null).trigger("change");
      $('#myForm').find('[name=stage_id]').iCheck('uncheck')  
      $('#modalmessage').parent().hide();      
    }

  </script>