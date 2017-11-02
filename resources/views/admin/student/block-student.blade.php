<div class="box-body">          
        @if ($student->image)
          <img class="img-circle img-responsive profile-user-img" src="/imagecache/medium_sq/{{ $student->image }}" alt="">
        @else 
          <img class="img-circle img-responsive profile-user-img" src="/imagecache/medium_sq/default.jpg" alt="">
        @endif
        <h3 class="profile-username text-center">{{$student->fullname}}</h3>
        <h5 class="text-center">{{ $student->address }}</h5>
        <ul class="list-group list-group-unbordered">
          
            <div id ="student_id" class="hidden">{{ $student->id }}</div>
          
          <li class="list-group-item">
            <b>Nama panggilan</b> <span class="pull-right">{{ $student->nickname or '...' }}</span>
          </li>
          <li class="list-group-item">
            <b>Tempat lahir</b> <span class="pull-right">{{ $student->birth_place or '...' }}</span>
          </li>
          <li class="list-group-item">
            <b>Tanggal lahir</b> <span class="pull-right">@if($student->birth_date != null){{ $student->birth_date->format('d-m-Y') }} 
              / {{ $student->birth_date->diffInYears() }} tahun @else ... @endif</span>
          </li>
          <li class="list-group-item">
            <b>Pendaftaran</b> <span class="pull-right">{{ \Carbon\Carbon::parse($student->registered_date)->format('d-m-Y') }}</span>
          </li>
          <li class="list-group-item">
            <b>Status</b> <a class="pull-right">
                @if ($student->stop_date)
                  <span class="badge bg-orange">Non Aktif</span>
                @else
                  <span class="badge bg-blue">Aktif</span>
                @endif</a>
          </li>
          <li class="list-group-item">
            <b>Kelompok</b> <span class="pull-right">{{ $student->group->description }}</span>
          </li>
        </ul>
        <a href="/admin/students/{{$student->id}}/edit" class="btn btn-sm btn-block btn-primary"><b>Update data siswa</b></a>