@extends('template.layout')

@section('header-scripts')
@endsection

@section('footer-scripts')
@endsection 

@section('content-top')
  <h1>TPQ {{ $institution->name }}</h1>
@endsection

@section('content-main')
  <div class="row">  
    <div class="col-md-8">
      <div class="box box-primary">
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <table class="table table-bordered">
                <tr>
                  <th>Tanggal berdiri :</th>
                  <td>{{ $institution->established_date ? \Carbon\Carbon::parse($institution->established_date)->format('d-M-Y') : '...' }}</td>
                </tr>
                <tr>
                  <th>Kepala TPQ :</th>
                  <td>{{ $institution->theheadmaster->name }}</td>
                </tr>
                <tr>
                  <th>Alamat :</th>
                  <td>{{ $institution->address }}</td>
                </tr>
                <tr>
                  <th>Wilayah :</th>
                  <td>{{ $institution->region->name }} </td>
                </tr>
                <tr>
                  <th>Ustadz/ah:</th>
                  <td>
                    <ul>
                      @foreach($institution->mainTeacher as $teacher)
                        <li>{{ $teacher->name }}</li>
                      @endforeach
                    </ul>
                  </td>
                </tr>
              </table>
            </div>
        </div>        
      </div>
    </div>
  </div>

@endsection	


