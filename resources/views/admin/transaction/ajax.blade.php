<script>

    $('input[type="checkbox"], input[type="radio"]').iCheck({
      checkboxClass: 'icheckbox_flat-purple',
      radioClass   : 'iradio_flat-purple'
    });    

    $('#spp').on('ifUnchecked', function(event){  
      if ($('#credit').val() == 'no')
        $('.tuition_month_wrapper').slideUp();
    });    

    $('#spp').on('ifChecked', function(event){        
      if ($('#credit').val() == 'no')
        $('.tuition_month_wrapper').slideDown();
    });  

    $('.select2').select2();
    
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

    $('#tuition_month').change(function(){
      $split = $(this).val().split('-');
      $('#tuition_month_ymd').val($split[1]+'-'+$split[0]+'-01');
    });

    $('.shared-modal').on('hidden.bs.modal', function(){
      if ($(this).attr('id') == 'modal-edit-transaction'){
        clearForm();
      }
    });

    function clearForm(){
      $('#myForm').find('input,textarea,select').not('[name=class_group_id],[name=transaction_type_id]').val('');
      $('#myForm .select2').val(null).trigger("change");
      $('#myForm').find('[name=class_group_id], [name=transaction_type_id]').iCheck('uncheck')   
      $('.tuition_month_wrapper').hide();     
    }

    $('#almaruftransaction-stat').load('/admin/data/block-almaruftransaction-statistic');

    $('[name="transaction_type_id"], #student_id, #amount, #tuition_month').click(function() {
      $('.err').html('').hide();
    });


    /*
     *
     * Create Transaction
     *
     */
    $('#btn-modal-create-db, #btn-modal-create-kr').click(function() {
      $('[name=transaction_type_id]').iCheck('uncheck')
      if(this.id == 'btn-modal-create-db'){
        $('#myForm').toggleClass('debet')
        $('#datatitle').text('Tambah Transaksi Masuk');         
        $('#credit').val('no'); 
        $('.class_group_id_wrapper').hide(); 
        $('.student_id_wrapper').show();         
      }

      if(this.id == 'btn-modal-create-kr'){
        $('#myForm').removeClass('debet')
        $('#datatitle').text('Tambah Transaksi Keluar');  
        $('#credit').val('yes');  
        $('.class_group_id_wrapper').show(); 
        $('.student_id_wrapper').hide(); 
        $('.tuition_month_wrapper').hide();
      }

      $('.shared-modal').attr('id','modal-create-transaction');

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


    /*
     *
     * Edit Transaction
     *
     */
    $(document).on('click', '#btn-modal-edit', function() {
      $("#status").removeAttr('name');
      $('.shared-modal').attr('id','modal-edit-transaction')
      $('#datatitle').text('Edit data transaksi')

      $('#id').val($(this).data('id'));
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
      $('input[name="transaction_type_id"][value='+tr_value+']').iCheck('check');

      if(tr_value == 4 ){
        $('.tuition_month_wrapper').slideDown();
      }


      $('#student_id').val($(this).data('student_id')).select2();
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
      var form = $('#myForm')[0];
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
          $datatable.ajax.reload(); 
          $('#almaruftransaction-stat').load('/admin/data/block-almaruftransaction-statistic');
          clearForm();                    
          $('#modal-edit-transaction').modal('hide');
          $('#ajaxmessage').html('Transaksi <strong>'+ response.new.transaction_type.name+'</strong> '+response.new.student.nickname+ ' berhasil diperbarui.').parent().slideDown();  
        }
      });
    });






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
            $('#row-'+data.transaction.id).remove();
            $('#ajaxmessage').html('Data transaksi berhasil dihapus.').parent().slideDown();            
          }
        });
      }
    });

  </script>