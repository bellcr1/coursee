<div class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
    <div class="logo-header" data-background-color="dark">
      <a href="{{ url('/') }}" class="logo">
        <img src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand" height="20" />
      </a>
      <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
        <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
      </div>
      <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
    </div>
  </div>

  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-secondary">

        {{-- Statistics --}}
        <li class="nav-item submenu {{ request()->routeIs('stats.page') ? 'active' : '' }}">
          <a data-bs-toggle="collapse" href="#stats" {{ request()->routeIs('stats.page') ? 'aria-expanded=true' : 'class=collapsed' }}>
            <i class="fas fa-chart-bar"></i>
            <p>Statistics</p>
            <span class="caret"></span>
          </a>
          <div class="collapse {{ request()->routeIs('stats.page') ? 'show' : '' }}" id="stats">
            <ul class="nav nav-collapse">
              <li class="{{ request()->routeIs('stats.page') ? 'active' : '' }}">
                <a href="{{ route('stats.page') }}">
                  <span class="sub-item">Overview</span>
                </a>
              </li>
            </ul>
          </div>
        </li>


        <li class="nav-item submenu {{ request()->routeIs('admin.payment.dashbordpayment') ? 'active' : '' }}">
          <a data-bs-toggle="collapse" href="#Transactions" {{ request()->routeIs('admin.payment.dashbordpayment') ? 'aria-expanded=true' : 'class=collapsed' }}>
         <i class="fas fa-money-check-alt"></i>
         <p>Transaction Management</p>
         <span class="caret"></span>
          </a>
            <div class="collapse {{ request()->routeIs('admin.payment.dashbordpayment') ? 'show' : '' }}" id="Transactions">
                <ul class="nav nav-collapse">
                    <li  class="{{ request()->routeIs('admin.payment.dashbordpayment') ? 'active' : '' }}">
                        <a href="{{ route('admin.payment.dashbordpayment')  }}">
                            <span class="sub-item">Transactions List</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- User Management --}}
        <li class="nav-item submenu {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          <a data-bs-toggle="collapse" href="#users" {{ request()->routeIs('admin.dashboard') ? 'aria-expanded=true' : 'class=collapsed' }}>
            <i class="fas fa-users"></i>
            <p>User Management</p>
            <span class="caret"></span>
          </a>
          <div class="collapse {{ request()->routeIs('admin.dashboard') ? 'show' : '' }}" id="users">
            <ul class="nav nav-collapse">
              <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                  <span class="sub-item">Users List</span>
                </a>
              </li>
            </ul>
          </div>
        </li>


        <li class="nav-item submenu {{ request()->routeIs('admin.certificate') ? 'active' : '' }}">
          <a data-bs-toggle="collapse" href="#Certificates" {{ request()->routeIs('admin.certificate') ? 'aria-expanded=true' : 'class=collapsed' }}>
              <i class="fas fa-certificate"></i>
              <p>Certificat Management</p>
              <span class="caret"></span>
          </a>
          <div class="collapse {{ request()->routeIs('admin.certificate') ? 'show' : '' }}" id="Certificates">
              <ul class="nav nav-collapse">
                  <li class="{{ request()->routeIs('admin.certificate') ? 'active' : '' }}">
                      <a href="{{ route('admin.certificate') }}">
                          <span class="sub-item">Certificates List</span>
                      </a>
                  </li>
              </ul>
          </div>
      </li>

        {{-- Category Management --}}
        <li class="nav-item submenu {{ request()->routeIs('categories.index') ? 'active' : '' }}">
          <a data-bs-toggle="collapse" href="#categories" {{ request()->routeIs('categories.index') ? 'aria-expanded=true' : 'class=collapsed' }}>
            <i class="fas fa-list-alt"></i>
            <p>Category Management</p>
            <span class="caret"></span>
          </a>
          <div class="collapse {{ request()->routeIs('categories.index') ? 'show' : '' }}" id="categories">
            <ul class="nav nav-collapse">
              <li class="{{ request()->routeIs('categories.index') ? 'active' : '' }}">
                <a href="{{ route('categories.index') }}">
                  <span class="sub-item">Categories List</span>
                </a>
              </li>
            </ul>
          </div>
        </li>

        {{-- Contact Messages --}}
        <li class="nav-item submenu {{ request()->routeIs('admin.contacts.index') ? 'active' : '' }}">
          <a data-bs-toggle="collapse" href="#contacts" {{ request()->routeIs('admin.contacts.index') ? 'aria-expanded=true' : 'class=collapsed' }}>
            <i class="fas fa-envelope"></i>
            <p>Contact Messages</p>
            <span class="caret"></span>
          </a>
          <div class="collapse {{ request()->routeIs('admin.contacts.index') ? 'show' : '' }}" id="contacts">
            <ul class="nav nav-collapse">
              <li class="{{ request()->routeIs('admin.contacts.index') ? 'active' : '' }}">
                <a href="{{ route('admin.contacts.index') }}">
                  <span class="sub-item">Messages List</span>
                </a>
              </li>
            </ul>
          </div>
        </li>

        {{-- Feedback Management --}}
        <li class="nav-item submenu {{ request()->routeIs('admin.feedback.index') ? 'active' : '' }}">
          <a data-bs-toggle="collapse" href="#feedback" {{ request()->routeIs('admin.feedback.index') ? 'aria-expanded=true' : 'class=collapsed' }}>
            <i class="fas fa-comments"></i>
            <p>Feedback Management</p>
            <span class="caret"></span>
          </a>
          <div class="collapse {{ request()->routeIs('admin.feedback.index') ? 'show' : '' }}" id="feedback">
            <ul class="nav nav-collapse">
              <li class="{{ request()->routeIs('admin.feedback.index') ? 'active' : '' }}">
                <a href="{{ route('admin.feedback.index') }}">
                  <span class="sub-item">Feedback List</span>
                </a>
              </li>
            </ul>
          </div>
        </li>

        {{-- Contract Management --}}
        <li class="nav-item submenu {{ request()->routeIs('admin.contracts.index') ? 'active' : '' }}">
          <a data-bs-toggle="collapse" href="#contracts" {{ request()->routeIs('admin.contracts.index') ? 'aria-expanded=true' : 'class=collapsed' }}>
            <i class="fas fa-file-contract"></i>
            <p>Contract Management</p>
            <span class="caret"></span>
          </a>
          <div class="collapse {{ request()->routeIs('admin.contracts.index') ? 'show' : '' }}" id="contracts">
            <ul class="nav nav-collapse">
              <li class="{{ request()->routeIs('admin.contracts.index') ? 'active' : '' }}">
                <a href="{{ route('admin.contracts.index') }}">
                  <span class="sub-item">Contracts List</span>
                </a>
              </li>
              
            </ul>
          </div>
        </li>

      

      </ul>
    </div>
  </div>
</div>
