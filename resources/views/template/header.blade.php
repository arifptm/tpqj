    <a href="/" class="logo">
      <span class="logo-mini"><b>QD</b></span>
      <span class="logo-lg"><b>Qiraati</b> DIY</span>
    </a>
    
    <nav class="navbar navbar-static-top">
    
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          @if (Auth::check() AND Auth::user()->verified == 1)
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="hidden-xs">@auth {{ Auth::user()->name }} @endauth</span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src=
                    @if (Auth::user()->userProfile) 
                      '/assets/profiles/{{ Auth::user()->userProfile->image }}'
                    @else 
                      '/assets/profiles/default.jpg' @endif class="img-circle" alt="User Image" />
                  <p>
                      
                        {{ Auth::user()->institution[0]->name }}
                        @if (Auth::user()->institution->count() > 1) 
                          dan {{Auth::user()->institution->count()-1 }} lainnya
                        @endif
                      @if (Auth::user()->roles->count()) -
                        @foreach(Auth::user()->roles as $role) {{ $role->name }}  @endforeach
                      @endif
                    <small>Terdaftar : {{ Auth::user()->created_at->format('M. Y') }}</small>
                  </p>
                </li>

                <li class="user-footer">
                  <div class="pull-left">
                    <a href="/profile" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="pull-right">
                    <a class='btn btn-default btn-flat' href="{{ route('logout') }}" onclick="
                      event.preventDefault();
                      document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                  </div>
                </li>
              </ul>
            </li>
          @else
            <li>
              <a href="/login" class="btn bg-black">Login</a>
            </li>
          @endif
        </ul>
      </div>
    </nav>