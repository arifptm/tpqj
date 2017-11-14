
    
    <div class="box-header">
      <h3 class="box-title">Statistik Santri TPQ DIY
      </h3>
    </div>
    <div class="box-body">
      <table class="table-bordered table">
        <tr class='bg-blue'>
          <th rowspan='2' class="text-center" style="vertical-align: middle;">Nama Lembaga</th>
          <th colspan='4' class="text-center">Jumlah</th>
          

        </tr>
        <tr class='bg-blue'>
          <th class="text-right">TPQ</th>
          <th class="text-right">TPQD</th>          
          <th class="text-right">Aktif</th>
          <th class="text-right">NoAkt</th>
        </tr>
        @foreach ($students as $key=>$student)                
        <tr>
          <td>
            <a href="#" class="class_group" data-id="1_3" data-ins_id="{{ $key }}" data-status="999"><b>{{ $student[0]->institution->name }}</b></a> 
          </td>
          <td class="text-right">
            <a href="#" class="class_group" data-id="1" data-ins_id="{{ $key }}" data-status="1"><b>{{ number_format($tpqa_sum[] = $student->where('stop_date',null)->where('group_id',1)->count(),0,',','.') }}</b></a>
          </td>
          <td class="text-right">
            <a href="#" class="class_group" data-id="3" data-ins_id="{{ $key }}" data-status="1"><b>{{ number_format($tpqd_sum[] = $student->where('stop_date',null)->where('group_id',3)->count(),0,',','.') }}</b></a>
          </td>
          <td class="text-right">
            <a href="#" class="class_group" data-id="1_3" data-ins_id="{{ $key }}" data-status="1"><b>{{ number_format($total_sum[] = $student->where('stop_date',null)->count(),0,',','.') }}</b></a>
          </td>
          <td class="text-right">
            <a href="#" class="class_group" data-id="1_3" data-ins_id="{{ $key }}" data-status="0"><b>{{ number_format($all_sum[] = ($student->count() - $student->where('stop_date',null)->count()),0,',','.') }}</b></a>            
          </td>
        </tr>
        @endforeach                
        <tr class='bg-blue'>
          <th class="text-right">TOTAL</th>
          <th class="text-right">{{  number_format(array_sum($tpqa_sum),0,',','.') }}</th>          
          <th class="text-right">{{  number_format(array_sum($tpqd_sum),0,',','.') }}</th>          
          <th class="text-right">{{  number_format(array_sum($total_sum),0,',','.') }}</th> 
          <th class="text-right">{{  number_format(array_sum($all_sum),0,',','.') }}</th> 
        </tr>
      </table>            
    </div>
