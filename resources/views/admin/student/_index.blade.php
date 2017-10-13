@extends('template.layout')

@section('header-scripts')
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/flat/purple.css">
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('footer-scripts')
  <script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>
  <script src="/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="/js/custom.js"></script>
  <script src="http://malsup.github.com/jquery.form.js"></script>

  <script>

    $('input[type="checkbox"], input[type="radio"]').iCheck({
      checkboxClass: 'icheckbox_flat-purple',
      radioClass   : 'iradio_flat-purple'
    });

    $('#datastatus').on('ifChecked', function(event){
      $('#datastatus').val('on');
      $('.stop_date_wrapper').show();
    });

    $('#datastatus').on('ifUnchecked', function(event){
      $('#datastatus').val('off');
      $('#datastop_date').val(''),
      $('.stop_date_wrapper').hide();
    });


    $datatable = $('#students-data').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      autoWidth   : false,
      order: [ 0, "desc" ],
      ajax: '/students/data',  
      columns: [
        { data: 'id', name: 'id' },
        { data: 'formatted_registered_date', name: 'formatted_registered_date', orderable: false, searchable: false},         
        { data: 'institution', name: 'institution'}, 
        { data: 'name_href', name: 'name_href'}, 
        { data: 'parent', name: 'parent', orderable: false},
        { data: 'phone', name: 'phone', orderable: false},
        { data: 'status', name: 'status'},
        { data: 'actions', name: 'actions', orderable: false, searchable: false}
      ]      
    }); 

    /*
     *
     * Create Person
     *
     */
    $('#btn-modal-create').click(function() {
      $('#modal-student').find('input,textarea').not('#image, [name=gender],[name=status],[name=class_group]').val('');

      var dt = new Date(); d = ('0'+(dt.getDate())).slice(-2); m = ('0'+(dt.getMonth()+1)).slice(-2); y = dt.getFullYear();      
      $("#registered_date").val(y+'-'+m+'-'+d);
      
      $(".status_wrapper").hide();
      $(".stop_date_wrapper").hide();
            
      $('.modal-footer')
        .html("<button id='submit-create' class='btn btn-primary pull-left btn-lg'>Simpan</button><button class='btn btn-default' data-dismiss='modal'>Batal</button>")
      $('#modal-student').modal('show');
    });


    $('#image').change(function(){
      $("#message").empty();

      var file = this.files[0];
      var imagefile = file.type;
      var match= ["image/jpeg","image/png","image/jpg"];
      
      if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
      {
        $("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
        return false;            
      } else {
        var reader = new FileReader();  
        reader.onload = imageIsLoaded;
        reader.readAsDataURL(this.files[0]);
      }
    });

    function imageIsLoaded(e) {         
      $('#dataimage').attr('src', e.target.result);
    }  


    $('.modal-footer').on('click', '#submit-create', function() { 

      $.ajax({
        type: 'post',        
        url: '/admin/students/ajax/create',        
        data: {
            '_token': $('input[name=_token]').val(),
            'registered_date': $('#registered_date').val(),
            'registration_number': $('#registration_number').val(),
            'institution_id': $('#institution_id').val(),
            'fullname': $('#fullname').val(),
            'nickname': $('#nickname').val(),
            'gender': $('[name=gender]:checked').val(),
            'parent': $('#parent').val(),
            'address': $('#address').val(),                
            'phone': $('#phone').val(),
            'job': $('#job').val(),
            'tuition': $('#tuition').val(),
            'infrastructure_fee': $('#infrastructure_fee').val(),
            'group_id': $('[name=class_group]:checked').val(),
            'image': 'Calamardo.jpg'

        },
        
        error: function(data){
          var errors = '';
          var errors = data.responseJSON;              
          $('.e.fullname').removeClass('hidden').html(errors.errors.fullname);
          $('.e.phone').removeClass('hidden').html(errors.errors.phone);  
          $('.e.gender').removeClass('hidden').html(errors.errors.gender);  
          return false;        
        },

        success: function(data) {
          $('#students-data').DataTable().ajax.reload();
          $('#modal-student').modal('toggle');
          $('.successmessage').text('Data pengurus baru berhasil disimpan.')
          $('#ajaxmessage').show().delay(2000).fadeOut();
        }
      }); 

    });



    /*
     *
     * Edit Person
     *
     */
    $(document).on('click', '#btn-modal-edit', function() {
      $('.e').addClass('hidden');
      $("#dataid").val($(this).data('id'));
      $("#dataname").val($(this).data('name'));
      $("#dataregistered_date").val($(this).data('registered_date'));
      $("#dataaddress").val($(this).data('address'));
      $(".status_wrapper").show();
      if ($(this).data('status') == 0){
        $("#datastatus").iCheck('check');
      } else if ($(this).data('status') == 1 ){
        $("#datastatus").iCheck('uncheck');
      }
      $("#datastop_date").val($(this).data('stop_date'));
      if ($(this).data('gender') == 'ustadz'){
        $("#male").iCheck('check');
      } else {
        $("#female").iCheck('check');
      }
      $("#dataphone").val($(this).data('phone'));
        if($(this).data('image') == null){
          $("#dataimage").attr('src', '/imagecache/medium_sq/'+$(this).data('image'));
        } else {
          $("#dataimage").attr('src', '/imagecache/medium_sq/default.jpg');
        }
      $('.modal-footer')
      .html("<button id='submit-update' class='btn btn-primary pull-left btn-lg'>Update</button><button class='btn btn-default' data-dismiss='modal'>Batal</button>")
          $('#modal-person').modal('show');
    });

    $('.modal-footer').on('click', '#submit-update', function() {    
      $.ajax({
        type: 'post',
        url: '/admin/persons/ajax/update',
        data: {
            '_token': $('input[name=_token]').val(),
            'registered_date': $('#dataregistered_date').val(),
            'name': $('#dataname').val(),
            'gender': $('[name=gender]:checked').val(),
            'address': $('#dataaddress').val(),                
            'phone': $('#dataphone').val(),
            'status': $('#datastatus').val(),
            'stop_date': $('#datastop_date').val(),
            'id': $('#dataid').val()
        },
        error: function(data){
          alert(data.message);
          var errors = data.responseJSON;              
          $('.e.name').removeClass('hidden').html(errors.errors.name);
          $('.e.phone').removeClass('hidden').html(errors.errors.phone);  
          $('.e.gender').removeClass('hidden').html(errors.errors.gender);  

          return false;        
        },            
        success: function(data) {   
          $('#persons-data').DataTable().ajax.reload();
          $('#modal-person').modal('toggle');
          $('.successmessage').text('Data pengurus baru berhasil diperbarui.')
          $('#ajaxmessage').show().delay(2000).fadeOut();
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
            alert(data.responseText);
            return false;        
          },            
          success: function(data) {              
            $('#persons-data').DataTable().ajax.reload();
            $('.successmessage').text('Data pengurus telah dihapus.')
            $('#ajaxmessage').show().delay(2000).fadeOut();
          }
        });
      }
    });


    $('#modal-person').on('hidden.bs.modal', function () {    

     
      $("#dataaddress").html('');
      $("#dataphone").attr('value', '');
      $("#male").iCheck('uncheck');
      $("#female").iCheck('uncheck');      
    });


  </script>


@endsection

@section('content-top')
  <div class="alert alert-success alert-dismissible" style='display:none;' id='ajaxmessage'>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> Sukses!</h4>
    <span class='successmessage'></span>
  </div>
  <h1>Santri
    <button id='btn-modal-create' class='btn btn-primary'><i class="fa fa-plus-circle"></i> Tambah Santri</button>
  </h1>
@endsection

@section('content-main')
  <div class="box">    
    <div class="box-body">
      <table class="table table-bordered" id="students-data">
        <thead>
        <tr>
          <th>ID</th>
          <th>Terdaftar</th>          
          <th>Lembaga</th>
          <th>Nama</th>
          <th>Nama OT</th>
          <th>No. Telepon</th>
          <th>Status</th>
          <th>Aksi</th>          
        </tr>
        </thead>
      </table>
    </div>
    
    <div class="box-footer clearfix">      
    </div>
  </div>
  @include('/admin/student/modal')

@endsection


  