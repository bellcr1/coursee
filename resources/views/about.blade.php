@extends('layouts.app')

@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>About Us<br></h1>
              
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">About Us<br></li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

    <!-- About Us Section -->
    <section id="about-us" class="section about-us">

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="100">
            <img src="home/assets/img/about-2.jpg" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6 order-2 order-lg-1 content" data-aos="fade-up" data-aos-delay="200">
            <h3>Empowering Learners Through Digital Education</h3>
            <p class="fst-italic">
              We are a leading e-learning platform dedicated to providing high-quality, accessible education to learners worldwide.
            </p>
            <ul>
              <li><i class="bi bi-check-circle"></i> <span>Committed to making learning accessible anytime, anywhere with our innovative platform</span></li>
              <li><i class="bi bi-check-circle"></i> <span>Offering 1000+ courses taught by industry experts and academic professionals</span></li>
              <li><i class="bi bi-check-circle"></i> <span>Providing interactive learning experiences with quizzes, projects, and peer discussions</span></li>
              <li><i class="bi bi-check-circle"></i> <span>Delivering verifiable certificates to help learners advance their careers</span></li>
              <li><i class="bi bi-check-circle"></i> <span>Continuously expanding our course catalog to meet evolving educational needs</span></li>
            </ul>
          </div>

        </div>

      </div>

    </section><!-- /About Us Section -->

  

    <!-- Mission and Vision Section -->
    <section id="mission" class="section">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="mission-box p-4 h-100">
              <h3>Our Mission</h3>
              <p>To democratize education by providing affordable, high-quality online learning opportunities that empower individuals to acquire new skills, advance their careers, and pursue their passions.</p>
            </div>
          </div>
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="vision-box p-4 h-100">
              <h3>Our Vision</h3>
              <p>To become the global leader in online education by creating the most engaging and effective learning experiences that transform lives through knowledge and skill development.</p>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Mission and Vision Section -->

    <style>
      .mission-box, .vision-box {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        height: 100%;
      }
      .mission-box {
        border-left: 4px solid #58c0f5;
      }
      .vision-box {
        border-left: 4px solid #2d4059;
      }
      .mission-box h3, .vision-box h3 {
        color: #2d4059;
        margin-bottom: 15px;
      }
    </style>

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

  <!-- Vendor JS Files -->
  <script src="home/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="home/assets/vendor/php-email-form/validate.js"></script>
  <script src="home/assets/vendor/aos/aos.js"></script>
  <script src="home/assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="home/assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="home/assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="home/assets/js/main.js"></script>

</body>

</html>
@endsection