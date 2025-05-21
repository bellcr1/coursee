<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ss') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('home/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('home/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('home/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('home/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('home/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('home/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('home/assets/css/main.css') }}" rel="stylesheet">
    
    <style>
        /* My Courses Page Specific Styles */
        .my-courses-container {
            padding: 40px 0;
        }
        
        .course-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            margin-bottom: 30px;
            background: #fff;
        }
        
        .course-card:hover {
            transform: translateY(-5px);
        }
        
        .course-img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        
        .course-body {
            padding: 20px;
        }
        
        .course-title {
            font-size: 1.25rem;
            margin-bottom: 10px;
            color: #333;
        }
        
        .course-instructor {
            color: #666;
            margin-bottom: 10px;
        }
        
        .progress-container {
            margin: 15px 0;
        }
        
        .progress-text {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .progress-bar {
            height: 8px;
            border-radius: 4px;
            background: #f0f0f0;
        }
        
        .progress-fill {
            height: 100%;
            border-radius: 4px;
            background: #fc8813;
        }
        
        .course-action {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }
        
        .btn-continue {
            background: #fc8813;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
        }
        
        .btn-continue:hover {
            background: #e67a0d;
            color: white;
        }
        
        .no-courses {
            text-align: center;
            padding: 50px;
            background: #f9f9f9;
            border-radius: 10px;
        }
    </style>
</head>
<body class="page-index">
    <div id="app">
        <header id="header" class="header d-flex align-items-center sticky-top">
            <div class="container-fluid container-xl position-relative d-flex align-items-center">
                <a href="/" class="logo d-flex align-items-center me-auto">
                    <h1 class="sitename">
                        <img src="{{ asset('home/assets/img/logo1.png') }}" style="height:80px; width:auto;">
                    </h1>
                </a>

                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="{{ route('about') }}" class="nav-link">About</a></li>
                        <li><a href="/coursesss">Courses</a></li>
                        <li><a href="/trainers">Trainers</a></li>
                        <li><a href="/events">Events</a></li>
                        <li><a href="/pricing">Pricing</a></li>
                        <li><a href="/contact">Contact</a></li>
                        <li class="nav-item">
                            <form class="d-flex" action="{{ route('courses') }}" method="GET">
                                <div class="input-group">
                                    <input class="form-control" type="search" name="search" 
                                           placeholder="Search courses..." 
                                           value="{{ request('search') }}"
                                           style="border-radius: 20px 0 0 20px; max-width: 200px;">
                                    <button class="btn btn-outline-primary" type="submit"
                                            style="border-radius: 0 20px 20px 0;">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </form>
                        </li>
                        @auth
                            <li class="dropdown">
                                <a href="#"><span>{{ Auth::user()->name }}</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                                <ul>
                                    @if(Auth::user()->role == 'Admin')
                                        <li><a href="{{ route('stats.page') }}">Dashboard</a></li>
                                    @endif
                                    @if(Auth::user()->role == 'Coach')
                                        <li><a href="/courses">Coach dashboard</a></li>
                                    @endif
                                    @if(Auth::user()->role == 'Users')
                                        <li><a href="{{ route('my-courses') }}">My Courses</a></li>
                                    @endif
                                    <li><a href="{{ route('coach.profile', auth()->id()) }}">Profile</a></li>
                                    <li>
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endauth
                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>

                @guest
                    <a class="btn-getstarted" href="login">Login</a>
                @else
                    <a href="{{ route('favorite') }}" class="nav-link">
                        <i class="bi bi-heart-fill" style="color: #fc8813; font-size: 20px;"></i>
                    </a>
                @endguest
            </div>
        </header>

        <main>
            @yield('content')
        </main>
    </div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('home/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('home/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('home/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('home/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('home/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('home/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('home/assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('home/assets/js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>