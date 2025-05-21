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
<section id="testimonials" class="testimonials section">

  <!-- Section Title with Add Review Button -->
  <div class="container section-title" data-aos="fade-up">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h2>Testimonials</h2>
        <p>What are they saying</p>
      </div>
      <button id="openReviewForm" class="btn btn-primary" style="background-color: #2d4059; border: none;">
        <i class="bi bi-plus-circle"></i> Add Review
      </button>
    </div>
  </div><!-- End Section Title -->

  <!-- Review Form (Initially Hidden) -->
  <div id="reviewFormContainer" class="container mb-5" style="display: none;" data-aos="fade-up">
    <div class="review-form bg-white p-4 rounded shadow">
      <h4 class="mb-4">Share Your Experience</h4>
      <form id="testimonialForm">
        <div class="row mb-3">
          <div class="col-md-6">
            <div class="form-group">
              <label for="reviewName">Your Name</label>
              <input type="text" class="form-control" id="reviewName" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="reviewTitle">Your Title/Role</label>
              <input type="text" class="form-control" id="reviewTitle" required>
            </div>
          </div>
        </div>
        
        <div class="form-group mb-3">
          <label>Your Rating</label>
          <div class="rating-stars">
            <i class="bi bi-star rating-star" data-value="1"></i>
            <i class="bi bi-star rating-star" data-value="2"></i>
            <i class="bi bi-star rating-star" data-value="3"></i>
            <i class="bi bi-star rating-star" data-value="4"></i>
            <i class="bi bi-star rating-star" data-value="5"></i>
            <input type="hidden" id="reviewRating" value="0" required>
          </div>
        </div>
        
        <div class="form-group mb-3">
          <label for="reviewText">Your Testimonial</label>
          <textarea class="form-control" id="reviewText" rows="4" required></textarea>
        </div>
        
        <div class="d-flex justify-content-end">
          <button type="button" id="cancelReview" class="btn btn-outline-secondary me-2">Cancel</button>
          <button type="submit" class="btn btn-primary" style="background-color: #2d4059; border: none;">Submit Review</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Testimonials Slider -->
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="swiper init-swiper">
      <script type="application/json" class="swiper-config">
        {
          "loop": true,
          "speed": 600,
          "autoplay": {
            "delay": 5000
          },
          "slidesPerView": "auto",
          "pagination": {
            "el": ".swiper-pagination",
            "type": "bullets",
            "clickable": true
          },
          "breakpoints": {
            "320": {
              "slidesPerView": 1,
              "spaceBetween": 40
            },
            "1200": {
              "slidesPerView": 2,
              "spaceBetween": 20
            }
          }
        }
      </script>
      <div class="swiper-wrapper">

        <div class="swiper-slide">
          <div class="testimonial-wrap">
            <div class="testimonial-item">
              <img src="home/assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
              <h3>Saul Goodman</h3>
              <h4>Ceo &amp; Founder</h4>
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
              <p>
                <i class="bi bi-quote quote-icon-left"></i>
                <span>Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.</span>
                <i class="bi bi-quote quote-icon-right"></i>
              </p>
            </div>
          </div>
        </div><!-- End testimonial item -->

        <div class="swiper-slide">
          <div class="testimonial-wrap">
            <div class="testimonial-item">
              <img src="home/assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
              <h3>Sara Wilsson</h3>
              <h4>Designer</h4>
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
              <p>
                <i class="bi bi-quote quote-icon-left"></i>
                <span>Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.</span>
                <i class="bi bi-quote quote-icon-right"></i>
              </p>
            </div>
          </div>
        </div><!-- End testimonial item -->

        <div class="swiper-slide">
          <div class="testimonial-wrap">
            <div class="testimonial-item">
              <img src="home/assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
              <h3>Jena Karlis</h3>
              <h4>Store Owner</h4>
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
              <p>
                <i class="bi bi-quote quote-icon-left"></i>
                <span>Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.</span>
                <i class="bi bi-quote quote-icon-right"></i>
              </p>
            </div>
          </div>
        </div><!-- End testimonial item -->

        <div class="swiper-slide">
          <div class="testimonial-wrap">
            <div class="testimonial-item">
              <img src="home/assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
              <h3>Matt Brandon</h3>
              <h4>Freelancer</h4>
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
              <p>
                <i class="bi bi-quote quote-icon-left"></i>
                <span>Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.</span>
                <i class="bi bi-quote quote-icon-right"></i>
              </p>
            </div>
          </div>
        </div><!-- End testimonial item -->

        <div class="swiper-slide">
          <div class="testimonial-wrap">
            <div class="testimonial-item">
              <img src="home/assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
              <h3>John Larson</h3>
              <h4>Entrepreneur</h4>
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
              <p>
                <i class="bi bi-quote quote-icon-left"></i>
                <span>Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.</span>
                <i class="bi bi-quote quote-icon-right"></i>
              </p>
            </div>
          </div>
        </div><!-- End testimonial item -->

      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
</section><!-- /Testimonials Section -->

<style>
  /* Review Form Styles */
  .review-form {
    border: 1px solid #e0e0e0;
  }
  
  .rating-stars {
    font-size: 24px;
    color: #ddd;
    cursor: pointer;
  }
  
  .rating-star {
    transition: color 0.2s;
  }
  
  .rating-star:hover,
  .rating-star.active {
    color: #ffc107;
  }
  
  /* Testimonial Form Animation */
  #reviewFormContainer {
    transition: all 0.3s ease;
  }
  
  /* Original Testimonial Styles */
  .testimonials .testimonial-item {
    box-sizing: content-box;
    padding: 30px;
    margin: 40px 30px;
    background: #fff;
    min-height: 320px;
    display: flex;
    flex-direction: column;
    text-align: center;
    transition: 0.3s;
  }
  
  .testimonials .testimonial-item .stars {
    margin-bottom: 15px;
  }
  
  .testimonials .testimonial-item .stars i {
    color: #ffc107;
    margin: 0 1px;
  }
  
  .testimonials .testimonial-item .testimonial-img {
    width: 90px;
    border-radius: 50%;
    border: 4px solid #fff;
    margin: 0 auto;
    box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);
  }
  
  .testimonials .testimonial-item h3 {
    font-size: 18px;
    font-weight: bold;
    margin: 10px 0 5px 0;
  }
  
  .testimonials .testimonial-item h4 {
    font-size: 14px;
    color: #6c757d;
    margin: 0;
  }
  
  .testimonials .testimonial-item .quote-icon-left,
  .testimonials .testimonial-item .quote-icon-right {
    color: #f8d1d3;
    font-size: 26px;
  }
  
  .testimonials .testimonial-item .quote-icon-left {
    display: inline-block;
    left: -5px;
    position: relative;
  }
  
  .testimonials .testimonial-item .quote-icon-right {
    display: inline-block;
    right: -5px;
    position: relative;
    top: 10px;
  }
  
  .testimonials .testimonial-item p {
    font-style: italic;
    margin: 0 auto 15px auto;
  }
  
  .testimonials .swiper-pagination {
    margin-top: 20px;
    position: relative;
  }
  
  .testimonials .swiper-pagination .swiper-pagination-bullet {
    width: 12px;
    height: 12px;
    background-color: #fff;
    opacity: 1;
    border: 1px solid #2d4059;
  }
  
  .testimonials .swiper-pagination .swiper-pagination-bullet-active {
    background-color: #2d4059;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Toggle review form
    const openReviewBtn = document.getElementById('openReviewForm');
    const reviewFormContainer = document.getElementById('reviewFormContainer');
    const cancelReviewBtn = document.getElementById('cancelReview');
    
    openReviewBtn.addEventListener('click', function() {
      reviewFormContainer.style.display = reviewFormContainer.style.display === 'none' ? 'block' : 'none';
    });
    
    cancelReviewBtn.addEventListener('click', function() {
      reviewFormContainer.style.display = 'none';
    });
    
    // Star rating functionality
    const stars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('reviewRating');
    
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
    
    // Form submission (front-end only for now)
    document.getElementById('testimonialForm').addEventListener('submit', function(e) {
      e.preventDefault();
      alert('Thank you for your review!');
      this.reset();
      reviewFormContainer.style.display = 'none';
      
      // Reset stars
      stars.forEach(star => {
        star.classList.remove('active');
        star.classList.remove('bi-star-fill');
        star.classList.add('bi-star');
      });
      ratingInput.value = '0';
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