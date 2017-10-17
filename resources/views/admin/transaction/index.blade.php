@extends('template.layout')

@section('header-scripts')
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/flat/purple.css">
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.css">
  <link rel="stylesheet" href="/plugins/datepicker/css/bootstrap-datepicker3.css">

  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('footer-scripts')
  <script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>
  <script src="/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.js"></script>
  <script src="/bower_components/AdminLTE/plugins/select2/select2.min.js"></script>
  <script src="/plugins/datepicker/js/bootstrap-datepicker.js"></script>
  <script src="/plugins/datepicker/locales/bootstrap-datepicker.id.min.js"></script>
  @include('admin.transaction.datatables')
  @include('admin.transaction.ajax')



  <script src="/js/custom.js"></script>
  @endsection

@section('content-top')
  <div class="alert bg-green lead" style='display:none;'><i class="icon fa fa-check"></i> <span id="ajaxmessage"></span></div>
  <h1>Transaksi
    <button id='btn-modal-create-db' class='btn btn-primary' ><i class="fa fa-plus-circle"></i> Tansaksi masuk</button> 
    <button id='btn-modal-create-kr' class='btn btn-warning' ><i class="fa fa-minus-circle"></i> Tansaksi keluar</button>
  </h1>
@endsection

@section('content-main')
  <div class="row">
    <div class="col-md-8">
      <div class="box">    
        <div class="box-body">
          <table class="table table-bordered" id="transactions-data">
            <thead>
            <tr>              
              <th>Tanggal</th>          
              <th>Transaksi</th>
              <th>Nama</th>
              <th>Jumlah</th>              
              <th>Aksi</th>          
            </tr>
            </thead>
          </table>
        </div>        
        <div class="box-footer clearfix">        
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="box">    
        <div class="box-body">
          <table class="table-bordered table">
            <tr>
              <th>Tanggal</th>
              <th class="text-right">Jumlah Transaksi</th>
              <th>Detil</th>
            </tr>
            @foreach ($transactions as $k=>$transaction)
              <tr>
                <td>{{ $k }}</td>
                <td class="text-right">Rp. {{ number_format($transaction->sum('amount'),0,',','.') }}</td>
                <td><button class="btn btn-xs btn-primary" id="show-tr" data-tdate="{{ $k }}"><i class="fa fa-eye transaction-list" "></i></button></td>            
              </tr>
            @endforeach
          </table>

          
        </div>
        <div class="box-footer clearfix">      
        </div>
      </div>
    </div>
  </div>
  @include('/admin/transaction/modal')


@endsection
