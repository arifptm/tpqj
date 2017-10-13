@extends('template.layout')

@section('header-scripts')
@endsection

@section('footer-scripts')
@endsection 

@section('content-top')
  <h1>Profile Pengguna</h1>
@endsection

@section('content-main')
<div class="row">
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-body">          
        <img class="img-circle img-responsive profile-user-img" src="/images/profiles/b/{{ $user->userProfile->image }}" alt="">
        <h3 class="profile-username text-center">{{ $user->name}} </h3>
        <ul class="list-group list-group-unbordered">
          <li class="list-group-item">
            <b>Email</b> <span class="pull-right">{{ $user->email }}</span>
          </li>          
          <li class="list-group-item">
            <b>Status</b> <a class="pull-right">
                @if ($user->verified == 1)
                  <span class="badge bg-blue">Active</span>
                @else
                  <span class="badge bg-orange">Pending</span>
                @endif</a>
          </li>
          
        </ul>
        <a href="/admin/users/{{$user->id}}/edit" class="btn btn-block btn-primary">Edit User</a>
      </div>
    </div>
  </div>
</div>
@endsection	


