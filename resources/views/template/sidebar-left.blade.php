<section class="sidebar">

  @if (Auth::check())
    <div class="user-panel">
      <div class="pull-left image">      
        <img src=
        @if (Auth::user()->userProfile) 
          '/assets/profiles/{{ Auth::user()->userProfile->image }}'
        @else 
          '/assets/profiles/default.jpg' @endif class="img-circle" alt="User Image" />
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->name }}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>


    
    <ul class="sidebar-menu">

      <li class="header">MAIN NAVIGATION</li>     
      
      <li @if(\Request::is('home','p-home')) class='active' @endif>
        @if (Auth::check()) <a href="/home"> @else <a href="/p-home"> @endif
          <i class="fa fa-dashboard"></i> 
            <span>Dashboard</span>
        </a>
      </li>
      
      <li @if(\Request::is('institutions')) class='active' @endif>
        <a href="/admin/institutions">
          <i class="fa fa-university"></i> <span>Lembaga</span>
        </a>
      </li>      

      <li @if(\Request::is('persons')) class='active' @endif>
        <a href="/admin/persons">
          <i class="fa fa-vcard-o"></i> <span>Pengurus</span>
        </a>
      </li>

      @can ('manage-classgroups')
        <li @if(\Request::is('admin/class-groups')) class='active' @endif>
          <a href="/admin/class-groups">
            <i class="fa fa-user-circle"></i> <span>Kelompok TPQ</span>
          </a>
        </li>
      @endcan

      <li @if(\Request::is('students')) class='active' @endif>
        <a href="/admin/students">
          <i class="fa fa-users"></i> <span>Santri</span>
        </a>
      </li>

      <li @if(\Request::is('achievements')) class='active' @endif>
        <a href="/admin/achievements">
          <i class="fa fa-bar-chart"></i> <span>Prestasi</span>
        </a>
      </li>     

      @can ('manage-almaruf_transactions')
        <li class="header">MONETIZING</li>  
        <li @if(\Request::is('transactions')) class='active' @endif>
          <a href="/admin/almaruf_transactions">
            <i class="fa fa-money"></i> <span>Transaksi</span>
          </a>
        </li>
      @endcan


      @can ('manage-users')
        <li class="header">USER MANAGEMENT</li>  
        <li  @if(\Request::is('admin/users')) class='active' @endif >
          <a href="/admin/users">
            <i class="fa fa-users"></i> <span>Users</span>
          </a>
        </li> 
      @endcan       

    </ul>
  
  @else

    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>     
      
      <li @if(\Request::is('p-home')) class='active' @endif>
        <a href="/p-home">
          <i class="fa fa-dashboard"></i> 
            <span>Dashboard</span>
        </a>
      </li>

      <li @if(\Request::is('institutions')) class='active' @endif>
        <a href="/institutions">
          <i class="fa fa-university"></i> <span>Lembaga</span>
        </a>
      </li>

      <li @if(\Request::is('persons')) class='active' @endif>
        <a href="/persons">
          <i class="fa fa-vcard-o"></i> <span>Pengurus</span>
        </a>
      </li>      

      <li @if(\Request::is('students')) class='active' @endif>
        <a href="/students">
          <i class="fa fa-users"></i> <span>Santri</span>
        </a>
      </li>

<!--       <li @if(\Request::is('achievements')) class='active' @endif>
        <a href="/achievements">
          <i class="fa fa-bar-chart"></i> <span>Prestasi</span>
        </a>
      </li> -->
  @endif

</section>