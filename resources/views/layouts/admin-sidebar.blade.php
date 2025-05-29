<div class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
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
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-secondary">
        <li class="nav-item active submenu">
          <a data-bs-toggle="collapse" href="#stats" class="collapsed" aria-expanded="false">
            <i class="fas fa-chart-bar"></i>
            <p>Statistics</p>
            <span class="caret"></span>
          </a>
          <div class="collapse show" id="stats">
            <ul class="nav nav-collapse">
              <li class="active">
                <a href="{{ route('stats.page') }}">
                  <span class="sub-item">Overview</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item submenu">
          <a data-bs-toggle="collapse" href="#users">
            <i class="fas fa-users"></i>
            <p>User Management</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="users">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{ route('admin.dashboard') }}">
                  <span class="sub-item">Users List</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item submenu">
          <a data-bs-toggle="collapse" href="#categories">
            <i class="fas fa-list-alt"></i>
            <p>Category Management</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="categories">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{ route('categories.index') }}">
                  <span class="sub-item">Categories List</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item submenu">
    <a data-bs-toggle="collapse" href="#contacts">
        <i class="fas fa-envelope"></i>
        <p>Contact Messages</p>
        <span class="caret"></span>
    </a>
    <div class="collapse" id="contacts">
        <ul class="nav nav-collapse">
            <li>
                <a href="{{ route('admin.contacts.index') }}">
                    <span class="sub-item">Messages List</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item submenu">
    <a data-bs-toggle="collapse" href="#feedback">
        <i class="fas fa-comments"></i>
        <p>Feedback Management</p>
        <span class="caret"></span>
    </a>
    <div class="collapse" id="feedback">
        <ul class="nav nav-collapse">
            <li>
                <a href="{{ route('admin.feedback.index') }}">
                    <span class="sub-item">Feedback List</span>
                </a>
            </li>
        </ul>
    </div>
</li>
        <li class="nav-item submenu">
          <a data-bs-toggle="collapse" href="#contracts">
            <i class="fas fa-file-contract"></i>
            <p>Contract Management</p>
            <span class="caret"></span>
          </a>
          <div class="collapse " id="contracts">
            <ul class="nav nav-collapse">
              <li>
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