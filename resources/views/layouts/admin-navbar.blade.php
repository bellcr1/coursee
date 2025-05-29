<div class="main-header">
  <div class="main-header-logo">
    <div class="logo-header" data-background-color="dark">
      <a href="../index.html" class="logo">
        <img src="../assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20" />
      </a>
      <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
        <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
      </div>
      <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
    </div>
  </div>
  
  <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">
      <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
        <form action="{{ route('admin.contracts.index') }}" method="GET">
            <div class="input-group">
                <div class="input-group-prepend">
                    <button type="submit" class="btn btn-search pe-1">
                        <i class="fa fa-search search-icon"></i>
                    </button>
                </div>
                <input type="text" name="search" placeholder="Search contracts..." class="form-control" 
                       value="{{ request('search') }}">
            </div>
        </form>
      </nav>
      
      <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" 
             aria-expanded="false" aria-haspopup="true">
              <i class="fa fa-search"></i>
          </a>
          <ul class="dropdown-menu dropdown-search animated fadeIn">
              <form action="{{ route('admin.contracts.index') }}" method="GET" class="navbar-left navbar-form nav-search">
                  <div class="input-group">
                      <input type="text" name="search" placeholder="Search contracts..." class="form-control" 
                             value="{{ request('search') }}">
                  </div>
              </form>
          </ul>
      </li>
      <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
        <li class="nav-item dropdown hidden-caret">
          <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-bell"></i>
            <span class="notification">4</span>
          </a>
          <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
            <li>
              <div class="dropdown-title">You have 4 new notifications</div>
            </li>
            <li>
              <div class="notif-scroll scrollbar-outer">
                <div class="notif-center">
                  <a href="#">
                    <div class="notif-icon notif-primary"> <i class="fa fa-user-plus"></i> </div>
                    <div class="notif-content">
                      <span class="block"> New user registered </span>
                      <span class="time">5 minutes ago</span> 
                    </div>
                  </a>
                </div>
              </div>
            </li>
          </ul>
        </li>
        
        <li class="nav-item dropdown hidden-caret">
          <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-envelope"></i>
          </a>
          <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="messageDropdown">
            <li>
              <div class="dropdown-title">You have 3 new messages</div>
            </li>
          </ul>
        </li>
        
        <li class="nav-item topbar-user dropdown hidden-caret">
    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
        <div class="avatar-sm">
            @if(Auth::user()->image)
                <img src="{{ asset(Auth::user()->image) }}" alt="..." class="avatar-img rounded-circle">
            @else
                <img src="../assets/img/1.png" alt="..." class="avatar-img rounded-circle">
            @endif
        </div>
        <span class="profile-username">
            <span class="op-7">Hi,</span>
            <span class="fw-bold">{{ Auth::user()->name }}</span>
        </span>
    </a>
    <ul class="dropdown-menu dropdown-user animated fadeIn">
        <div class="dropdown-user-scroll scrollbar-outer">
            <li>
                <div class="user-box">
                    <div class="avatar-lg">
                        @if(Auth::user()->image)
                            <img src="{{ asset(Auth::user()->image) }}" alt="image profile" class="avatar-img rounded">
                        @else
                            <img src="../assets/img/profile.jpg" alt="image profile" class="avatar-img rounded">
                        @endif
                    </div>
                    <div class="u-text">
                        <h4>{{ Auth::user()->name }}</h4>
                        <p class="text-muted">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </li>
            <li>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('profile.edit', Auth::user()->id) }}">
                    My Profile
                </a>
                <div class="dropdown-divider"></div>
                
               
                <a class="dropdown-item" href="{{ route('home') }}">
                    <i class="fa fa-home me-1"></i> Go to Home
                </a>
                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </div>
    </ul>
</li>

      </ul>
    </div>
  </nav>
</div>