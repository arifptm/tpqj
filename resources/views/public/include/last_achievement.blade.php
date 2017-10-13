<table class="table table-bordered table-striped">
	<tr>
		<th>Nama Santri</th>
		<th>Lulus</th>
		<!-- <th>Tanggal</th> -->
	</tr>
	@foreach ($achievements as $achievement)
		<tr>
			<td>{{$achievement->student->fullname}} <span class="text-orange"><small>{{$achievement->student->institution->name}}</small></span>
			</td>
			
			<td>{{$achievement->stage->name}}</td>
			<!-- <td>{{$achievement->achievement_date->format('d-m-y')}}</td> -->
		</tr>
	@endforeach
</table>