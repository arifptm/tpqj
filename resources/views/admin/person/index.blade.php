@extends('template.layout')

@section('header-scripts')
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/flat/purple.css">
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="/css/custom.css">
  
@endsection

@section('footer-scripts')
  <script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>
  <script src="/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.js"></script>
  <script src="/bower_components/AdminLTE/plugins/select2/select2.min.js"></script>
  <script  src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
  <script  src="//cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
  <script  src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script  src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
  <script  src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
  <script  src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
  <script  src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>  
  <script  src="//cdn.datatables.net/buttons/1.4.2/js/buttons.colVis.min.js"></script>
  <script src="/js/custom.js"></script>

  @include('admin.person.ajax');
@endsection

@section('content-top')
  <div class="alert bg-green lead" style='display:none;'><i class="icon fa fa-check"></i> <span id="ajaxmessage"></span></div>
  <h1>Pengurus
    <button id='btn-modal-create' class='btn btn-primary'><i class="fa fa-plus-circle"></i> Tambah Pengurus</button>
  </h1>
@endsection

@section('content-main')
  <div class="row">
    <div class="col-md-8">
      <div class="box">    
        <div class="box-body">
          <table class="table table-bordered" id="persons-data">
            <thead>
            <tr>
              <th>ID</th>
              <th>Terdaftar</th>          
              <th>Nama</th>
              <th>Lembaga</th>
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
    </div>

    <div class="col-md-8">
      <!-- @include('admin.include.statistic') -->
    </div>
  </div>
  @include('/admin/person/modal')
@endsection
