<script>
    /*
     * Init 
     */
     
    $('#spp').on('ifUnchecked', function(event){  
      if ($('#credit').val() == 'no')
        $('.tuition_month_wrapper').slideUp();
    });    

    $('#spp').on('ifChecked', function(event){        
      if ($('#credit').val() == 'no')
        $('.tuition_month_wrapper').slideDown();
    }); 

    // Calender Picker => bootstrap     
    $('.datepicker').datepicker({      
      language: 'id',
      autoclose: true,
      todayHighlight:true,
      format: 'dd-mm-yyyy',
      endDate: '0d'
    });

    $('.monthpicker').datepicker({      
      language: 'id',
      autoclose: true,
      startView: 1,
      minViewMode: 1,
      format: 'mm-yyyy',
      endDate: '+60d'
    });
</script>



<script>
    /*
     * Create Transaction
     */
    $(document).on('click', '#btn-modal-create-transaction', function() { 

      $('.transaction-modal').attr('id','modal-create-transaction');
      $('.modal-title').text('Tambah transaksi');         

      $('[name=transaction_type_id]').iCheck('uncheck')              
      $('#credit').val('no'); 
      $('.class_group_id_wrapper').hide(); 
      $('.student_id_wrapper').show();               

      var dt = new Date(); d = ('0'+(dt.getDate())).slice(-2); m = ('0'+(dt.getMonth()+1)).slice(-2); y = dt.getFullYear();        
      $("#transaction_date").val(d+'-'+ m +'-'+y);      
            
      $('.modal-footer')
        .html("<button id='submit-create' class='btn btn-primary pull-left btn-lg'>Simpan</button><button class='btn bg-olive pull-left btn-lg' data-dismiss='modal'>Batal</button>")
      $('#modal-create-transaction').modal('show');
    });



    $('.modal-footer').on('click', '#submit-create', function(e) {      
      var form = $('#myForm')[0];
      var formData = new FormData(form);
      $.ajax({
        url: '/admin/transactions/ajax/create',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: formData,
        type:"POST",
        contentType: false,
        processData: false,

        error: function(response){
          var msg = response.responseJSON.errors;   
          $('.student_id').html(msg.student_id).slideDown();
          $('.amount').html(msg.amount).slideDown();
          $('.transaction_type_id').html(msg.transaction_type_id).slideDown();
          $('.tuition_month').html(msg.tuition_month).slideDown();
          $('.tuition_month_ymd').html(msg.tuition_month_ymd).slideDown();
        },

        success: function(response){
          clearForm(); 
          $('#modal-create-transaction').modal('hide');
          $('#almaruftransaction-stat').load('/admin/data/block-almaruftransaction-statistic');

          $('#ajaxmessage').html('Transaksi <strong>'+ response.new.transaction_type.name+'</strong> '+response.new.student.nickname+ ' berhasil disimpan.').parent().slideDown();    
          $datatable.ajax.reload();    
        }
      });
    });
</script>