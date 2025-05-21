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
        
        .input-group-text {
            background-color: #f8f9fa;
        }

        /* Course Content Styles */
        .title-block {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid #e0e0e0;
        }

        .min-titles-container {
            margin-top: 1rem;
            padding-left: 1.5rem;
        }

        .min-title-block {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .min-title {
            flex: 1;
        }

        .lesson-time {
            width: 100px;
        }

        .btn-outline-danger {
            border-color: #f1556c;
            color: #f1556c;
        }

        .btn-outline-danger:hover {
            background-color: #f1556c;
            color: white;
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
                  <p>Courses management</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse show" id="stats">
                  <ul class="nav nav-collapse">
                    <li class="active">
                      <a href="{{ route('courses.index') }}">
                        <span class="sub-item">Courses List</span>
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
                                <h4 class="card-title"><i class="fas fa-plus-circle mr-2"></i> Add New Course</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('courses.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <!-- Basic Information Section -->
                                    <div class="form-section">
                                        <h5 class="section-title"><i class="fas fa-info-circle"></i> Course Information</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">Course Title</label>
                                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                                        id="title" name="title" value="{{ old('title') }}" required placeholder="Enter course title">
                                                    @error('title')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="category">Category</label>
                                                    <select class="form-control @error('category') is-invalid @enderror" 
                                                        id="category" name="category" required>
                                                        <option value="">Select Category</option>
                                                        @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('category')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="description">Course Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                id="description" name="description" rows="4" required 
                                                placeholder="Enter course description">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Media Section -->
                                    <div class="form-section">
                                        <h5 class="section-title"><i class="fas fa-images"></i> Media Content</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="image">Course Image</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input @error('image') is-invalid @enderror" 
                                                            id="image" name="image" accept="image/*">
                                                        <label class="custom-file-label" for="image">Choose file</label>
                                                        @error('image')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="video">Course Video</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input @error('video') is-invalid @enderror" 
                                                            id="video" name="video" accept="video/*">
                                                        <label class="custom-file-label" for="video">Choose file</label>
                                                        @error('video')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Course Content Section -->
                                    <div class="form-section">
                                        <h5 class="section-title"><i class="fas fa-list-ol"></i> Course Content</h5>
                                        <div id="titles-container"></div>
                                        <button type="button" class="btn btn-secondary" onclick="addTitle()">
                                            <i class="fas fa-plus mr-2"></i>Add Chapter
                                        </button>
                                    </div>
                                    
                                    <!-- Pricing & Duration Section -->
                                    <div class="form-section">
                                        <h5 class="section-title"><i class="fas fa-tag"></i> Pricing & Duration</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="price">Course Price ($)</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                                            id="price" name="price" value="{{ old('price') }}" required placeholder="0.00">
                                                    </div>
                                                    @error('price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="duration">Duration (hours)</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                        </div>
                                                        <input type="number" class="form-control @error('duration') is-invalid @enderror" 
                                                            id="duration" name="duration" value="{{ old('duration') }}" required placeholder="Enter duration">
                                                    </div>
                                                    @error('duration')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hidden field -->
                                    <input type="hidden" id="name_cotcher" name="name_cotcher" value="{{ Auth::user()->name }} {{ Auth::user()->lastname }}">

                                    <!-- Form Actions -->
                                    <div class="action-buttons">
                                        <a href="{{ route('courses.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left mr-2"></i> Back
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save mr-2"></i> Create Course
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
      });

      // Course Content Management
      document.addEventListener('DOMContentLoaded', function() {
        let titleIndex = -1;
        let lessons;

        window.addTitle = function() {
            const titlesContainer = document.getElementById('titles-container');

            const titleBlock = document.createElement('div');
            titleBlock.classList.add('title-block');

            const titleHeader = document.createElement('div');
            titleHeader.classList.add('d-flex', 'justify-content-between', 'align-items-center', 'mb-3');
            titleIndex++;
            lessons = 0;

            const titleInput = document.createElement('input');
            titleInput.setAttribute('type', 'text');
            titleInput.setAttribute('name', `chapters[${titleIndex}][title]`);
            titleInput.setAttribute('placeholder', 'Enter Chapter Title');
            titleInput.classList.add('form-control');

            const indexInput = document.createElement('input');
            indexInput.setAttribute('type', 'hidden');
            indexInput.setAttribute('name', `titleIndex`);
            indexInput.setAttribute('value', `${titleIndex}`);
            indexInput.classList.add('form-control');

            const videoInput = document.createElement('input');
            videoInput.setAttribute('type', 'file');
            videoInput.setAttribute('name', `chapters[${titleIndex}][video]`);
            videoInput.setAttribute('accept', 'video/*');
            videoInput.classList.add('form-control', 'mt-2');

            const deleteBtn = document.createElement('button');
            deleteBtn.type = 'button';
            deleteBtn.className = 'btn btn-outline-danger btn-sm ms-2';
            deleteBtn.innerHTML = '<i class="fas fa-times"></i>';
            deleteBtn.onclick = function() {
                if (confirm('Are you sure you want to delete this chapter?')) {
                    titleBlock.remove();
                    titleIndex--;
                }
            };

            titleHeader.appendChild(titleInput);
            titleHeader.appendChild(indexInput);
            titleHeader.appendChild(deleteBtn);

            const videoContainer = document.createElement('div');
            videoContainer.classList.add('video-container', 'mb-3');
            videoContainer.appendChild(videoInput);

            const minTitlesContainer = document.createElement('div');
            minTitlesContainer.classList.add('min-titles-container');

            const addMinTitleBtn = document.createElement('button');
            addMinTitleBtn.type = 'button';
            addMinTitleBtn.className = 'btn btn-secondary btn-sm';
            addMinTitleBtn.innerHTML = '<i class="fas fa-plus mr-2"></i> Add Lesson';
            addMinTitleBtn.onclick = () => addMinTitle(minTitlesContainer, titleIndex);

            titleBlock.appendChild(titleHeader);
            titleBlock.appendChild(videoContainer);
            titleBlock.appendChild(addMinTitleBtn);
            titleBlock.appendChild(minTitlesContainer);

            titlesContainer.appendChild(titleBlock);
        };

        window.addMinTitle = function(container, parentIndex) {
            const minTitleBlock = document.createElement('div');
            minTitleBlock.classList.add('min-title-block');

            const input = document.createElement('input');
            input.setAttribute('type', 'text');
            input.setAttribute('name', `chapters[${parentIndex}][${lessons}]`);
            input.setAttribute('placeholder', 'Enter Lesson Title');
            input.classList.add('form-control', 'min-title');

            const timeInput = document.createElement('input');
            timeInput.setAttribute('type', 'number');
            timeInput.setAttribute('min', '0');
            timeInput.setAttribute('placeholder', 'Time (s)');            
            timeInput.setAttribute('name', `time[${parentIndex}][${lessons++}]`);
            timeInput.classList.add('form-control', 'lesson-time');

            const deleteBtn = document.createElement('button');
            deleteBtn.type = 'button';
            deleteBtn.className = 'btn btn-outline-danger btn-sm';
            deleteBtn.innerHTML = '<i class="fas fa-times"></i>';
            deleteBtn.onclick = function() {
                if (confirm('Are you sure you want to delete this lesson?')) {
                    minTitleBlock.remove();
                }
            };

            minTitleBlock.appendChild(input);
            minTitleBlock.appendChild(timeInput);
            minTitleBlock.appendChild(deleteBtn);
            container.appendChild(minTitleBlock);
        };
      });
    </script>
</body>
</html>
