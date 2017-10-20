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
                    <button id="show-arc" class="btn btn-xs btn-primary" data-stage_id = "{{ $achievement[0]->stage->id }}" ><i class="fa fa-eye"></i></button>
                  </td>
                </tr>
                @endforeach                
              </table>  