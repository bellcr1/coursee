@php
use Illuminate\Support\Facades\Auth;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["{{ asset('assets/css/fonts.min.css') }}"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <style>
        .user-form-card {
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: none;
            overflow: hidden;
        }
        
        .user-form-card .card-header {
            background: linear-gradient(120deg, #6777ef 0%, #3519db 100%);
            color: white;
            padding: 1.75rem 2rem;
            border-bottom: 0;
        }
        
        .user-form-card .card-header h4 {
            font-weight: 600;
            margin-bottom: 0;
            display: flex;
            align-items: center;
        }
        
        .user-form-card .card-body {
            padding: 2.5rem;
        }
        
        .form-section {
            margin-bottom: 1.75rem;
            padding-bottom: 1.75rem;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #4a4a4a;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 0.75rem;
            color: #6777ef;
        }
        
        .img-preview-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-top: 1rem;
        }
        
        .img-preview {
            max-width: 150px;
            border-radius: 8px;
            border: 1px solid #e3e3e3;
            padding: 4px;
            margin-top: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .action-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f0f0f0;
        }
        
        .custom-file-label::after {
            content: "Browse";
        }
        
        .form-group label {
            font-weight: 500;
            color: #555;
            margin-bottom: 0.5rem;
        }
        
        .form-control {
            border-radius: 6px;
            padding: 0.75rem 1rem;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: #6777ef;
            box-shadow: 0 0 0 0.2rem rgba(103, 119, 239, 0.25);
        }
        
        .is-invalid {
            border-color: #f1556c;
        }
        
        .invalid-feedback {
            font-size: 0.85rem;
            margin-top: 0.35rem;
        }
        
        .btn {
            border-radius: 6px;
            padding: 0.65rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn i {
            margin-right: 0.5rem;
        }
        
        .btn-primary {
            background-color: #6777ef;
            border-color: #6777ef;
        }
        
        .btn-primary:hover {
            background-color: #5166ea;
            border-color: #5166ea;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
    </style>
</head>
<body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="" class="logo">
              <img
                src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}"
                alt="navbar brand"
                class="navbar-brand"
                height="20"
              />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
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
            
              <li class="nav-item active submenu">
                <a data-bs-toggle="collapse" href="#userManagement" class="collapsed" aria-expanded="false">
                  <i class="fas fa-users"></i>
                  <p>User Management</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse show" id="userManagement">
                  <ul class="nav nav-collapse">
                    <li class="active">
                      <a href="{{ route('admin.dashboard') }}">
                        <span class="sub-item">Users List</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
            
              <li class="nav-item submenu">
                <a data-bs-toggle="collapse" href="#courseTables" class="collapsed" aria-expanded="false">
                  <i class="fas fa-book"></i>
                  <p>Category Management</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="courseTables">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="{{ route('categories.index') }}">
                        <span class="sub-item">Categories List</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <!-- Navbar -->
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="" class="logo">
                <img
                  src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          
          <!-- Navbar Header -->
          <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
            <div class="container-fluid">
              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <!-- User dropdown -->
                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                    <div class="avatar-sm">
                      @if(Auth::user()->image)
                        <img src="{{ asset(Auth::user()->image) }}" alt="..." class="avatar-img rounded-circle">
                      @else
                        <img src="{{ asset('assets/img/1.png') }}" alt="..." class="avatar-img rounded-circle">
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
                              <img src="{{ asset('assets/img/profile.jpg') }}" alt="image profile" class="avatar-img rounded">
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
                        <a class="dropdown-item" href="{{ route('profile.edit', Auth::user()->id) }}">My Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
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
          <!-- End Navbar -->
        </div>

        <div class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card user-form-card">
                            <div class="card-header">
                                <h4 class="card-title"><i class="fas fa-user-edit mr-2"></i> Edit User Profile</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    
                                    <!-- Personal Information Section -->
                                    <div class="form-section">
                                        <h5 class="section-title"><i class="fas fa-user-circle"></i> Personal Information</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">First Name</label>
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                        name="name" id="name" value="{{ old('name', $user->name) }}" required>
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="lastname">Last Name</label>
                                                    <input type="text" class="form-control @error('lastname') is-invalid @enderror" 
                                                        name="lastname" id="lastname" value="{{ old('lastname', $user->lastname) }}" required>
                                                    @error('lastname')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                name="email" id="email" value="{{ old('email', $user->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                   
                                    
                                    <!-- Social Media Section -->
                                    
                                    
                                    <!-- Professional Information Section -->
                                    <div class="form-section">
                                        <h5 class="section-title"><i class="fas fa-briefcase"></i> Professional Information</h5>
                                        <div class="form-group">
                                            <label for="category">Expertise Category</label>
                                            <select class="form-control @error('category') is-invalid @enderror" 
                                                id="category" name="category" required>
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category', $user->category) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        @if(Auth::user()->role == 'Admin')
                                        <div class="form-group">
                                            <label for="role">User Role</label>
                                            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                                                <option value="User" {{ old('role', $user->role) == 'User' ? 'selected' : '' }}>User</option>
                                                <option value="Coach" {{ old('role', $user->role) == 'Coach' ? 'selected' : '' }}>Coach</option>
                                                <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                            @error('role')
                                                <div class="invalid-feedback">{{ $errors->first('role') }}</div>
                                            @enderror
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Password Section (only shown when editing own profile) -->
                                    @if (Auth::user()->id == $user->id)
                                    <div class="form-section">
                                        <h5 class="section-title"><i class="fas fa-lock"></i> Change Password</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password">New Password</label>
                                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                        name="password" id="password" placeholder="Leave blank to keep current">
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password_confirmation">Confirm New Password</label>
                                                    <input type="password" class="form-control" 
                                                        name="password_confirmation" id="password_confirmation" placeholder="Confirm new password">
                                                </div>
                                            </div>
                                        </div>
                                        <small class="text-muted">Note: Password must be at least 8 characters long</small>
                                    </div>
                                    @endif

                                    <!-- Form Actions -->
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left mr-2"></i> Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save mr-2"></i> Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    
    <!-- Core JS Files -->
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <!-- Kaiadmin JS -->
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
    
    <script>
      $(document).ready(function() {
        // Update file input label
        $('.custom-file-input').on('change', function() {
          let fileName = $(this).val().split('\\').pop();
          $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
        
        // Show password requirements on focus
        $('#password').on('focus', function() {
            $(this).next('.password-requirements').removeClass('d-none');
        });
      });
    </script>
</body>
</html>