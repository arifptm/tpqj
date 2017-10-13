<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" href="/favicon.ico">
  <title>{{ config('app.name') }}</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
  
  @yield('header-scripts')
  <link rel="stylesheet" href="/bower_components/AdminLTE/dist/css/AdminLTE.min.css"> 
  <link rel="stylesheet" href="/bower_components/AdminLTE/dist/css/skins/skin-purple.min.css"> 
  <link rel="stylesheet" href="/css/custom.css">
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body class="hold-transition skin-purple fixed sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    @include('template.header')
  </header>

  <aside class="main-sidebar">
  @include('template.sidebar-left')
  </aside>

  <div class="content-wrapper">

    <section class="content-header">
      @yield('content-top')
    </section>

    <section class="content">
      @yield('content-main')
    </section>

  </div>

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      by <a href="http://goried.com"><b>Goried</b> Studio</a>
    </div>
    <strong>Copyright &copy; {{ \Carbon\Carbon::parse()->format('Y') }} <a href="http://logistiktedi.com">Logistik TEDi</a></strong>&nbsp; :: &nbsp;  All rights
    reserved.
  </footer>
</div>

<script src="/bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
<script src="/bower_components/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="/bower_components/AdminLTE/plugins/fastclick/fastclick.js"></script>
<script src="/bower_components/AdminLTE/dist/js/app.min.js"></script>
<!-- <script src="/bower_components/AdminLTE/dist/js/demo.js"></script> -->
@yield('footer-scripts')
</body>
</html>
