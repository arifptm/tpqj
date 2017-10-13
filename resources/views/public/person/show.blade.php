@extends('template.layout')

@section('header-scripts')
@endsection

@section('footer-scripts')
@endsection 

@section('content-top')
  <h1>Data Pengurus</h1>
@endsection

@section('content-main')
<div class="row">
  <div class="col-md-3">
    <div class="box box-primary">
      <div class="box-body">          
        @if ($person->image)
          <img class="img-circle img-responsive profile-user-img" src="/imagecache/medium_sq/{{ $person->image }}" alt="">
        @else 
          <img class="img-circle img-responsive profile-user-img" src="/imagecache/medium_sq/default.jpg" alt="">
        @endif
        <h3 class="profile-username text-center">{{$person->name}}</h3>
        <h5 class="text-center">{{ $person->address }}</h5>
        <ul class="list-group list-group-unbordered">
          <li class="list-group-item">
            <b>No ID</b> <span class="pull-right">{{ $person->id }}</span>
          </li>
          <li class="list-group-item">
            <b>Terdaftar</b> <span class="pull-right">@if ($person->registered_date) {{ \Carbon\Carbon::parse($person->registered_date)->format('d-m-Y') }} @else ... @endif</span>
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
               @if ($person->stop_date)
                  <span class="badge bg-orange">Non Aktif</span>
                @else
                  <span class="badge bg-blue">Aktif</span>
                @endif
            </td>
          </tr>
          <tr>
            <th>Jenis kelamin</th>
            <td>
              @if ($person->gender == 'L')
                Laki-laki
              @else
                Perempuan
              @endif
            </td>
          </tr>
          <tr>
            <th>Nomor telepon</th>
            <td>{{ $person->phone or '...'}}</td>
          </tr>
          <tr>                      
            <th>Alamat</th>
            <td>{{ $person->address or '...' }}</td>
          </tr>
          <tr>
            <th>Lembaga utama</th>
            <td>TPQ {{ $person->mainInstitution[0]->name }}</td>
          </tr> 
          <tr>
            <th>Lembaga tambahan</th>
            <td>
              @if (count($person->extraInstitution) > 0 )
                @foreach ($person->extraInstitution as $ei)
                  TPQ {{ $ei->name }}<br>
                @endforeach
              @else
                ...
              @endif</td>
          </tr> 
        </table>
      </div>
    </div>
  </div>

</div>
@endsection 




@section('content-top')
  <h1>TPQ {{ $person->name }}

  </h1>
@endsection

@section('content-main')
  <div class="row">  
    <div class="col-md-2">
sadasdasd
    </div>
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <table class="table table-bordered">
                <tr>
                  <th>Tanggal terdaftar :</th>
                  <td>{{ $person->registered_date ? \Carbon\Carbon::parse($person->registered_date)->format('d-M-Y') : '...' }}</td>
                </tr>
                <tr>
                  <th>Nama :</th>
                  <td>{{ $person->name }}</td>
                </tr>
                <tr>
                  <th>NIP :</th>
                  <td>{{ $person->registration_number or '...' }}</td>
                </tr>
                <tr>
                  <th>Jenis Kelamin :</th>
                  <td>
                    @if ($person->gender == 'L') Laki-laki @else Perempuan @endif </td>
                </tr>
                <tr>
                  <th>Alamat :</th>
                  <td>{{ $person->address or '...' }} </td>
                </tr>
                <tr>
                  <th>Telepon :</th>
                  <td>                   
                    {{ $teacher->phone or '...' }}</li>
                  </td>
                </tr>
              </table>
            </div>
        </div>        
      </div>
    </div>
  </div>

@endsection	


