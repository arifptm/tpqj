@extends('template.layout')

@section('header-scripts')
@endsection

@section('footer-scripts')
@endsection 

@section('content-top')
  <h1>Data Santri</h1>
@endsection

@section('content-main')
<div class="row">
  <div class="col-md-3">
    <div class="box box-primary">
      <div class="box-body">          
        @if ($student->image)
          <img class="img-circle img-responsive profile-user-img" src="/imagecache/medium_sq/{{ $student->image }}" alt="">
        @else 
          <img class="img-circle img-responsive profile-user-img" src="/imagecache/medium_sq/default.jpg" alt="">
        @endif
        <h3 class="profile-username text-center">{{$student->fullname}}</h3>   
        <h4><div class='text-center'>TPQ {{ $student->institution->name }}</div></h4>
        <ul class="list-group list-group-unbordered">
          <li class="list-group-item">
            <b>No ID</b> <span class="pull-right">{{ $student->id }}</span>
          </li>
          <li class="list-group-item">
            <b>Terdaftar</b> <span class="pull-right">@if ($student->registered_date) {{ \Carbon\Carbon::parse($student->registered_date)->format('d-m-Y') }} @else ... @endif</span>
          </li>
          <li class="list-group-item">
            <b>SPP Bulanan</b> <span class="pull-right">@if($student->tuition) Rp. {{ number_format($student->tuition,0, ',', '.')}} @else ... @endif</span>
          </li>
          <li class="list-group-item">
            <b>Sapras</b> <span class="pull-right">@if($student->infrastructure_fee) Rp. {{ number_format($student->infrastructure_fee,0,',','.') }} @else ... @endif</span>
          </li>                    
        </ul>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="box box-primary">
      <div class="box-header with-border"> 
        <h3 class="box-title">Data tambahan</h3>
      </div>
      <div class="box-body"> 
        <table class="table table-bordered">
          <tr>
            <th>Status</th>
            <td>
               @if ($student->stop_date)
                  <span class="badge bg-orange">Non Aktif</span>
                @else
                  <span class="badge bg-blue">Aktif</span>
                @endif
            </td>
          </tr>
          <tr>
            <th>Jenis kelamin</th>
            <td>
              @if ($student->gender == 'L')
                Laki-laki
              @else
                Perempuan
              @endif
            </td>
          </tr>
          @if ($student->class_group == 1)
          <tr>
            <th>Nama orang tua</th>
            <td>{{ $student->parent or '...'}}</td>
          </tr>          
          @endif
          <tr>                      
            <th>Alamat @if ($student->group_id == 1) Ortu @endif</th>
            <td>{{ $student->address or '...' }}</td>
          </tr>
          <tr>
            <th>Pekerjaan @if ($student->group_id == 1)Ortu @endif</th>
            <td>{{ $student->job or '...'}}</td>
          </tr>
          <tr>                      
            <th>No. telepon @if ($student->group_id == 1)Ortu @endif</th>
            <td>{{ $student->phone or '...' }}</td>
          </tr>
        </table>
      </div>        
      <hr>
      <div class="box-header with-border"> 
        <h3 class="box-title">Riwayat belajar</h3>
      </div>
      <div class="box-body"> 
        <table class="table table-bordered">
          <tr>
            <th>Kelas</th>
            <th>Selesai</th>
            <th>Durasi</th>
          </tr>
          @foreach($achievements as $achievement)
          <tr>
            <td>{{ $achievement->stage->name }}</td>            
            <td>
              @if($achievement->achievement_date)
                {{ \Carbon\Carbon::parse($achievement->achievement_date)->format('d-m-Y') }}
              @else 
                ...
              @endif
            </td>            
            <td>{{ $achievement->duration }}</td> 
          </tr>
          @endforeach
        </table>
      </div>
    </div>
  </div>

</div>
@endsection 