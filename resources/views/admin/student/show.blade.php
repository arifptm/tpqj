@extends('template.layout')

@section('header-scripts')
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/flat/purple.css">
@endsection

@section('footer-scripts')
  <script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>

  <script>
    $('input[type="checkbox"], input[type="radio"]').iCheck({
      checkboxClass: 'icheckbox_flat-purple',
      radioClass   : 'iradio_flat-purple'
    }); 
  </script>

  <script>
    $(document).on('click', '.edit-achievement', function() {    
      $("#achievement_date").val($(this).data('achievement_date'));
      var student_stage_id = $(this).data('stage')      
      $("input[name='stage_id'][value='"+student_stage_id+"']").iCheck('check');      
      $("#notes").val($(this).data('notes'));      
      $('#achievement-modal').modal('show');
    });
  </script>

  <script>
    $('#submit-edit-achievement').click(function(){
      
    });
    
  </script>


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
        <h5 class="text-center">{{ $student->address }}</h5>
        <ul class="list-group list-group-unbordered">
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
        <a href="/admin/students/{{$student->id}}/edit" class="btn btn-block btn-primary">Edit User</a>
      </div>
    </div>
  </div>

   <div class="col-md-4">
    <div class="box box-primary">
      <div class="box-header with-border"> 
        <h3 class="box-title">Riwayat Belajar</h3>
      </div>
      <div class="box-body"> 
        <table class="table table-bordered table-condensed">
          <tr>
            <th></th>
            <th>Tanggal</th>
            <th>Jilid</th>
            <th>Waktu</th>
          </tr>
          @if (count($achievements) > 0 )
            @foreach($achievements as $key=>$achievement)
              <tr>
                <td><button class="btn btn-primary btn-xs edit-achievement" data-id="{{ $student->id }}" data-achievement_date="{{ $achievements[$key]->achievement_date->format('d-m-Y') }}" data-stage={{ $achievements[$key]->stage->id }}><i class="fa fa-edit"></i></button></td>
                <td>{{ $achievements[$key]->achievement_date->format('d-M-y') }} </td>
                <td>{{ $achievements[$key]->stage->name }} </td>
                <td>{{ $achievements[$key]->duration }} </td>                
              </tr>
            @endforeach
          @endif
        </table>
        
      </div>
    </div>
  </div>


  <div class="col-md-5">
    <div class="box box-primary">
      <div class="box-header with-border"> 
        <h3 class="box-title">Riwayat Transaksi</h3>
        <span class="h3"><span class="label bg-black label-lg pull-right"><small>Total:</small> {{ number_format($student->transaction()->sum('amount'),0,',','.') }}</span></span>

      </div>
      <div class="box-body"> 
        <table class="table table-bordered table-condensed">
          <tr>
            <th></th>
            <th>Tanggal</th>
            <th>Transaksi</th>
            <th>Jumlah</th>
          </tr>

          @foreach($student->transaction as $transaction)
            <tr>
              <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d-M-y') }}</td>
              <td>{{ $transaction->transactionType->name }} {{ $transaction->tuition_month ? \Carbon\Carbon::parse($transaction->tuition_month)->format('M Y') : '' }}</td>
              <td>{{ number_format($transaction->amount,0,',','.') }}</td>
            </tr>
          @endforeach
        </table>
        
        
      </div>
    </div>
  </div>
  @include('/admin/student/modal-achievement')

</div>
@endsection	


