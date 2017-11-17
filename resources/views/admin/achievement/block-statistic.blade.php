<div class="box-body">  
  <table class="table-bordered table-condensed table">
    <tr class='bg-blue'>
      <th>Kelas</th>
      <th class="text-right">TPQ</th>
      <th class="text-right">TPQD</th>
      <th class="text-right">Jumlah</th>
    </tr>
    @foreach($achievements as $k=>$achievement)
      @if($achievement['stage_id'] != 19 AND $achievement['stage_id'] != 21)
      <tr>
        <td>
          {{ $achievement['stage'] }}
        </td>
        <td class="text-right">

            @if ($achievement['tpqa'] != '0' )
              <a class="show-arc" href="#"  data-institution_id="{{ $ins }}" data-group = "1" data-stage_id = "{{ $achievement['stage_id'] }}">  
              <b>{{ number_format(($ca[] = $achievement['tpqa']), 0, ',', '.') }}</b>
              </a>
            @else - @php ($ca[]='0') @endif

        </td>
        <td class="text-right">
          @if ($achievement['tpqd'] != '0' )
            <a class="show-arc" href="#"  data-institution_id="{{ $ins }}" data-group = "3" data-stage_id = "{{ $achievement['stage_id'] }}">  
              <b>{{ number_format(($cd[] = $achievement['tpqd']), 0, ',', '.') }}</b>
            </a>          
          @else - @php ($cd[]='0') @endif            
        </td>          
        <td class="text-right">
          @if (($achievement['tpqd'] + $achievement['tpqa']) != '0' )
          <a class="show-arc" href="#"  data-institution_id="{{ $ins }}" data-group = "1_3" data-stage_id = "{{ $achievement['stage_id'] }}">
            <b>{{ number_format( ($ct[] = ($achievement['tpqa'] + $achievement['tpqd'])), 0, ',', '.') }}</b>
          </a>
          @else - @php ($ct[]='0') @endif   
        </td>
      </tr>
      @endif
    
    @endforeach  
                     
    <tr class='bg-blue'>
      <th>Jumlah Total</th>
      <th class="text-right">{{ array_sum($ca) }}</th>
      <th class="text-right">{{ array_sum($cd) }}</th>
      <th class="text-right">{{ array_sum($ct) }}</th>
    </tr>  

  </table>            
</div>