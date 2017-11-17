<script>  

  //AJAX load block statistic
  $('#student-stat').load('/admin/data/block-student-statistic');

  //AJAX filtering by Institution
  $(document).on('ifChecked ifUnchecked', '[name="chosen_institution[]"]', function() {         
    var vins = institutionFilter()
    $datatable.ajax.url( '/data/students/'+vins+'/1_3'+'/1' ).load();            
  });

  //Datatable load from block Statistic
  $(document).on('click', '.class_group', function(){    
    var ins_id = $(this).data('ins_id')
    var class_group = $(this).data('id')
    var status = $(this).data('status')
    $datatable.ajax.url( '/data/students/'+ins_id+'/'+class_group+'/'+status).load(); 
  });



    $('#status').on('ifChecked', function(event){      
      dt = new Date(); d = ('0'+(dt.getDate())).slice(-2); m = ('0'+(dt.getMonth()+1)).slice(-2); y = dt.getFullYear();         
      $('#stop_date').val(y+'-'+m+'-'+d).parent().slideDown();
    });

    $('#status').on('ifUnchecked', function(event){
      $('#stop_date').val('').parent().slideUp();
    });

    $('#tpqd').on('ifChecked', function(event){      
      $('.job_wrapper label').text('Pekerjaan');
      $('.phone_wrapper label').text('No. telepon');
      $('.parent_wrapper').slideUp();
    });

    $('#tpqd').on('ifUnchecked', function(event){
      $('.job_wrapper label').text('Pekerjaan orang tua');
      $('.phone_wrapper label').text('No. telepon orang tua');
      $('.parent_wrapper').slideDown();
    });

    

    /*
     *
     * Create Student
     *
     */
    $('#btn-modal-create').click(function() {
      $('.shared-modal').attr('id','modal-create-student')
      $('#datatitle').text('Tambah data santri')

      var dt = new Date(); d = ('0'+(dt.getDate())).slice(-2); m = ('0'+(dt.getMonth()+1)).slice(-2); y = dt.getFullYear();      
      $("#registered_date").val(y+'-'+m+'-'+d);
      
      $('.status_wrapper, .stop_date_wrapper').hide();
            
      $('.modal-footer')
        .html("<button id='submit-create' class='btn btn-primary pull-left btn-lg'>Simpan</button><button class='btn btn-default' data-dismiss='modal'>Batal</button>")
      $('#modal-create-student').modal('show');
    });


    $('#image').change(function(){
      $(".image").empty();
      
      var file = this.files[0];
      var imagefile = file.type;
      var match= ["image/jpeg","image/png","image/jpg"];
      
      if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
      {
        $(".image").text("Foto harus dalam format jpeg, jpg atau png").show();
        return false;
      } else {
        var reader = new FileReader();  
        reader.onload = function (e) {
          $('#dataimage').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
      }
    });


    $('.modal-footer').on('click', '#submit-create', function(e) {      
      var form = $('#myForm')[0];
      var formData = new FormData(form);
      $.ajax({
        url: '/admin/students/ajax/create',
        data: formData,
        type:"POST",
        contentType: false,
        processData: false,

        error: function(response){
          var msg = response.responseJSON.errors;
          msg.fullname ? $('.fullname').show().text(msg.fullname).parent().addClass('has-error') : $('.fullname').hide().parent().removeClass('has-error');
          msg.nickname ? $('.nickname').show().text(msg.nickname).parent().addClass('has-error') : $('.nickname').hide().parent().removeClass('has-error');
          msg.institution_id ? $('.institution_id').show().text(msg.institution_id).parent().addClass('has-error') : $('.institution_id').hide().parent().removeClass('has-error');
          msg.gender ? $('.gender').show().text(msg.gender).parent().addClass('has-error') : $('.gender').hide().parent().removeClass('has-error');
          msg.group_id ? $('.group_id').show().text(msg.group_id).parent().addClass('has-error') : $('.group_id').hide().parent().removeClass('has-error');
        },

        success: function(response){
          $('#students-data').DataTable().ajax.reload();
          $('#student-stat').load('/admin/data/block-student-statistic');
          $('.fullname, .nickname, .institution_id, .gender, .group_id' ).hide().parent().removeClass('has-error');      
          $('#myForm').find('input,textarea,select').not('#image, [name=gender],[name=status],[name=group_id]').val('');
          $('#myForm').find('[name=gender],[name=status],[name=group_id]').iCheck('uncheck')
          $('#dataimage').attr('src','/imagecache/medium_sq/default.jpg')  
          
          $('#modal-create-student').modal('hide');
          $('#ajaxmessage').html('Data santri <strong>' +response.fullname+ ' </strong> berhasil disimpan.').parent().slideDown();          
        }
      });
    });



    /*
     *
     * Edit Student
     *
     */
    $(document).on('click', '#btn-modal-edit', function() {

      $("#status").removeAttr('name');

      $('.shared-modal').attr('id','modal-edit-student')
      $('#datatitle').text('Edit data santri')

      $("#id").val($(this).data('id'));

      $(".status_wrapper").show();
      if ($(this).data('stop_date') == ''){
        $("#status").iCheck('uncheck');
      } else {
        $("#status").iCheck('check');
      }
      
      $("#stop_date").val($(this).data('stop_date'));

      $("#registered_date").val($(this).data('registered_date'));
      $("#birth_date").val($(this).data('birth_date'));
      $("#birth_place").val($(this).data('birth_place'));
      $("#registration_number").val($(this).data('registration_number'));
      $("#institution_id").val($(this).data('institution_id'));
      $("#fullname").val($(this).data('fullname'));
      $("#nickname").val($(this).data('nickname'));
      $("#phone").val($(this).data('phone'));
      $("#address").val($(this).data('address'));      
      $("#parent").val($(this).data('parent'));
      $("#job").val($(this).data('job'));
      if ($(this).data('group') == 'tpqa'){
        $("#tpqa").iCheck('check');
      } else if ($(this).data('group') == 'tpqd'){
        $("#tpqd").iCheck('check');
      }
      if ($(this).data('gender') == 'L'){
        $("#male").iCheck('check');
      } else if ($(this).data('gender') == 'P'){
        $("#female").iCheck('check');
      }
      $("#tuition").val($(this).data('tuition'));
      $("#infrastructure_fee").val($(this).data('infrastructure_fee'));

      
        if($(this).data('image')){
          $("#dataimage").attr('src', '/imagecache/medium_sq/' + $(this).data('image'));
        } else {
          $("#dataimage").attr('src', '/imagecache/medium_sq/default.jpg');
        }
      $('.modal-footer')
      .html("<button id='submit-update' class='btn btn-primary pull-left btn-lg'>Update</button><button class='btn btn-default' data-dismiss='modal'>Batal</button>")
      $('#modal-edit-student').modal('show');
    });


    $('.modal-footer').on('click', '#submit-update', function() {    
      var form = $('#myForm')[0];
      var formData = new FormData(form);

      $.ajax({
        url: '/admin/students/ajax/update',
        data: formData,
        type:"POST",
        contentType: false,
        processData: false,

        error: function(response){
          var msg = response.responseJSON.errors;
          msg.fullname ? $('.fullname').show().text(msg.fullname).parent().addClass('has-error') : $('.fullname').hide().parent().removeClass('has-error');
          msg.nickname ? $('.nickname').show().text(msg.nickname).parent().addClass('has-error') : $('.nickname').hide().parent().removeClass('has-error');
          msg.institution_id ? $('.institution_id').show().text(msg.institution_id).parent().addClass('has-error') : $('.institution_id').hide().parent().removeClass('has-error');
          msg.gender ? $('.gender').show().text(msg.gender).parent().addClass('has-error') : $('.gender').hide().parent().removeClass('has-error');
          msg.group_id ? $('.group_id').show().text(msg.group_id).parent().addClass('has-error') : $('.group_id').hide().parent().removeClass('has-error');
        },

        success: function(response){
          $('.fullname, .nickname, .institution_id, .gender, .group_id' ).hide().parent().removeClass('has-error');      
          $('#myForm').find('input,textarea,select').not('#image, [name=gender],[name=status],[name=group_id]').val('');
          $('#myForm').find('[name=gender],[name=status],[name=group_id]').iCheck('uncheck')
          $('#dataimage').attr('src','/imagecache/medium_sq/default.jpg')  
          $('#students-data').DataTable().ajax.reload();

          $('#modal-edit-student').modal('hide');
          $('#ajaxmessage').html('Data santri <strong>' +response.fullname+ ' </strong> berhasil diperbarui.').parent().slideDown();
          $('#students-data').DataTable().ajax.reload();
        }

      });

    });

    /*
     *
     * Delete Student
     *
     */
    $(document).on('click', '#btn-delete-student', function() {  
      if (confirm('Apakah anda yakin?')){
        $.ajax({
          type: 'post',
          url: '/admin/students/ajax/delete',
          data: {
            'id': ($(this).data('id')),
            '_token': $('input[name=_token]').val(),
          },

          error: function(data){
          $('#ajaxmessage').text('Maaf, ada masalah, silakan kontak admin').slideDown();            
          },            
          
          success: function(data) {              
            $('#ajaxmessage').html(data.message).parent().slideDown();
            $('#students-data').DataTable().ajax.reload();
            $('#student-stat').load('/admin/data/block-student-statistic');

          }
        });
      }
    });
  
    $('.shared-modal').on('hidden.bs.modal', function(){
      if ($(this).attr('id') == 'modal-edit-student'){
          $('#myForm').find('input,textarea,select').not('#image, [name=gender],[name=status],[name=group_id]').val('');
          $('#myForm').find('[name=gender],[name=status],[name=group_id]').iCheck('uncheck')
          $('#dataimage').attr('src','/imagecache/medium_sq/default.jpg')  
      }
    });

  </script>

<script>
    function institutionFilter(){
      var ins = new Array;
      $('[name="chosen_institution[]"]:checked').each ( function() {
        ins.push ( $(this).val() );
      });
      if ( ins.length == 0 ){ vins = '0' } else { vins = ins.join('_')}
      return vins;
    };

    </script>