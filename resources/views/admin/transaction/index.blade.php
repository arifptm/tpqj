@extends('template.layout')

@section('header-scripts')
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/flat/purple.css">
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.css">
  <link rel="stylesheet" href="/plugins/datepicker/css/bootstrap-datepicker3.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.0/css/responsive.dataTables.min.css">

  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('footer-scripts')
  <script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>
  <script src="/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.js"></script>
  <script src="/bower_components/AdminLTE/plugins/select2/select2.min.js"></script>
  <script src="/plugins/datepicker/js/bootstrap-datepicker.js"></script>
  <script src="/plugins/datepicker/locales/bootstrap-datepicker.id.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script> 
  <script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js"></script>
  <script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>   
  
  <script src="/js/custom.js"></script>  

  @include('admin.transaction.datatables')
  @include('admin.transaction.ajax')



  
  @endsection

@section('content-top')
  <div class="alert bg-green lead" style='display:none;'><i class="icon fa fa-check"></i> <span id="ajaxmessage"></span></div>
  <h1>Transaksi
    <button id='btn-modal-create-db' class='btn btn-primary' ><i class="fa fa-plus-circle"></i> Masuk</button> 
    <button id='btn-modal-create-kr' class='btn btn-warning' ><i class="fa fa-minus-circle"></i> Keluar</button>
  </h1>
@endsection

@section('content-main')
  <div class="row">
    @can('view-almaruf_transaction_stat')
      <div class="col-md-8">
    @endcan
    @cannot('view-almaruf_transaction_stat')
      <div class="col-md-12">
    @endcan
      <div class="box">    
        <div class="box-body" style="min-height:200px;">
          <table class="table table-bordered" id="transactions-data" >
            <thead>
            <tr>              
              <th>ID</th>          
              <th>Tgl. Bayar</th>          
              <th>Transaksi</th>
              <th>Nama</th>
              <th class="text-right">Jumlah</th>              
              <th>Aksi</th>          
            </tr>
            </thead>
          </table>
        </div>        
        <div class="box-footer clearfix">        
        </div>
      </div>
    </div>
    @can('view-almaruf_transaction_stat')
    <div class="col-md-4">
      <div class="row">        
        <div id="almaruftransaction-stat">
          <div class="loader" style="min-height: 200px;"></div>          
        </div>        
      </div>
    </div>
    @endcan
  </div>
  @include('/admin/transaction/modal')


@endsection
