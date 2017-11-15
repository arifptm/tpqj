@extends('template.layout')

@section('header-scripts')
  <link rel="stylesheet" href="/plugins/datepicker/css/bootstrap-datepicker3.css">

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
    @include('/admin/student/modal-transaction') 

  </div>

@endsection 


@section('footer-scripts')
  <script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>
  <script src="/plugins/datepicker/js/bootstrap-datepicker.js"></script>
  <script src="/plugins/datepicker/locales/bootstrap-datepicker.id.min.js"></script>

  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.plugin.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.min.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.plus.min.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.picker.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.islamic.js"></script>
  <script src="/bower_components/jquery.calendars-2.1.0/js/jquery.calendars.picker-id.js"></script>    
  <script src="/bower_components/AdminLTE/plugins/select2/select2.min.js"></script>
  <script src="/js/custom.js"></script>
  @include('/admin/student/ajax-achievement')
  @include('/admin/student/ajax-transaction')


  <script>
    /*
    ** Load content and block for page with ID
    */

    sid = $('#cur_student_id').text() // get Student ID
    $('#student_achievements').load('/data/student-achievements/'+sid)
    $('#student_transactions').load('/data/student-transactions/'+sid)    
    $('#student').load('/data/student/'+sid) 
  </script>

  <script>
    /*
     * Create pagination on ajax page
    */

      $(document).on('click', '.pagination a', function(e) {
          e.preventDefault();
          var url = $(this).attr('href');
          $('#'+$(this).closest('section').attr('id')).load(url)
      });
  </script>

@endsection 