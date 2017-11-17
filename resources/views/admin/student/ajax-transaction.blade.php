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
      var form = $('#transactionForm')[0];
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
          clearTransactionForm(); 
          $('#student_transactions').load('/data/student-transactions/'+sid);
          $('#modal-create-transaction').modal('hide');

          $('#ajaxmessage').html('Transaksi <strong>'+ response.new.transaction_type.name+'</strong> '+response.new.student.nickname+ ' berhasil disimpan.').parent().slideDown();    
          
        }
      });
    });
</script>


<script>
    /*
     *
     * Edit Transaction
     *
     */
    $(document).on('click', '.edit-transaction', function() {
      $("#status").removeAttr('name');
      $('.transaction-modal').attr('id','modal-edit-transaction');
      $('.modal-title').text('Edit data transaksi')

      $('#transaction_id').val($(this).data('id'));

      $tr_date = $(this).data('transaction_date').split('-');
      $('#transaction_date').val($tr_date[2]+'-'+$tr_date[1]+'-'+$tr_date[0]);
      
      $tuit_dt = $(this).data('tuition_month');
      if ($tuit_dt == '0' ){
        $('#tuition_month').val('');        
      } else {
        $tuit_dt = $tuit_dt.split('-');
        $('#tuition_month').val($tuit_dt[1]+'-'+$tuit_dt[0]);
      }
      
      var tr_value = $(this).data('transaction_type_id')
      var cr = $(this).data('amount')
      $('input[name="transaction_type_id"][value='+tr_value+']').iCheck('check');

      if(tr_value == 4 && cr > 0 ){
        $('.tuition_month_wrapper').slideDown();
      }


//      $('#stid').val($(this).data('student_id'));
      var t_amount = $(this).data('amount')
      $('#amount').val(Math.abs(t_amount));
      $('#notes').val($(this).data('notes'));

      if (t_amount < 0 ){
        $('.class_group_id_wrapper').show();
        $('.student_id_wrapper').hide();
        $('#credit').val('yes');  
      } else {
        $('.class_group_id_wrapper').hide();
        $('.student_id_wrapper').show();
        $('#credit').val('no');  
      }

      if ($(this).data('class_group_id') == 1){
        $("#tpqa").iCheck('check');
      } else if ($(this).data('class_group_id') == 3){
        $("#tpqd").iCheck('check');
      } else if ($(this).data('class_group_id') == 5){
        $("#non-santri").iCheck('check');
      }

      
      $('.modal-footer')
      .html("<button id='submit-update' class='btn btn-primary pull-left btn-lg'>Update</button><button class='btn btn-lg pull-left bg-olive' data-dismiss='modal'>Batal</button>")
      $('#modal-edit-transaction').modal('show');
    });


    $('.modal-footer').on('click', '#submit-update', function() {    
      var form = $('#transactionForm')[0];
      var formData = new FormData(form);      
      $.ajax({
        type: 'post',
        url: '/admin/transactions/ajax/update',
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

        success: function(response) {   
          //$datatable.ajax.reload(); 
          //$('#student_transaction').load('/admin/data/block-almaruftransaction-statistic');
          $('#student_transactions').load('/data/student-transactions/'+sid);
          clearTransactionForm();                    
          $('#modal-edit-transaction').modal('hide');
          $('#ajaxmessage').html('Transaksi <strong>'+ response.new.transaction_type.name+'</strong> '+response.new.student.nickname+ ' berhasil diperbarui.').parent().slideDown();  
        }
      });
    });  

</script>




<script>
/*
     *
     * Delete Transaction
     *
     */
    $(document).on('click', '#btn-delete-transaction', function() {  
      if (confirm('Apakah anda yakin?')){
        $.ajax({
          type: 'post',
          url: '/admin/transactions/ajax/delete',
          data: {
            'id': ($(this).data('id')),
            '_token': $('input[name=_token]').val(),
          },

          error: function(data){
          $('#ajaxmessage').text('Maaf, ada masalah, silakan kontak admin').slideDown();
          },            
          
          success: function(data) {                          
            $('#student_transactions').load('/data/student-transactions/'+sid);
            $('#ajaxmessage').html('Data transaksi berhasil dihapus.').parent().slideDown();            
          }
        });
      }
    });

  </script>





<script>
    function clearTransactionForm(){
      $('#myForm').find('input,textarea,select').not('[name=class_group_id],[name=transaction_type_id]').val('');
      $('#myForm .select2').val(null).trigger("change");
      $('#myForm').find('[name=class_group_id], [name=transaction_type_id]').iCheck('uncheck')   
      $('.tuition_month_wrapper').hide();     
    }
</script>