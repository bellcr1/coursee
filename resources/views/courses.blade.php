@extends('layouts.app')

@section('content')

<main class="main">
    <div class="page-title" data-aos="fade">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>Courses</h1>
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Courses</li>
          </ol>
        </div>
      </nav>
    </div>

    <section id="courses" class="courses section">
        <div class="container">
            <div class="row">
                <!-- Category Section -->
                <div class="col-lg-3">
                    <div class="category-sidebar bg-white p-3 rounded shadow-sm mb-4">
                        <h5 class="mb-3 border-bottom pb-2"><i class="bi bi-list-ul me-2"></i> Categories</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-1">
                                <a class="nav-link {{ !request('category') ? 'active' : '' }}" href="{{ route('courses') }}">
                                    <i class="bi bi-grid me-2"></i> All Categories
                                </a>
                            </li>
                            @foreach($categories as $category)
                            <li class="nav-item mb-1">
                                <a class="nav-link {{ request('category') == $category->id ? 'active' : '' }}" 
                                   href="{{ route('courses', ['category' => $category->id]) }}">
                                    <i class="{{ $category->icon }} me-2"></i> {{ $category->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                
                <!-- Courses Grid -->
                <div class="col-lg-9">
                    <div class="row">
                        @forelse($courses as $course)
                        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mb-4" data-aos="zoom-in" data-aos-delay="100">
                            <div class="course-item position-relative">
                                <div class="position-relative overflow-hidden">
                                    @if($course->image)
                                        <img src="{{ asset($course->image) }}" class="img-fluid w-100 course-image" alt="{{ $course->title }}">
                                    @else
                                        <img src="home/assets/img/course-default.jpg" class="img-fluid w-100 course-image" alt="Default Course Image">
                                    @endif
                                    
                                    <div class="heart-overlay d-flex align-items-center justify-content-center position-absolute top-0 start-0 w-100 h-100">
                                        <button type="button" class="btn-favorite" onclick="toggleFavorite(this, '{{ $course->id }}')">
                                            <i class="bi {{ $course->isFavorited() ? 'bi-heart text-danger' : 'bi-heart' }}"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="course-content">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <p class="category"> 
                                            @foreach ($categories as $category)
                                                @if ($category->id == $course->category )
                                                    {{ $category->name }}
                                                @endif                                                                        
                                            @endforeach
                                        </p>
                                        <p class="price">${{ number_format($course->price, 2) }}</p>
                                    </div>

                                    <h3>
                                        <a href="{{ route('courses.coursedetails', $course->id) }}">{{ $course->title }}</a>
                                    </h3>
                                    <p class="description">{{ Str::limit($course->description, 100) }}</p>
                                    
                                    <div class="trainer d-flex justify-content-between align-items-center">
                                        <div class="trainer-profile d-flex align-items-center">
                                            <a href="" class="trainer-link">{{ $course->name_cotcher }}</a>
                                        </div>
                                        <div class="trainer-rank d-flex align-items-center">
                                            <i class="bi bi-clock"></i>&nbsp;{{ $course->duration }}h
                                            @if($course->video)
                                                &nbsp;&nbsp;
                                                <i class="bi bi-camera-video"></i>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5">
                            <div class="alert alert-info">No courses found</div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>

<div id="preloader"></div>

<footer id="footer" class="footer position-relative light-background">
    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6 footer-about">
                <a href="index.html" class="logo d-flex align-items-center">
                    <span class="sitename">Mentor</span>
                </a>
                <div class="footer-contact pt-3">
                    <p>A108 Adam Street</p>
                    <p>New York, NY 535022</p>
                    <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
                    <p><strong>Email:</strong> <span>info@example.com</span></p>
                </div>
                <div class="social-links d-flex mt-4">
                    <a href=""><i class="bi bi-twitter-x"></i></a>
                    <a href=""><i class="bi bi-facebook"></i></a>
                    <a href=""><i class="bi bi-instagram"></i></a>
                    <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Useful Links</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Terms of service</a></li>
                    <li><a href="#">Privacy policy</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Our Services</h4>
                <ul>
                    <li><a href="#">Web Design</a></li>
                    <li><a href="#">Web Development</a></li>
                    <li><a href="#">Product Management</a></li>
                    <li><a href="#">Marketing</a></li>
                    <li><a href="#">Graphic Design</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-12 footer-newsletter">
                <h4>Our Newsletter</h4>
                <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
                <form action="forms/newsletter.php" method="post" class="php-email-form">
                    <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>
                    <div class="loading">Loading</div>
                    <div class="error-message"></div>
                    <div class="sent-message">Your subscription request has been sent. Thank you!</div>
                </form>
            </div>
        </div>
    </div>

    <div class="container copyright text-center mt-4">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">Mentor</strong> <span>All Rights Reserved</span></p>
        <div class="credits">
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </div>
</footer>

<!-- Vendor JS Files -->
<script src="home/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="home/assets/vendor/php-email-form/validate.js"></script>
<script src="home/assets/vendor/aos/aos.js"></script>
<script src="home/assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="home/assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="home/assets/vendor/swiper/swiper-bundle.min.js"></script>

<!-- Main JS File -->
<script src="home/assets/js/main.js"></script>

@push('scripts')
<script>
function toggleFavorite(button, courseId) {
    fetch(`/favorite/toggle/${courseId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        const icon = button.querySelector('i');
        if (data.status === 'added') {
            icon.classList.remove('bi-heart');
            icon.classList.add('bi-heart-fill', 'text-danger');
        } else {
            icon.classList.remove('bi-heart-fill', 'text-danger');
            icon.classList.add('bi-heart');
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endpush

<style>
    /* Category Section Styles */
    .category-sidebar {
        position: sticky;
        top: 20px;
        height: fit-content;
    }
    
    .category-sidebar h5 {
        font-size: 1.1rem;
        color: #333;
    }
    
    .category-sidebar .nav-link {
        color: #555;
        padding: 8px 12px;
        border-radius: 5px;
        transition: all 0.2s ease;
    }
    
    .category-sidebar .nav-link:hover {
        background-color: #f8f9fa;
        color: #333;
    }
    
    .category-sidebar .nav-link.active {
        background-color: #f0f5ff;
        color: #4e54c8;
        font-weight: 500;
    }
    
    .category-sidebar .nav-link i {
        width: 20px;
        text-align: center;
    }
    
    /* Course Item Styles */
    .course-item {
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .course-image {
        transition: all 0.3s ease;
    }
    
    .heart-overlay {
        background: rgba(0, 0, 0, 0.3);
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .btn-favorite {
        background: transparent;
        border: none;
        padding: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        align-items: center;
        z-index: 10;
    }
    
    .btn-favorite:hover {
        transform: scale(1.2);
    }
    
    .btn-favorite i {
        font-size: 50px;
        color: rgb(255, 255, 255);
        text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
    }
    
    .btn-favorite i.bi-heart-fill {
        color:rgb(233, 152, 38);
    }
    
    .course-item:hover .heart-overlay {
        opacity: 1;
    }
    
    .course-item:hover .course-image {
        filter: blur(2px);
        transform: scale(1.03);
    }
    
    .course-content {
        padding: 1.5rem;
        background: white;
        flex-grow: 1;
    }
    
    .category {
        font-size: 0.9rem;
        color: #6c757d;
    }
    
    .price {
        font-weight: 600;
        color: #28a745;
    }
    
    .description {
        color: #6c757d;
        font-size: 0.95rem;
    }
    
    .trainer-profile img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 10px;
    }
</style>

@endsection