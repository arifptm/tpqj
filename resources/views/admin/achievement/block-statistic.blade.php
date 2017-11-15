<div class="box-body">  
  <table class="table-bordered table">
    <tr class='bg-blue'>
      <th>Kelas</th>
      <th>Jumlah</th>
    </tr>
    @foreach ($achievements as $key=>$achievement)                
    <tr>
      <td>
        {{ $achievement[0]->stage->name }}
      </td>
      <td>
        <a id="show-arc" href="#" data-institution_id="default" data-stage_id = "{{ $achievement[0]->stage->id }}">  
          <b>{{ ($achievement->count()) }}</b> orang
        </a>
      </td>
    </tr>
    @endforeach                
  </table>            
</div>