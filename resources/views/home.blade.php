@extends('layouts.app')

@section('content')

<body class="index-page">

<main class="main">
  
    <section id="carousel" class="carousel section dark-background">
        <div class="carousel-inner">
            <!-- Slides -->
            <div class="slides">
                <!-- Slide 1 -->
                <div class="slide active">
                    <img src="{{ asset('home/assets/img/3.png') }}" alt="Image 1">
                    <div class="carousel-caption">
                        <h2 data-aos="fade-up" data-aos-delay="100">Learning Today,<br>Leading Tomorrow</h2>
                        <div class="btn-container">
                            <a href="login" class="btn-get-started">Join Us</a>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="slide">
                    <img src="{{ asset('home/assets/img/5.webp') }}" alt="Image 2">
                    <div class="carousel-caption">
                        <h2 data-aos="fade-up" data-aos-delay="100">Explore Our Courses</h2>
                        <p data-aos="fade-up" data-aos-delay="200"><b>Join thousands of students learning with us</b></p>
                        <div class="btn-container">
                            <a href="/coursesss" class="btn-get-started">View Courses</a>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 (Updated for Authenticated Certificates) -->
                <div class="slide">
                    <img src="{{ asset('home/assets/img/certificat (2).png') }}" alt="Image 3">
                    <div class="carousel-caption">
                        <h2 data-aos="fade-up" data-aos-delay="100">Receive Authenticated Certificates</h2>
                        <p data-aos="fade-up" data-aos-delay="200"><b>Get certified and showcase your skills with our authenticated certificates</b></p>
                        <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
                           
                        </div>
                    </div>
                </div>
            </div>

            <!-- Left and Right Arrows -->
            <button class="carousel-control-prev" onclick="prevSlide()">&#10094;</button>
            <button class="carousel-control-next" onclick="nextSlide()">&#10095;</button>
        </div>
    </section><!-- /Carousel Section -->
<!-- Categories Section with Styled Heading -->
<section id="categories" class="categories-section py-4 bg-white">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 text-center mb-4">
        <div class="section-heading">
          <h3 class="browse-title">Browse Categories</h3>
          <div class="heading-underline"></div>
        </div>
      </div>
    </div>

    <div class="row g-3 justify-content-center">
      @foreach ($categories as $category)
      <div class="col-xl-2 col-lg-3 col-md-4 col-6">
        <a href="{{ route('courses', ['category' => $category->id]) }}" class="category-link">
          <div class="category-item p-3 text-center">
            <i class="{{$category->icon}}" style="color: {{$category->icon_color}}"></i>
            <h4 class="h6 mb-0">{{ $category->name }}</h4>
          </div>
        </a>
      </div>
      @endforeach
    </div>
  </div>
</section>

<style>
  /* Heading Styles */
  .section-heading {
    position: relative;
    display: inline-block;
  }
  
  .browse-title {
    color:rgb(53, 159, 212); /* Your requested blue color */
    font-weight: 700;
    font-size: 1.8rem;
    letter-spacing: 0.5px;
    margin-bottom: 10px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.05);
  }
  
  .heading-underline {
    height: 3px;
    width: 60px;
    background: linear-gradient(90deg, #58c0f5, #2d4059);
    margin: 0 auto;
    border-radius: 3px;
  }

  /* Category Items */
  .category-item {
    transition: all 0.2s ease;
    border-radius: 6px;
    background: #fff;
    border: 1px solid #e0e0e0;
    height: 100%;
  }
  
  .category-link:hover .category-item {
    background:rgb(232, 240, 240);
    border-color: #58c0f5;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(88, 192, 245, 0.1);
  }
  
  .category-item h4 {
    color: #333;
    font-weight: 500;
  }
  
  /* Compact sizing */
  .category-item {
    padding: 0.75rem !important;
  }
  
  .category-item h4 {
    font-size: 0.9rem;
    margin-bottom: 0.25rem !important;
  }
</style>

   <!-- Courses Section -->
<section id="courses" class="courses section">
  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Courses</h2>
    <p>Popular Courses</p>
    <br>
  </div><!-- End Section Title -->
  <div class="container">
    <div class="row g-3"> <!-- Changed to g-3 for tighter spacing -->
      @forelse($courses->take(3) as $course)
      <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="100" style="height: 70%;">
        <div class="course-item compact-course"> <!-- Added compact-course class -->
          <img src="{{ asset($course->image) }}" class="img-fluid compact-course-img" alt="...">
          <div class="course-content compact-course-content"> <!-- Added compact class -->
            <div class="d-flex justify-content-between align-items-center mb-2"> <!-- Changed mb-3 to mb-2 -->
              @foreach ($categories as $category)
              @if ($category->id == $course->category )
                  <span class="badge bg-primary">{{  $category->name }}</span>
              @endif                                                                        
              @endforeach 
              
              <span class="text-success fw-bold">${{ number_format($course->price) }}</span>
            </div>

            <h4 class="mb-2"><a href="{{ route('courses.coursedetails', $course->id) }}">{{ $course->title }}</a></h4> <!-- Changed h3 to h4 -->
            <p class="description small text-muted mb-2">{{ Str::limit($course->description, 20) }}</p> <!-- Added small class -->
            
            <div class="trainer d-flex justify-content-between align-items-center pt-2">
              <div class="trainer-profile d-flex align-items-center">
                <img src="home/assets/img/trainers/trainer-1-2.jpg" class="rounded-circle me-2" width="30" alt="">
                <span class="small">{{ $course->name_cotcher }}</span> <!-- Changed to span and added small -->
              </div>
              <div class="trainer-rank d-flex align-items-center small text-muted">
                <i class="bi bi-person"></i>&nbsp;50
                &nbsp;&nbsp;
                <i class="bi bi-heart"></i>&nbsp;65
              </div>
            </div>
          </div>
        </div>
      </div> <!-- End Course Item-->
      @endforeach


     

      
    </div>
  </div>
</section><!-- /Courses Section -->

<style>
  /* Compact Course Styles */
  .compact-course {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
  }
  
  .compact-course:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  }
  
  .compact-course-img {
    height: 160px; /* Fixed height for images */
    width: 100%;
    object-fit: cover;
  }
  
  .compact-course-content {
    padding: 1rem; /* Reduced padding */
  }
  
  .compact-course h4 {
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
  }
  
  .compact-course .description {
    font-size: 0.85rem;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  
  .compact-course .trainer {
    border-top: 1px solid #eee;
    padding-top: 0.75rem;
    margin-top: 0.5rem;
  }
  
  /* Responsive adjustments */
  @media (max-width: 768px) {
    .compact-course-img {
      height: 140px;
    }
    
    .compact-course-content {
      padding: 0.75rem;
    }
  }

/* Add this CSS to make everything more compact */
.course-item {
    transform: scale(0.9);
    transform-origin: center top;
    margin-bottom: -20px !important;
}

.course-content {
    padding: 1rem !important;
}

.course-item img.img-fluid {
    height: 250px;
    object-fit: cover;
}

.trainer-profile img {
    width: 25px !important;
    height: 25px !important;
}

.description {
    font-size: 0.9em;
    line-height: 1.3;
    margin-bottom: 0.5rem !important;
}

.trainer-rank {
    font-size: 0.85em;
}

.price, .category {
    font-size: 0.9em;
}

h3 {
    font-size: 1.1rem;
    margin-bottom: 0.3rem !important;
}
</style>

    <!-- About Section -->
    <section id="about" class="about section">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="100">
                    <img src="home/assets/img/about.jpg" class="img-fluid" alt="">
                </div>
                <div class="col-lg-6 order-2 order-lg-1 content" data-aos="fade-up" data-aos-delay="200">
                    <h3>Transform Your Future With Our E-Learning Platform</h3>
                    <p class="fst-italic">
                        We're committed to providing high-quality, accessible education to learners worldwide through our innovative online platform.
                    </p>
                    <ul>
                        <li><i class="bi bi-check-circle"></i> <span>Access 1000+ courses across diverse disciplines from industry experts</span></li>
                        <li><i class="bi bi-check-circle"></i> <span>Learn at your own pace with our flexible online learning system</span></li>
                        <li><i class="bi bi-check-circle"></i> <span>Earn recognized certificates to boost your career prospects</span></li>
                        <li><i class="bi bi-check-circle"></i> <span>Interactive learning experience with quizzes, projects, and peer discussions</span></li>
                        <li><i class="bi bi-check-circle"></i> <span>24/7 access to course materials from any device</span></li>
                    </ul>
                    <a href="#" class="read-more"><span>Discover More</span><i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section><!-- /About Section -->
  
    <!-- Counts Section -->
    <section id="counts" class="section counts light-background">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">
                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="{{ $userCount }}" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Students</p>
                    </div>
                </div><!-- End Stats Item -->
                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="{{ $courseCount }}" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Courses</p>
                    </div>
                </div><!-- End Stats Item -->
            
                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="{{ $coachCount }}" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Trainers</p>
                    </div>
                </div><!-- End Stats Item -->
            </div>
        </div>
    </section><!-- /Counts Section -->

    <!-- Why Us Section -->
    <section id="why-us" class="section why-us">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="why-box">
                        <h3>Why Choose Our E-Learning Platform?</h3>
                        <p>
                            We stand out in the digital education space by offering an unparalleled learning experience that combines quality content, expert instructors, and cutting-edge technology to help you achieve your educational goals.
                        </p>
                        <div class="text-center">
                            <a href="#" class="more-btn"><span>Learn More</span> <i class="bi bi-chevron-right"></i></a>
                        </div>
                    </div>
                </div><!-- End Why Box -->
                <div class="col-lg-8 d-flex align-items-stretch">
                    <div class="row gy-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="col-xl-4">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-clipboard-data"></i>
                                <h4>Comprehensive Course Catalog</h4>
                                <p>From professional development to personal enrichment, we offer courses for every learning need</p>
                            </div>
                        </div><!-- End Icon Box -->
                        <div class="col-xl-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-gem"></i>
                                <h4>Expert Instructors</h4>
                                <p>Learn from industry professionals and academic experts with real-world experience</p>
                            </div>
                        </div><!-- End Icon Box -->
                        <div class="col-xl-4" data-aos="fade-up" data-aos-delay="400">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-inboxes"></i>
                                <h4>Interactive Learning</h4>
                                <p>Engage with interactive content, quizzes, and community discussions</p>
                            </div>
                        </div><!-- End Icon Box -->
                        <div class="col-xl-4" data-aos="fade-up" data-aos-delay="500">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-phone"></i>
                                <h4>Mobile Friendly</h4>
                                <p>Access your courses anytime, anywhere on any device</p>
                            </div>
                        </div><!-- End Icon Box -->
                        <div class="col-xl-4" data-aos="fade-up" data-aos-delay="600">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-award"></i>
                                <h4>Certification</h4>
                                <p>Earn verifiable certificates to showcase your new skills</p>
                            </div>
                        </div><!-- End Icon Box -->
                        <div class="col-xl-4" data-aos="fade-up" data-aos-delay="700">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-headset"></i>
                                <h4>24/7 Support</h4>
                                <p>Our dedicated support team is always ready to assist you</p>
                            </div>
                        </div><!-- End Icon Box -->
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /Why Us Section -->
  <!-- Testimonials Section -->
<section id="testimonials" class="testimonials py-5 bg-light">
  <div class="container">
    
    <!-- Section Header -->
    <div class="text-center mb-5">
      <h2 class="fw-bold mb-3">What Our Students Say</h2>
      <p class="text-muted">Real feedback from our learning community</p>
    </div>

    <!-- Feedback Toggle -->
    <div class="text-center mb-4">
      <button id="openFeedbackForm" class="btn btn-outline-primary">
        <i class="bi bi-pencil me-2"></i>Share Your Thoughts
      </button>
    </div>

    <!-- Feedback Form (Hidden) -->
    <div id="feedbackFormContainer" class="card mx-auto mb-5" style="max-width: 600px; display: none;">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="mb-0">Share Your Experience</h5>
          <button id="cancelFeedback" class="btn-close"></button>
        </div>
        <form action="{{ route('feedback.store') }}" method="POST">
          @csrf
          <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
          </div>
          <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Your Email" required>
          </div>
          <div class="mb-3">
            <div class="rating-stars text-center">
              @for($i = 1; $i <= 5; $i++)
                <i class="bi bi-star-fill rating-star mx-1" data-value="{{ $i }}" style="color: #ddd; cursor: pointer;"></i>
              @endfor
              <input type="hidden" name="rating" id="feedbackRating" value="0" required>
            </div>
          </div>
          <div class="mb-3">
            <textarea class="form-control" name="message" rows="3" placeholder="Your feedback..." required></textarea>
          </div>
          <button type="submit" class="btn btn-primary w-100">Submit Feedback</button>
        </form>
      </div>
    </div>

<!-- Premium Testimonial Slider with Full Slider Functionality -->
<section id="testimonials" class="testimonial-section">
  <div class="container">
    <div class="section-header">
     
      <h2 class="section-title">What People Say</h2>
    </div>

    <div class="testimonial-slider">
      <div class="swiper">
        <div class="swiper-wrapper">
          @foreach($feedbacks as $feedback)
          <div class="swiper-slide">
            <div class="testimonial-card">
              <div class="rating">
                @for($i = 1; $i <= 5; $i++)
                  <i class="bi {{ $i <= $feedback->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                @endfor
              </div>
              <p class="testimonial-text">"{{ $feedback->message }}"</p>
              <div class="author">
                <span class="author-name">{{ $feedback->name }}</span>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        
        <!-- Custom Arrows -->
        <div class="swiper-nav">
          <button class="swiper-button swiper-button-prev">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
          <div class="swiper-pagination"></div>
          <button class="swiper-button swiper-button-next">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M9 6L15 12L9 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
  /* Section Styling */
  .testimonial-section {
    padding: 80px 0;
    background:rgb(255, 255, 255);
    position: relative;
  }
  
  .section-header {
    text-align: center;
    margin-bottom: 60px;
  }
  
  .section-subtitle {
    display: block;
    color: #58c0f5;
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: 12px;
    text-transform: uppercase;
    font-size: 14px;
  }
  
  .section-title {
    color:rgba(14, 9, 3, 0.95);
    font-weight: 700;
    font-size: 2.5rem;
   
  }
  
  /* Testimonial Card */
  .testimonial-card {
    background: rgb(231, 248, 255);
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
    height: 100%;
    border: 1px solid rgba(0, 0, 0, 0.03);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
  }
  
  .swiper-slide-active .testimonial-card {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
  }
  
  /* Rating */
  .rating {
    color: #ffc107;
    font-size: 20px;
    margin-bottom: 20px;
    letter-spacing: 2px;
  }
  
  /* Testimonial Text */
  .testimonial-text {
    color: #555;
    font-size: 18px;
    line-height: 1.7;
    margin-bottom: 30px;
    font-style: italic;
    position: relative;
  }
  
  /* Author */
  .author {
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    padding-top: 20px;
  }
  
  .author-name {
    color: #2d4059;
    font-weight: 600;
    font-size: 16px;
  }
  
  /* Slider Container */
  .testimonial-slider {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 60px;
  }
  
  /* Custom Navigation */
  .swiper-nav {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 40px;
    position: relative;
    z-index: 10;
  }
  
  .swiper-button {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    color: #2d4059;
    position: relative;
    overflow: hidden;
  }
  
  .swiper-button::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg,rgb(191, 234, 255),rgb(1, 15, 35));
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 50%;
  }
  
  .swiper-button:hover::after {
    opacity: 1;
  }
  
  .swiper-button svg {
    width: 24px;
    height: 24px;
    position: relative;
    z-index: 2;
    transition: all 0.3s ease;
  }
  
  .swiper-button:hover svg {
    stroke: white;
    transform: scale(1.1);
  }
  
  .swiper-pagination {
    position: relative;
    bottom: auto;
    width: auto;
    margin: 0 30px;
  }
  
  .swiper-pagination-bullet {
    width: 10px;
    height: 10px;
    background: #d1d1d1;
    opacity: 1;
    margin: 0 6px !important;
    transition: all 0.3s ease;
  }
  
  .swiper-pagination-bullet-active {
    background: #58c0f5;
    width: 30px;
    border-radius: 5px;
    transform: translateY(-1px);
  }
  
  /* Responsive */
  @media (max-width: 992px) {
    .testimonial-slider {
      padding: 0 40px;
    }
    
    .testimonial-card {
      padding: 30px;
    }
  }
  
  @media (max-width: 768px) {
    .testimonial-section {
      padding: 60px 0;
    }
    
    .section-header {
      margin-bottom: 40px;
    }
    
    .testimonial-slider {
      padding: 0 20px;
    }
    
    .testimonial-text {
      font-size: 16px;
    }
    
    .swiper-button {
      width: 48px;
      height: 48px;
    }
    
    .swiper-pagination {
      margin: 0 20px;
    }
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Initialize Swiper with all slider functionality
  const testimonialSwiper = new Swiper('.testimonial-slider .swiper', {
    // Enable looping
    loop: true,
    
    // Default slides configuration
    slidesPerView: 1,
    spaceBetween: 30,
    centeredSlides: true,
    
    // Auto-play configuration
    autoplay: {
      delay: 8000,
      disableOnInteraction: false,
    },
    
    // Pagination
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    
    // Responsive breakpoints
    breakpoints: {
      768: {
        slidesPerView: 2,
      },
      1200: {
        slidesPerView: 3,
      }
    },
    
    // Callbacks for active slide effects
    on: {
      init: function() {
        // Add active class to initial active slide
        document.querySelectorAll('.swiper-slide-active .testimonial-card')[0]?.classList.add('active');
      },
      slideChange: function() {
        // Update active class on slide change
        document.querySelectorAll('.testimonial-card').forEach(card => {
          card.classList.remove('active');
        });
        document.querySelectorAll('.swiper-slide-active .testimonial-card')[0]?.classList.add('active');
      },
      touchStart: function() {
        // Pause autoplay during touch
        testimonialSwiper.autoplay.stop();
      },
      touchEnd: function() {
        // Resume autoplay after touch
        testimonialSwiper.autoplay.start();
      }
    }
  });

  // Pause on hover for better UX
  const sliderContainer = document.querySelector('.testimonial-slider');
  sliderContainer.addEventListener('mouseenter', function() {
    testimonialSwiper.autoplay.stop();
  });
  sliderContainer.addEventListener('mouseleave', function() {
    testimonialSwiper.autoplay.start();
  });
});
</script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Toggle feedback form
    const openFeedbackBtn = document.getElementById('openFeedbackForm');
    const feedbackFormContainer = document.getElementById('feedbackFormContainer');
    const cancelFeedbackBtn = document.getElementById('cancelFeedback');
    
    openFeedbackBtn.addEventListener('click', function() {
      feedbackFormContainer.style.display = feedbackFormContainer.style.display === 'none' ? 'block' : 'none';
    });
    
    cancelFeedbackBtn.addEventListener('click', function() {
      feedbackFormContainer.style.display = 'none';
    });
    
    // Star rating functionality
    const stars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('feedbackRating');
    
    stars.forEach(star => {
      star.addEventListener('click', function() {
        const value = parseInt(this.getAttribute('data-value'));
        ratingInput.value = value;
        
        stars.forEach((s, index) => {
          if (index < value) {
            s.classList.add('active');
            s.classList.add('bi-star-fill');
            s.classList.remove('bi-star');
          } else {
            s.classList.remove('active');
            s.classList.remove('bi-star-fill');
            s.classList.add('bi-star');
          }
        });
      });
    });
  });
</script>
   
</main>

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
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> Distributed by <a href=“https://themewagon.com>ThemeWagon
        </div>
    </div>
</footer>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

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
    
    .course-img-container {
        position: relative;
        overflow: hidden;
    }
    
    .course-image {
        transition: all 0.3s ease;
        width: 100%;
        height: auto;
    }
    
    /* Heart Overlay Styles */
    .heart-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.3);
        opacity: 0;
        display: flex;
        align-items: center;
        justify-content: center;
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
</style>

<script>
    // Carousel functionality
    let currentSlide = 0;
    const slides = document.querySelector('.slides');
    const totalSlides = document.querySelectorAll('.slide').length;

    function showSlide(index) {
        if (index >= totalSlides) {
            currentSlide = 0;
        } else if (index < 0) {
            currentSlide = totalSlides - 1;
        } else {
            currentSlide = index;
        }
        const offset = -currentSlide * 100;
        slides.style.transform = `translateX(${offset}%)`;
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    setInterval(nextSlide, 5000);

    // Initialize PureCounter
    new PureCounter();
</script>

</body>
@endsection