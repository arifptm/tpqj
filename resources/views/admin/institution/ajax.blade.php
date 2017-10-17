<script>
    $('input[type="checkbox"], input[type="radio"]').iCheck({
      checkboxClass: 'icheckbox_flat-purple',
      radioClass   : 'iradio_flat-purple'
    });
    
    $('.select2').val("").select2({
      placeholder: "-Silakan Pilih-",
    });
    
    $('.datepicker').datepicker({      
      language: 'id',
      autoclose: true,
      todayHighlight:true,
      format: 'dd-mm-yyyy'
    });   

</script>


<script>
    /*
     *
     * Create Institution
     *
     */
    $('#btn-modal-create').click(function() {
      $('.shared-modal').attr('id','modal-create-institution')
      $('#datatitle').text('Tambah Lembaga')

      var dt = new Date(); d = ('0'+(dt.getDate())).slice(-2); m = ('0'+(dt.getMonth()+1)).slice(-2); y = dt.getFullYear();      
      $("#established_date").val(d+'-'+m+'-'+y);
            
      $('.modal-footer')
        .html("<button id='submit-create' class='btn btn-primary pull-left btn-lg'>Simpan</button><button class='btn bg-olive pull-left btn-lg' data-dismiss='modal'>Batal</button>")
      $('#modal-create-institution').modal('show');
    });

  $('.modal-footer').on('click', '#submit-create', function(e) {      
    var form = $('#myForm')[0];
    var formData = new FormData(form);
    $.ajax({
      url: '/admin/institutions/ajax/create',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: formData,
      type:"POST",
      contentType: false,
      processData: false,

      error: function(response){
        var msg = response.responseJSON.errors;
        // msg.name ? $('.name').show().text(msg.name).parent().addClass('has-error') : $('.name').hide().parent().removeClass('has-error');
      },

      success: function(response){
        var count = +($('#institution_count').text());
        $('#institution_count').text(count+1);

        $('#table-institution tr:first').after('<tr id="row-'+response.new.id+'"><td class="hidden-xs">'+response.new.id+'</td><td class="hidden-xs">'+response.e_date_dmy+'</td><td><a href="/admin/institutions/'+response.new.slug+'"><strong>'+response.new.name+'</strong></a></td><td class="hidden-xs">'+response.new.theheadmaster.name+'</td><td>'+response.new.region.name+'</td><td class="hidden-xs">'+response.new.region.region_group.groupname+'</td><td><div class="btn-group"><button id="btn-modal-edit" class="btn btn-default btn-xs" data-id="'+response.new.id+'" data-established_date="'+response.e_date_dmy+'" data-name="'+response.new.name+'" data-region_id="'+response.new.region_id+'" data-headmaster="'+response.new.headmaster+'" data-address="'+response.new.address+'"><i class="glyphicon glyphicon-edit"></i></button><button id="btn-delete-institution" class="btn btn-danger btn-xs" data-id="'+response.new.id+'"><i class="glyphicon glyphicon-trash"></i></button></div></td></tr>');

        $('#modal-create-institution').modal('hide');
        $('#ajaxmessage').html('Data lembaga <strong>' +response.new.name+ ' </strong> berhasil disimpan.').parent().slideDown();
        }
      });
    });    
</script>



<script>
    /*
     *
     * Edit Institution
     *
     */
    $(document).on('click', '#btn-modal-edit', function() {      
      $('.shared-modal').attr('id','modal-edit-institution')
      $('#datatitle').text('Edit data lembaga')

      $("#id").val($(this).data('id'));      
      
      $("#established_date").val($(this).data('established_date'));
      $("#name").val($(this).data('name'));
      $("#region_id").val($(this).data('region_id'));
      $("#headmaster").val($(this).data('headmaster')).select2();
      $("#address").val($(this).data('address'));      
      
      $('.modal-footer')
      .html("<button id='submit-update' class='btn btn-primary pull-left btn-lg'>Update</button><button class='btn btn-lg bg-olive' data-dismiss='modal'>Batal</button>")
      $('#modal-edit-institution').modal('show');
    });

    $('.modal-footer').on('click', '#submit-update', function() {    
      var form = $('#myForm')[0];
      var formData = new FormData(form);      
      $.ajax({
        type: 'post',
        url: '/admin/institutions/ajax/update',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },        
        data: formData,
        type:"POST",
        contentType: false,
        processData: false,
        
        error: function(response){
          var msg = response.responseJSON.errors;
          // msg.name ? $('.name').show().text(msg.name).parent().addClass('has-error') : $('.name').hide().parent().removeClass('has-error');
        },

        success: function(response) {   
          $('#row-'+response.new.id).replaceWith('<tr id="row-'+response.new.id+'"><td class="hidden-xs">'+response.new.id+'</td><td class="hidden-xs">'+response.e_date_dmy+'</td><td><a href="/admin/institutions/'+response.new.slug+'"><strong>'+response.new.name+'</strong></a></td><td class="hidden-xs">'+response.new.theheadmaster.name+'</td><td>'+response.new.region.name+'</td><td class="hidden-xs">'+response.new.region.region_group.groupname+'</td><td><div class="btn-group"><button id="btn-modal-edit" class="btn btn-default btn-xs" data-id="'+response.new.id+'" data-established_date="'+response.e_date_dmy+'" data-name="'+response.new.name+'" data-region_id="'+response.new.region_id+'" data-headmaster="'+response.new.headmaster+'" data-address="'+response.new.address+'"><i class="glyphicon glyphicon-edit"></i></button><button id="btn-delete-institution" class="btn btn-danger btn-xs" data-id="'+response.new.id+'"><i class="glyphicon glyphicon-trash"></i></button></div></td></tr>');          

          $('#modal-edit-institution').modal('hide');
          $('#ajaxmessage').html('Data lembaga <strong>' +response.new.name+ ' </strong> berhasil disimpan.').parent().slideDown();
        }
      });
    });

</script>

<script>

    /*
     *
     * Delete Institution
     *
     */
  $(document).on('click', '#btn-delete-institution', function() {  
      if (confirm('Apakah anda yakin?')){
        $.ajax({
          type: 'post',
          url: '/admin/institutions/ajax/delete',         
          data: {
            "_token": "{{ csrf_token() }}",
            'id': ($(this).data('id')),
          },
          error: function(data){
            $('#ajaxmessage').text('Maaf, ada masalah, silakan kontak admin').slideDown(); 
          },            
          success: function(data) {  
            var count = +($('#institution_count').text());
            $('#row-'+data.institution.id).remove();
            $('#institution_count').text(count-1);
            $('#ajaxmessage').html('Data lembaga <strong>' +data.institution.name+ ' </strong> berhasil dihapus.').parent().slideDown();
          }
        });
      }
    });    

  
    $('.shared-modal').on('hidden.bs.modal', function(){
      if ($(this).attr('id') == 'modal-edit-person'){
          $('#myForm').find('input,textarea,select').not('#image, [name=gender],[name=status]').val('');
          $('#myForm').find('[name=gender],[name=status]').iCheck('uncheck')          
      }
    });

    $('.shared-modal').on('hidden.bs.modal', function(){
      if ($(this).attr('id') == 'modal-edit-institution'){
        clearForm();
      }
    });

    function clearForm(){
      $('#myForm').find('input,textarea,select').val('');
      $('#myForm .select2').val("").select2({
        placeholder: "-Silakan Pilih"
      });
    }

$('.123').click(function(){
  $('#row-41').remove();
});

  </script>