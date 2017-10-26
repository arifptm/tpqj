<div class="col-md-12">
  <div class="box">    
    <div class="box-header">
      <h3 class="box-title">Jumlah Santri per kelas 
        @if (Auth::user()->institution->count()  == 1 )TPQ {{ Auth::user()->institution[0]->name  }} 
        @endif  
      </h3>
    </div>
    <div class="box-body">
      <table class="table-bordered table">
        <tr class='bg-blue'>
          <th>Kelas</th>
          <th>Jumlah</th>
          <th>Lihat</th>
        </tr>
        @foreach ($achievements as $key=>$achievement)                
        <tr>
          <td>
            {{ $achievement[0]->stage->name }}
          </td>
          <td>
            {{ ($achievement->count()) }} orang
          </td>
          <td>
            <button id="show-arc" class="btn btn-xs btn-primary" data-institution_id="all" data-stage_id = "{{ $achievement[0]->stage->id }}" ><i class="fa fa-eye"></i></button>
          </td>
        </tr>
        @endforeach                
      </table>            
    </div>
  </div>
</div>