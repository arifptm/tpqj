@extends('template.layout')

@section('header-scripts')
  <link rel="stylesheet" href="/bower_components/jquery.calendars-2.1.0/css/ui.calendars.picker.css">
  <link rel="stylesheet" href="/bower_components/jquery.calendars-2.1.0/css/jquery.calendars.picker.css">
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/flat/purple.css">
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content-top')
  <div class="alert bg-green lead" style='display:none;'><i class="icon fa fa-check"></i> <span id="ajaxmessage"></span></div>
  <h1>Data Santri</h1><div id="cur_student_id" class="hidden">{{ $student->id }}</div>
@endsection

@section('content-main')

  <div class="row">
    <div class="col-md-3">
      <div class="box box-primary" style="min-height: 100px;">
        <div id="student">     
          <div class="overlay">
            <i class="fa fa-refresh fa-spin"></i>
          </div>
        </div>  
      </div>
    </div>

    <div class="col-md-4">
      <div class="box box-primary" style="min-height: 100px;">
        <section id="student_achievements">     
          <div class="overlay">
            <i class="fa fa-refresh fa-spin"></i>
          </div>
        </section>  
      </div>
    </div>

    <div class="col-md-5">
      <div class="box box-primary" style="min-height: 100px;">
          <section id="student_transactions">     
            <div class="overlay">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </section>             
      </div>
    </div>

    @include('/admin/student/modal-achievement')    

  </div>

@endsection 


@section('footer-scripts')
  <script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.plugin.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.min.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.plus.min.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.picker.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.islamic.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.picker-id.js"></script>    
  <script src="/bower_components/AdminLTE/plugins/select2/select2.min.js"></script>
  <script src="/js/custom.js"></script>
  @include('/admin/student/ajax-achievement')



  <script>
    /*
    ** Load content and block for page with ID
    */
    sid = $('#cur_student_id').text()
    $('#student_achievements').load('/data/student-achievements/'+sid);    
    $('#student_transactions').load('/data/student-transactions/'+sid);    
    $('#student').load('/data/student/'+sid);    
  </script>

  <script>
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
  </script>

<script>
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
      var cr = $(this).data('amount')
      $('input[name="transaction_type_id"][value='+tr_value+']').iCheck('check');

      if(tr_value == 4 && cr > 0 ){
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
</script>

  <script>
    $('#submit-edit-achievement').click(function(){
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
          //var vins = institutionFilter()
          //$datatable.ajax.url( '/data/achievements/'+vins+'/all' ).load();
          //$('#show-arc, #btn-modal-edit').attr('data-institution_id', vins);
          //$('#achievement-stat').load('/admin/data/block-achievement-statistic/'+vins);
          
          //clearForm();
          
          $('#achievement-modal').modal('hide');
          $('#ajaxmessage').html('Data kelulusan <strong>' +response.achievement.student.fullname+ '</strong> (' +response.achievement.stage.name+ ') berhasil diperbarui.').parent().slideDown();  
        }
      });
    });
    
  </script>



<script>
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $('#'+$(this).closest('section').attr('id')).load(url)
    });
</script>

@endsection 






