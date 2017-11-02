      <div class="box-header with-border"> 
        <h3 class="box-title">Riwayat Transaksi
        <span class="btn btn-xs btn-primary"><i class="fa fa-plus-circle"></i> <b>Tambah baru</b></span></h3></h3>
      </div>
      
      @if (count($transactions) > 0)        
            <div class="box-body">  

            <table class="table table-bordered table-condensed">
              <tr class="bg-blue">
                <th>Tanggal</th>
                <th>Transaksi</th>
                <th class="text-right">Jumlah</th>
                <th style="width:40px;text-align: center;"><i class="fa fa-ellipsis-v"></i></th>
              </tr>
              @foreach($transactions as $transaction)
                <tr>
                  <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d-M-y') }}</td>
                  <td>{{ $transaction->transactionType->name }} {{ $transaction->tuition_month ? \Carbon\Carbon::parse($transaction->tuition_month)->format('M Y') : '' }}
                    @if ($transaction->notes)
                      <span data-toggle="tooltip" title="{{ $transaction->notes }}"> <i class="fa fa-info-circle"></i></span>
                    @endif
                  </td>
                  <td class="text-right">{{ number_format($transaction->amount,0,',','.') }}</td>
                  <td class="text-center">
                    <div class="dropdown">
                      <a href="#" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>
                      <div class="dropdown-menu dropdown-menu-right">
                        <div class="btn-group">
                          <button id='btn-modal-edit' class='btn btn-sm'                  
                            data-id = '{{ $transaction->id }}'
                            data-transaction_date = '{{ $transaction->transaction_date }}'
                            data-transaction_type_id = '{{ $transaction->transaction_type_id }}'  
                            data-tuition_month= '{{$transaction->tuition_month }}'
                            data-student_id='{{ $transaction->student_id }}' 
                            data-class_group_id='{{ $transaction->class_group_id }}' 
                            data-amount='{{ $transaction->amount }}' 
                            data-notes='{{ $transaction->notes }}' >
                            <i class='glyphicon glyphicon-edit'></i>
                          </button>


                      
                            <i class='glyphicon glyphicon-edit'></i> Edit
                          </button>
                          <button id='btn-delete-institution' class='btn btn-danger btn-sm ' data-id="">
                            <i class='glyphicon glyphicon-trash'></i> Hapus
                          </button>                        
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
              @endforeach
                <tr class="bg-blue">
                  <td colspan="2" ><b><span class="badge bg-black">Total= {{ number_format($total,0,',','.') }}</span><span class="pull-right">Jumlah</span></b></td>
                  <td class="text-right"><b>{{ number_format($transactions->sum('amount'),0,',','.') }}</b></td>
                  <td></td>
                </tr>
            </table>  
          </div>            
      
          <div class="box-footer clearfix">
            {{ $transactions->links() }}
          </div>        
      @endif





