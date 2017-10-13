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
  <div class="box">    
    <div class="box-body">
      <table class="table table-bordered" id="students-data">
        <tr>
          <th>#</th>
          <th>Tanggal</th>
          <th>Jenis transaksi</th>
          <th>Nama</th>          
          <th class="text-right">Jumlah</th>
          <th>Keterangan</th>
        </tr>
        @foreach($transactions as $transaction)
        <tr>
          <td>
            {{ $transaction->id }}
          </td>
          <td>
            {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d-M-y') }}
          </td>
          <td>
            <small>
              @if($transaction->class_group_id == 1)
                <span class="label bg-green disable">
              @elseif($transaction->class_group_id == 3)
                <span class="label bg-orange disable">
              @endif
              {{ $transaction->studentGroup->name }}</span>
            </small> {{ $transaction->transactionType->name }} {{ $transaction->tuition_month ? \Carbon\Carbon::parse($transaction->tuition_month)->format('F Y') : ''}}
          </td>
          <td>
            {{ $transaction->student->fullname }}
          </td>
          <td class="text-right">
            Rp. {{ number_format($transaction->amount,0,',','.') }}
          </td>
          <td>
            {{ $transaction->notes }}
          </td> 
            <td>
              <div class='btn-group'>                
                {!! Form::button('<i class="glyphicon glyphicon-edit"></i>' ,[
                  'class'=> 'btn btn-default btn-xs',
                  'id'=>'btn-modal-edit',
                  'data-id' => $transaction->id,
                  'data-transaction_date' => $transaction->transaction_date ? \Carbon\Carbon::parse($transaction->transaction_date)->format('d-m-Y') : '',
                  'data-transaction_type_id' => $transaction->transaction_type_id,
                  'data-student_id' => $transaction->student_id,
                  'data-amount' => $transaction->amount,
                  'data-notes' => $transaction->notes,
                  'data-class_group_id' => $transaction->class_group_id,
                  'data-tuition_month' => $transaction->tuition_month ? \Carbon\Carbon::parse($transaction->tuition_month)->format('m-Y') : '',
                ]) !!}

                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['class' => 'btn btn-danger btn-xs', 'id'=>'btn-delete-transaction', 'data-id'=> $transaction->id ]) !!}
              </div>
              
            </td>                   
        </tr> 
        @endforeach
      </table>
    </div>
    
    <div class="box-footer clearfix">      
    </div>
  </div>
  @include('/admin/transaction/modal')

@endsection