
  $('input[type="checkbox"], input[type="radio"]').iCheck({
    checkboxClass: 'icheckbox_flat-purple',
    radioClass   : 'iradio_flat-purple'
  }); 

  // $('.select2').select2();








    
    $('input.item').on('ifChecked', function(event){
      var t = $(this).attr('name');
      $('.selected-id').attr('value', function(){
        return $(this).attr('value')+','+t;
      });
    });

    $('input.item').on('ifUnchecked', function(event){
      var t = $(this).attr('name');
      $('.selected-id').attr('value', function(){
        return $(this).attr('value').replace(','+t,'');
      });
    });

    $('#select-all').on('ifChecked', function(event){
      $('.icheckbox_flat-purple').each(function(){
        $(this).iCheck('check');
      });
    });
    
    $('#select-all').on('ifUnchecked', function(event){
      $('.icheckbox_flat-purple').each(function(){
        $(this).iCheck('uncheck');
      });
    });    



