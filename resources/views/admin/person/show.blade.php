@extends('template.layout')

@section('header-scripts')
@endsection

@section('footer-scripts')
@endsection 

@section('content-top')
  <h1>Data Pengurus</h1>
@endsection

@section('content-main')
    <div class="box box-primary">
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <table class="table table-bordered">
              <tr>
                <th>Nomor Induk :</th>
                <td>{{ $person->id or '...'}}</td>
              </tr>
              <tr>
                <th>Nama Lengkap :</th>
                <td>{{ $person->name}}</td>
              </tr>
              <tr>
                <th>Tanggal terdaftar :</th>
                <td>{{ $person->registration_date ? \Carbon\Carbon::parse($person->registration_date)->format('d M y') : '...' }}</td>
              </tr>
              <tr>
                <th>Jenis kelamin :</th>
                <td>
                  @if ($person->gender == 'L')
                    Laki-laki
                  @elseif ($person->gender == 'P')
                    Perempuan
                  @endif
                </td>
              </tr>
              <tr>
                <th>Alamat :</th>
                <td>{{ $person->address or '...' }}</td>
              </tr>
              <tr>
                <th>Telepon :</th>
                <td>{{ $person->phone or '...'}}</td>
              </tr>
              <tr>
                <th>Lembaga</th>
                <td>{{ $person->mainInstitution[0]->name }}</td>
              </tr>
            </table>
          </div>
      </div>        
    </div>
@endsection 
