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
                @forelse($courses as $course)
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="100">
                    <div class="course-item position-relative">
                        <!-- Replace the existing heart overlay div with this -->
                        <div class="position-relative overflow-hidden">
                            @if($course->image)
                                <img src="{{ asset($course->image) }}" class="img-fluid w-100 course-image" alt="{{ $course->title }}">
                            @else
                                <img src="home/assets/img/course-default.jpg" class="img-fluid w-100 course-image" alt="Default Course Image">
                            @endif
                            
                            <div class="heart-overlay d-flex align-items-center justify-content-center position-absolute top-0 start-0 w-100 h-100">
<button type="button" class="btn-favorite" onclick="toggleFavorite(this, '{{ $course->id }}')">
                                    <i class="bi {{ $course->isFavorited() ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Update the styles section -->
                        <style>
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
                        
                        .btn-favorite i.bi-heart-fille {
                            color: #dc3535;
                        }
                        
                        .heart-overlay {
                            position: absolute;
                            top: 0;
                            right: 0;
                            bottom: 0;
                            left: 0;
                            background: rgba(0, 0, 0, 0.2);
                            opacity: 0;
                            transition: all 0.3s ease;
                        }
                        
                        .course-item:hover .heart-overlay {
                            opacity: 1;
                        }
                        </style>
                        
                        <!-- Update the JavaScript section -->
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
                                    // Optional: Show success message
                                    showToast('Added to favorites');
                                } else {
                                    icon.classList.remove('bi-heart-fill', 'text-danger');
                                    icon.classList.add('bi-heart');
                                    // Optional: Show remove message
                                    showToast('Removed from favorites');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showToast('Error updating favorites', 'error');
                            });
                        }
                        
                        function showToast(message, type = 'success') {
                            // You can implement a toast notification here if desired
                            console.log(message);
                        }
                        </script>
                        @endpush
                        
                        <div class="course-content">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <p class="category"> @foreach ($categories as $category)
                                                    @if ($category->id == $course->category )
                                                        <td>{{  $category->name }}</td>
                                                    @endif                                                                        
                                                @endforeach</p>
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
    </section>
</main>

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

<style>
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
    
    /* Heart Overlay Styles */
    .heart-overlay {
        background: rgba(0, 0, 0, 0.3);
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .heart-icon {
        font-size: 3rem;
        color: #fd7e14;
        transition: all 0.3s ease;
        transform: scale(0.8);
    }
    
    /* Hover Effects */
    .course-item:hover .heart-overlay {
        opacity: 1;
    }
    
    .course-item:hover .heart-icon {
        transform: scale(1);
    }
    
    .course-item:hover .course-image {
        filter: blur(2px);
        transform: scale(1.03);
    }
    
    /* Course Content Styles */
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Optional: Add click handler for heart icons
        const hearts = document.querySelectorAll('.heart-icon');
        hearts.forEach(heart => {
            heart.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.toggle('bi-heart-fill');
                this.classList.toggle('bi-heart');
            });
        });
    });
</script>

@endsection