<div class="col-md-12">
  <div class="box">    
    <div class="box-header">
      <h3 class="box-title">Statistik Santri Aktif
      </h3>
    </div>
    <div class="box-body">
      <table class="table-bordered table">
        <tr class='bg-blue'>
          <th rowspan='2' style="vertical-align: middle;">Nama Lembaga</th>
          <th colspan='2'>Jumlah</th>
          <th rowspan='2' style="vertical-align: middle;">Total</th>
          <th rowspan='2' style="vertical-align: middle;"></th>
        </tr>
        <tr class='bg-blue'>
          <th>TPQA</th>
          <th>TPQD</th>          
        </tr>
        @foreach ($students as $key=>$student)                
        <tr>
          <td>
            <a href="/admin/institutions/{{ $student[0]->institution->slug }}"><b>{{ $student[0]->institution->name }}</b>
          </td>
          <td class="text-right">
            {{ number_format($tpqa_sum[] = $student->where('group_id',1)->count(),0,',','.') }}
          </td>
          <td class="text-right">
            {{ number_format($tpqd_sum[] = $student->where('group_id',3)->count(),0,',','.') }}
          </td>
          <td class="text-right">
            {{ number_format($total_sum[] = $student->count(),0,',','.') }}
          </td>
          <td>
            <button id="show-arc" class="btn btn-xs btn-primary" data-institution_id="all" data-stage_id = "{{ $students }}" ><i class="fa fa-eye"></i></button>
          </td>
        </tr>
        @endforeach                
        <tr class='bg-blue'>
          <th class="text-right">TOTAL</th>
          <th class="text-right">{{  number_format(array_sum($tpqa_sum),0,',','.') }}</th>          
          <th class="text-right">{{  number_format(array_sum($tpqd_sum),0,',','.') }}</th>          
          <th class="text-right">{{  number_format(array_sum($total_sum),0,',','.') }}</th> 
          <th></th>          
        </tr>
      </table>            
    </div>
  </div>
</div>