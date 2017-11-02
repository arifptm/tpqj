


      <div class="box-header with-border"> 
        <h3 class="box-title">Riwayat Belajar
          <span class="btn btn-xs btn-primary"><i class="fa fa-plus-circle"></i> <b>Tambah baru</b></span></h3></h3>
      </div>
      <div class="box-body"> 
        <table class="table table-bordered table-condensed">
          <tr class="bg-blue">
            
            <th>Tanggal</th>
            <th>Jilid</th>
            <th>Waktu</th>
            <th style="width:40px;text-align: center;"><i class="fa fa-ellipsis-v"></i></th>
          </tr>
          @if (count($achievements) > 0 )
            @foreach($achievements as $key=>$achievement)
              <tr>              
                <td>{{ $achievements[$key]->achievement_date->format('d-M-y') }} </td>
                <td>{{ $achievements[$key]->stage->name }} </td>
                <td>{{ $achievements[$key]->duration }} </td>    
                <td class="text-center">
                  <div class="dropdown">
                    <a href="#" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                      <div class="btn-group">
                        <button class="btn btn-sm edit-achievement" data-id="{{ $achievement->id }}" data-achievement_date="{{ $achievements[$key]->achievement_date->format('d-m-Y') }}" data-stage_id ="{{ $achievements[$key]->stage->id }}" data-student_id="{{ $achievement->student->id }}"><i class="fa fa-edit"></i> Edit</button>
                        <button id='btn-delete-institution' class='btn btn-danger btn-sm ' data-id="">
                          <i class='glyphicon glyphicon-trash'></i> Hapus
                        </button>                        
                      </div>
                    </div>
                  </div>
                </td>                            
              </tr>
            @endforeach
          @endif
        </table>  
      </div>

