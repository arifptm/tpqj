<script>
  //trigger click on radio institution
    $(document).on('ifToggled', '[name="chosen_institution[]"]', function() {
      var vins = institutionFilter()
      $datatable.ajax.url( '/data/achievements/'+vins+'/all/group' ).load();      
      $('#achievement-stat').load('/admin/data/block-achievement-statistic/'+vins);
    });

    $('#select_all').on('click', function(){
      $('[name="chosen_institution[]"]').each(function(){
         $(this).iCheck('check')
      });
    });

    $(document).on('click', '.show-arc', function(){
      vins = $(this).data('institution_id')
      stg = $(this).data('stage_id')
      group = $(this).data('group')
      $datatable.ajax.url( '/data/achievements/'+vins+'/'+stg+'/'+group ).load()
    });


  //load block statistic
    $('#achievement-stat').load('/admin/data/block-achievement-statistic/default');

  //init select2 &&  icheck
    $('.select2').select2();

    $('input[type="checkbox"], input[type="radio"]').iCheck({
      checkboxClass: 'icheckbox_flat-purple',
      radioClass   : 'iradio_flat-purple'
    });

    // init calendar for create new achievement
    $('#achievement_date').calendarsPicker({
      showTrigger: '<div class="input-group-addon"><i class="fa fa-calendar"></i></div>',
      calendar: $.calendars.instance('gregorian','id'),
      prevText: 'M', commandsAsDateFormat: true,
      nextText: 'M', commandsAsDateFormat: true,
      dateFormat: 'dd-mm-yyyy',
      altField: '#acda_alt',
      altFormat: 'yyyy-mm-dd',
      autoSize: true,
      maxDate: 0
    });

    $('#achievement_hijri_date').calendarsPicker({
      showTrigger: '<div class="input-group-addon"><i class="fa fa-calendar"></i></div>',
      calendar: $.calendars.instance('islamic','id'),
      prevText: 'M', commandsAsDateFormat: true,
      nextText: 'M', commandsAsDateFormat: true,
      dateFormat: 'dd-mm-yyyy',
      altField: '#achida_alt',
      altFormat: 'yyyy-mm-dd',
      autoSize: true,
      maxDate: 0
    });

    $('#achievement_date').change(function(){
      dt = ($(this).val()).split('-');

      var gc = $.calendars.instance('gregorian');
      var d = gc.newDate(
        parseInt(dt[2], 10),
        parseInt(dt[1], 10),
        parseInt(dt[0], 10)).toJD();

      var gcn = $.calendars.instance('islamic').fromJD(d);
       $('#achievement_hijri_date').val(gcn.formatDate('dd-mm-yyyy'))
       $('#achida_alt').val(gcn.formatDate('yyyy-mm-dd'))
    });

    $('#achievement_hijri_date').change(function(){
      dt = ($(this).val()).split('-');

      var gc = $.calendars.instance('islamic');
      var d = gc.newDate(
        parseInt(dt[2], 10),
        parseInt(dt[1], 10),
        parseInt(dt[0], 10)).toJD();

      var gcn = $.calendars.instance('gregorian').fromJD(d);
       $('#achievement_date').val(gcn.formatDate('dd-mm-yyyy'))
       $('#acda_alt').val(gcn.formatDate('yyyy-mm-dd'))
    });

    
    function institutionFilter(){
      var ins = new Array;
      $('[name="chosen_institution[]"]:checked').each ( function() {
        ins.push ( $(this).val() );
      });
      if ( ins.length == 0 ){ vins = '0' } else { vins = ins.join('_')}
      return vins;
    };
</script>


<script>
  /*
   * Create Achievement
   */

  $('#btn-modal-create').click(function() {          
   
    $('#datatitle').text('Tambah Kelulusan');                   
    $('.shared-modal').attr('id','modal-create-achievement');

    gcm = $.calendars.instance('gregorian','id').today();
    $('#achievement_date').val(gcm.formatDate('dd-mm-yyyy'))
    $('#acda_alt').val(gcm.formatDate('yyyy-mm-dd'))

    gch = $.calendars.instance('islamic','id').today();
    $('#achievement_hijri_date').val(gch.formatDate('dd-mm-yyyy'))      
    $('#achida_alt').val(gch.formatDate('yyyy-mm-dd'))
          
    $('.modal-footer')
      .html("<button id='submit-create' class='btn btn-primary pull-left btn-lg'>Simpan</button><button class='btn btn-lg pull-left bg-olive' data-dismiss='modal'>Batal</button>")
    $('#modal-create-achievement').modal('show');
  });

  //create button click
  $('.modal-footer').on('click', '#submit-create', function(e) {      
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
        var vins = institutionFilter()
        $datatable.ajax.url( '/data/achievements/'+vins+'/all/group' ).load();
        $('#show-arc, #btn-modal-edit').attr('data-institution_id', vins);
        $('#achievement-stat').load('/admin/data/block-achievement-statistic/'+vins);
        
        clearForm();          
        $('#modal-create-achievement').modal('hide');
        $('#ajaxmessage').html('Data kelulusan <strong>' +response.achievement.student.fullname+ '</strong> (' +response.achievement.stage.name+ ') berhasil disimpan.').parent().slideDown();          
      }
    });
  });
</script>

<script>
  /*
   * Edit Achievement
   */
  $(document).on('click', '#btn-modal-edit', function() {      
    $('.shared-modal').attr('id','modal-edit-achievement')
    $('#datatitle').text('Edit data kelulusan')

    $('#id').val($(this).data('id'));      
    
    //fill masehi && hijri field
    var datedata = $(this).data('achievement_date')
    $('#achievement_date').val(datedata);    
    
    var dt = datedata.split('-')

    $('#acda.alt').val(dt[2]+dt[1]+dt[0])

    var gc = $.calendars.instance('gregorian');
    var d = gc.newDate(
      parseInt(dt[2], 10),
      parseInt(dt[1], 10),
      parseInt(dt[0], 10)).toJD();

    var gcn = $.calendars.instance('islamic').fromJD(d);
    $('#achievement_hijri_date').val(gcn.formatDate('dd-mm-yyyy'))
    $('#achida_alt').val(gcn.formatDate('yyyy-mm-dd'))

    //fill student id
    $('#student_id').val($(this).data('student_id')).select2();
    var tr_value = $(this).data('stage_id')
    $('input[name="stage_id"][value='+tr_value+']').iCheck('check');
    
    $('.modal-footer')
    .html("<button id='submit-update' class='btn btn-primary pull-left btn-lg'>Update</button><button class='btn btn-lg pull-left bg-olive' data-dismiss='modal'>Batal</button>")
    $('#modal-edit-achievement').modal('show');      
  });


$(document).on('click', '#submit-update', function(e) {      
    var form = $('#achievementForm')[0];
    var formData = new FormData(form);
    $.ajax({
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

      success: function(response){
        var vins = institutionFilter()
        $datatable.ajax.url( '/data/achievements/'+vins+'/all/group' ).load();
        $('#show-arc, #btn-modal-edit').attr('data-institution_id', vins);
        $('#achievement-stat').load('/admin/data/block-achievement-statistic/'+vins);
        
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
            var vins = institutionFilter()
            $datatable.ajax.url( '/data/achievements/'+vins+'/all/group' ).load();
            $('#show-arc, #btn-modal-edit').attr('data-institution_id', vins);
            $('#achievement-stat').load('/admin/data/block-achievement-statistic/'+vins);            
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
      $('#achievementForm').find('input,select').not('[name=stage_id]').val('');
      $('#achievementForm .select2').val(null).trigger("change");
      $('#achievementForm').find('[name=stage_id]').iCheck('uncheck')  
      $('#modalmessage').parent().hide();      
    }

  </script>