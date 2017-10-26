<div class="col-md-12">
	<div class="small-box bg-yellow">
		<div class="inner">
			<h3>Rp. {{ number_format(array_sum($total_stat),0,',','.') }}</h3>
			<p>Total Dana TPQ</p>
		</div>
		<div class="icon">
			<i class="fa fa-money"></i>
		</div>
	</div>
</div>

<div class="col-md-12">
	<div class="box box-primary collapsed-box box-solid">  
		<div class="box-header with-border">
			<h3 class="box-title">Dana TPQA = <span class="text-lime"><b>{{ number_format($total_stat['tpqa'],0,',','.') }}</b></span></h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
				</button>
			</div>
		</div>

		<div class="box-body">
			<table class="table table-bordered table-condensed">
				<tr>
					<th>Transaksi</th>
					<th class="text-right">Masuk</th>
					<th class="text-right">Keluar</th>
					<!-- <th>Aksi</th> -->
				</tr>	
				@foreach($transactions_statistic as $key=>$stat)	
				<tr>
					<td>{{ str_limit($stat['name'],10,'..') }}</td>
					<td class="text-right">{{ number_format($db[$key] = $stat['debet_a'],0,',','.') }}</td>
					<td class="text-right">{{ number_format($cr[$key] = $stat['credit_a'],0,',','.') }}</td>
					<!-- <td>{{ $stat['id'] }}</td> -->
				</tr>

				@endforeach
				<tr class="bg-primary">
					<td><b>Jumlah</b></td>
					<td class="text-right"><b>{{ number_format(array_sum($db),0,',','.') }}</b></td>
					<td class="text-right"><b>{{ number_format(array_sum($cr),0,',','.') }}</b></td>
				</tr>
			</table>
		</div>
	</div>
</div>


<div class="col-md-12">
	<div class="box box-primary collapsed-box box-solid">  
		<div class="box-header with-border">
			<h3 class="box-title">Dana TPQD = <span class="text-lime"><b>{{ number_format($total_stat['tpqd'],0,',','.') }}</b></span></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
					</button>
				</div>
			</div>


			<div class="box-body">
				<table class="table table-bordered table-condensed">
					<tr>
						<th>Transaksi</th>
						<th class="text-right">Masuk</th>
						<th class="text-right">Keluar</th>
						<!-- <th>Aksi</th> -->
					</tr>	
					@foreach($transactions_statistic as $key=>$stat)	
					<tr>
						<td>{{ $stat['name'] }}</td>
						<td class="text-right">{{ number_format($db[$key] = $stat['debet_d'],0,',','.') }}</td>
						<td class="text-right">{{ number_format($cr[$key] = $stat['credit_d'],0,',','.') }}</td>
						<!-- <td>{{ $stat['id'] }}</td> -->
					</tr>

					@endforeach
					<tr class="bg-primary">
						<td><b>Jumlah</b></td>
						<td class="text-right"><b>{{ number_format(array_sum($db),0,',','.') }}</b></td>
						<td class="text-right"><b>{{ number_format(array_sum($cr),0,',','.') }}</b></td>
					</tr>
				</table>
			</div>
		</div>
	</div>

<div class="col-md-12">
	<div class="box box-primary collapsed-box box-solid">  
		<div class="box-header with-border">
			<h3 class="box-title">Dana Non Santri = <span class="text-lime"><b>{{ number_format($total_stat['non-santri'],0,',','.') }}</b></span></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
					</button>
				</div>
			</div>


			<div class="box-body">
				<table class="table table-bordered table-condensed">
					<tr>
						<th>Transaksi</th>
						<th class="text-right">Masuk</th>
						<th class="text-right">Keluar</th>
						<!-- <th>Aksi</th> -->
					</tr>	
					@foreach($transactions_statistic as $key=>$stat)	
					<tr>
						<td>{{ $stat['name'] }}</td>
						<td class="text-right">{{ number_format($db[$key] = $stat['debet_ns'],0,',','.') }}</td>
						<td class="text-right">{{ number_format($cr[$key] = $stat['credit_ns'],0,',','.') }}</td>
						<!-- <td>{{ $stat['id'] }}</td> -->
					</tr>

					@endforeach
					<tr class="bg-primary">
						<td><b>Jumlah</b></td>
						<td class="text-right"><b>{{ number_format(array_sum($db),0,',','.') }}</b></td>
						<td class="text-right"><b>{{ number_format(array_sum($cr),0,',','.') }}</b></td>
					</tr>
				</table>
			</div>
		</div>
	</div>



	<div class="col-md-12">
          <div class="box">    
            <div class="box-body">
              <table class="table-bordered table">
                <tr>
                  <th>Tgl. Input</th>
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
          </div>
        </div>