<div class="col-md-12">
  <div class="box">    
    <div class="box-header">
      <h3 class="box-title">Jumlah Santri per kelas 
        @if (Auth::user()->institution->count()  == 1 )TPQ {{ Auth::user()->institution[0]->name  }} 
        @endif  
      </h3>
    </div>
    <div class="box-body ">
      <div class="row">
        <div class="icheck"> 
          <div class="form-group">
            @foreach ($institutions->chunk(1) as $chunk)            
              @foreach ($chunk as $institution)
                <div class="col-md-6">
                  {!! Form::checkbox('chosen_institution[]', $institution->id, false,  ['id'=>$institution->slug]) !!}
                  {!! Form::label( $institution->slug, $institution->name , ['class'=>'control-label']) !!}<br>
                </div>  
              @endforeach           
            @endforeach
          </div>
        </div>        
      </div>
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

<script>
    $('input[type="checkbox"], input[type="radio"]').iCheck({
      checkboxClass: 'icheckbox_flat-purple',
      radioClass   : 'iradio_flat-purple'
    });

    $(document).on('ifChecked ifUnchecked', '[name="chosen_institution[]"]', function() {         
      var vins = institutionFilter()
      $datatable.ajax.url( '/data/achievements/'+vins+'/all' ).load();
      $('#show-arc, #btn-modal-edit').attr('data-institution_id', vins);
      $('#achievement-stat').load('/admin/data/block-achievement-statistic/'+vins);
    });

</script>