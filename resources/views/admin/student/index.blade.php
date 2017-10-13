@extends('template.layout')

@section('header-scripts')
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/flat/purple.css">
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css">

@endsection

@section('footer-scripts')
  <script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>
  <script src="/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.js"></script>
  @include('admin.student.ajax')

  <script src="/js/custom.js"></script>
  @endsection

@section('content-top')
  <div class="alert bg-green lead" style='display:none;'><i class="icon fa fa-check"></i> <span id="ajaxmessage"></span></div>
  <h1>Santri
    <button id='btn-modal-create' class='btn btn-primary'><i class="fa fa-plus-circle"></i> Tambah Santri</button>
  </h1>
@endsection

@section('content-main')
<div class="row">
  <div class="col-md-12">
    <div class="box">    
      <div class="box-body">  
        <table class="table table-bordered" id="students-data">
          <thead>
          <tr>
            <th>ID</th>
            <th>Terdaftar</th>          
            <th>Lembaga</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Status</th>
            <th></th>          
          </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <!-- <div class="col-md-4">
    <div class="box">    
      <div class="box-header with-border">
        <h3 class="box-title">Statistik Santri</h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered">          
          <tr>
            <th>Santri Anak</th>
            <td>
              <ul>
                <li>wqeqw</li>
                <li>wqeqw</li>
                <li>wqeqw</li>
              </ul>
            </td>
          </tr>
          <tr>
            <th>Santri Dewasa</th>
          </tr>
          <tr>
            <td>
              
            </td>
          </tr>                    

        </table>
      </div>
    </div>

  </div>
</div>  --> 
    
    

  @include('/admin/student/modal')

@endsection