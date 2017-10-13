<script>    
  /*
   *
   * iCheck function
   *
   */
  $('input[type="checkbox"], input[type="radio"]').iCheck({
    checkboxClass: 'icheckbox_flat-purple',
    radioClass   : 'iradio_flat-purple'
  });

  $('#status').on('ifChecked', function(event){
    dt = new Date(); d = ('0'+(dt.getDate())).slice(-2); m = ('0'+(dt.getMonth()+1)).slice(-2); y = dt.getFullYear();
    $('#stop_date').val(y+'-'+m+'-'+d).parent().slideDown();
  });

  $('#status').on('ifUnchecked', function(event){
    $('#stop_date').val('').parent().slideUp();
  });

  $('.select2').select2();

  /*
   *
   * Image 
   *
   */
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

  /*
   *
   * Datatables
   *
   */
  $datatable = $('#persons-data').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth   : false,
    order: [ 0, "desc" ],
    ajax: '/data/persons',  
    columns: [
      { data: 'id', name: 'id', searchable: false },
      { data: 'formatted_registered_date', name: 'formatted_registered_date', searchable: false},         
      { data: 'name_href', name: 'name'}, 
      { data: 'institutions', name: 'mainInstitution.name'}, 
      { data: 'phone', name: 'phone', orderable: false},
      { data: 'status', name: 'status', searchable: false},
      { data: 'actions', name: 'actions', orderable: false, searchable: false}
    ],
    createdRow: function(row, data, index) {
      $(row).addClass('row'+data.id)
    }
    // initComplete: function () {
    // this.api().columns(['5']).every(function () {
    //     var column = this;
    //     var input = document.createElement("input");
    //     $(input).prependTo($(column.header()).prepend('<br>'))
    //     .on('change', function () {
    //         column.search($(this).val(), false, false, true).draw();
    //     });
    //   });
    // }
  }); 


  /*
   *
   * Create Person
   *
   */
  $('#btn-modal-create').click(function() {
    $('.shared-modal').attr('id','modal-create-person')
    $('#datatitle').text('Tambah data pengurus')

    var dt = new Date(); d = ('0'+(dt.getDate())).slice(-2); m = ('0'+(dt.getMonth()+1)).slice(-2); y = dt.getFullYear();      
    $("#registered_date").val(y+'-'+m+'-'+d);
    
    $('.status_wrapper, .stop_date_wrapper').hide();
          
    $('.modal-footer')
      .html("<button id='submit-create' class='btn btn-primary pull-left btn-lg'>Simpan</button><button class='btn btn-default' data-dismiss='modal'>Batal</button>")
    $('#modal-create-person').modal('show');
  });

  $('.modal-footer').on('click', '#submit-create', function(e) {      
    var form = $('#myForm')[0];
    var formData = new FormData(form);
    $.ajax({
      url: '/admin/persons/ajax/create',
      data: formData,
      type:"POST",
      contentType: false,
      processData: false,

      error: function(response){
        var msg = response.responseJSON.errors;
        msg.name ? $('.name').show().text(msg.name).parent().addClass('has-error') : $('.name').hide().parent().removeClass('has-error');
        msg.phone ? $('.phone').show().text(msg.phone).parent().addClass('has-error') : $('.phone').hide().parent().removeClass('has-error');
        msg.gender ? $('.gender').show().text(msg.gender).parent().addClass('has-error') : $('.gender').hide().parent().removeClass('has-error');
      },

      success: function(response){
        $('#persons-data').DataTable().ajax.reload();
        $('.name, .phone, .gender' ).hide().parent().removeClass('has-error');      
        $('#myForm').find('input,textarea,select').not('#dataimage, [name=gender],[name=status]').val('');
        $('#myForm').find('[name=gender],[name=status]').iCheck('uncheck')
        $('#dataimage').attr('src','/imagecache/medium_sq/default.jpg')  

        $('#modal-create-person').modal('hide');
        $('#ajaxmessage').html('Data pengurus <strong>' +response.name+ ' </strong> berhasil disimpan.').parent().slideDown();
        }
      });
    });



    /*
     *
     * Edit Person
     *
     */
    $(document).on('click', '#btn-modal-edit', function() {
      $("#status").removeAttr('name');
      $('.shared-modal').attr('id','modal-edit-person')
      $('#datatitle').text('Edit data pengurus')
      $("#id").val($(this).data('id'));      
      $("#name").val($(this).data('name'));
      $("#registered_date").val($(this).data('registered_date'));
      $("#address").val($(this).data('address'));
      $("#phone").val($(this).data('phone'));
      $("#stop_date").val($(this).data('stop_date'));
      $("#main_institution_id").val($(this).data('main_institution_id'));
      $("#extra_institution_id").val($(this).data('extra_institution_id'));

      $(".status_wrapper").show();
      if ($(this).data('stop_date') == ''){
        $("#status").iCheck('uncheck');
      } else {
        $("#status").iCheck('check');
      }

      if ($(this).data('gender') == 'L'){
        $("#male").iCheck('check');
      } else if ($(this).data('gender') == 'P'){
        $("#female").iCheck('check');
      }      

      if($(this).data('image')){
        $("#dataimage").attr('src', '/imagecache/medium_sq/' + $(this).data('image'));
      } else {
        $("#dataimage").attr('src', '/imagecache/medium_sq/default.jpg');
      }
      
      $('.modal-footer')
      .html("<button id='submit-update' class='btn btn-primary pull-left btn-lg'>Update</button><button class='btn btn-default' data-dismiss='modal'>Batal</button>")
      $('#modal-edit-person').modal('show');      
    });

    $('.modal-footer').on('click', '#submit-update', function() {    
      var form = $('#myForm')[0];
      var formData = new FormData(form);      
      $.ajax({
        type: 'post',
        url: '/admin/persons/ajax/update',
        data: formData,
        type:"POST",
        contentType: false,
        processData: false,
        
        error: function(response){
          var msg = response.responseJSON.errors;
          msg.name ? $('.name').show().text(msg.name).parent().addClass('has-error') : $('.name').hide().parent().removeClass('has-error');
          msg.gender ? $('.gender').show().text(msg.gender).parent().addClass('has-error') : $('.gender').hide().parent().removeClass('has-error');
          msg.phone ? $('.phone').show().text(msg.phone).parent().addClass('has-error') : $('.phone').hide().parent().removeClass('has-error');       
        },

        success: function(response) {   
          $('#persons-data').DataTable().ajax.reload();
          $('.name, .gender, .phone' ).hide().parent().removeClass('has-error');
          $('#myForm').find('input,textarea,select').not('#image, [name=gender],[name=status]').val('');
          $('#myForm').find('[name=gender],[name=status]').iCheck('uncheck');
          $('#dataimage').attr('src','/imagecache/medium_sq/default.jpg');
          $('#modal-edit-person').modal('hide');
          $('#ajaxmessage').html('Data pengurus <strong>' +response.name+ ' </strong> berhasil diperbarui.').parent().slideDown();
        }
      });
    });

    /*
     *
     * Delete Person
     *
     */
  $(document).on('click', '#btn-delete-person', function() {  
      if (confirm('Apakah anda yakin?')){
        $.ajax({
          type: 'post',
          url: '/admin/persons/ajax/delete',
          data: {
            'id': ($(this).data('id')),
            '_token': $('input[name=_token]').val(),
          },
          error: function(data){
            $('#ajaxmessage').text('Maaf, ada masalah, silakan kontak admin').slideDown().delay(2500).slideUp();                        
          },            
          success: function(data) {              
            $('#persons-data').DataTable().ajax.reload();
            $('#ajaxmessage').html('Data pengurus <strong>' +data.name+ ' </strong> berhasil dihapus.').parent().slideDown();
          }
        });
      }
    });    

  
    $('.shared-modal').on('hidden.bs.modal', function(){
      if ($(this).attr('id') == 'modal-edit-person'){
          $('#myForm').find('input,textarea,select').not('#image, [name=gender],[name=status]').val('');
          $('#myForm').find('[name=gender],[name=status]').iCheck('uncheck')
          $('#dataimage').attr('src','/imagecache/medium_sq/default.jpg')  
      }
    });

  </script>