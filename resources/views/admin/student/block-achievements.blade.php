


      <div class="box-header with-border"> 
        <h3 class="box-title">Riwayat Belajar
          <button id="btn-modal-create-achievement" class="btn btn-xs btn-primary"><i class="fa fa-plus-circle"></i> <b>Tambah baru</b></button>
        </h3>
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
                <td>{{ $achievements[$key]->stage->name }} 
                  @if ($achievements[$key]->notes)
                    <span data-toggle="tooltip" title="{{ $achievements[$key]->notes }}"> <i class="fa fa-info-circle"></i></span>
                  @endif
                </td>
                <td>{{ $achievements[$key]->duration }} </td>    
                <td class="text-center">
                  <div class="dropdown">
                    <a href="#" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                      <div class="btn-group">
                        <button class="btn btn-sm edit-achievement" data-id="{{ $achievement->id }}" data-achievement_date="{{ $achievements[$key]->achievement_date->format('d-m-Y') }}" data-stage_id ="{{ $achievements[$key]->stage->id }}" data-stid="{{ $achievement->student->id }}"><i class="fa fa-edit"></i> Edit</button>
                        <button class='btn-delete-achievement btn btn-danger btn-sm ' data-id="{{ $achievement->id }}">
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

