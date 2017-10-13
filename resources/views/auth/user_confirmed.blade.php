@extends('auth.template')

@section('page-title')
Logistik TEDi
@endsection

@section('content')
<div class="login-box">
  <div class="login-logo">
    <a href="/">Logistik <b>TEDi</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg lead">Pendaftaran telah disetujui</p>
    <p class="text-center">Silakan klik tombol berikut untuk login</p>
     <a href="{{url('/login')}}" class="btn btn-block btn-primary btn-lg">Login</a>
  </div>
</div>
@endsection